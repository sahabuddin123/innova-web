<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class BkashService
 *
 * Encapsulates communication with the bKash checkout payment gateway API (v1.2.0-beta).
 * Supports token grant, payment creation, execution, status query, and transaction search.
 *
 * @package App\Services
 */
class BkashService
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string|null
     */
    protected $appKey;

    /**
     * @var string|null
     */
    protected $appSecret;

    /**
     * @var string|null
     */
    protected $userName;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * BkashService constructor.
     *
     * @param array|null $config
     */
    public function __construct(?array $config = null)
    {
        $cfg = $config ?? config('services.bkash', []);

        $this->baseUrl   = rtrim($cfg['base_url'] ?? 'https://checkout.pay.bka.sh/v1.2.0-beta', '/');
        $this->appKey    = $cfg['app_key'] ?? env('BKASH_CHECKOUT_APP_KEY');
        $this->appSecret = $cfg['app_secret'] ?? env('BKASH_CHECKOUT_APP_SECRET');
        $this->userName  = $cfg['user_name'] ?? env('BKASH_CHECKOUT_USER_NAME');
        $this->password  = $cfg['password'] ?? env('BKASH_CHECKOUT_PASSWORD');
    }

    /**
     * Determine whether the gateway credentials are fully configured.
     *
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->appKey) && !empty($this->appSecret) && !empty($this->userName) && !empty($this->password);
    }

    /**
     * Grant a fresh access token from bKash server.
     *
     * @return string
     * @throws Exception
     */
    public function grantToken(): string
    {
        if (!$this->isConfigured()) {
            throw new Exception('bKash payment gateway credentials are not configured.');
        }

        $headers = [
            'Content-Type: application/json',
            'username: ' . $this->userName,
            'password: ' . $this->password,
        ];

        $payload = [
            'app_key'    => $this->appKey,
            'app_secret' => $this->appSecret,
        ];

        $response = $this->sendRequest('/checkout/token/grant', 'POST', $headers, json_encode($payload));
        $data = json_decode($response, true);

        if (!is_array($data) || empty($data['id_token'])) {
            $msg = $data['errorMessage'] ?? 'Failed to obtain access token from bKash gateway';
            throw new Exception($msg);
        }

        return $data['id_token'];
    }

    /**
     * Create a payment intent on bKash.
     *
     * @param float|string $amount
     * @param string|null $invoiceNumber
     * @return array
     * @throws Exception
     */
    public function createPayment($amount, ?string $invoiceNumber = null): array
    {
        $token = $this->grantToken();
        $invoice = $invoiceNumber ?: 'Inv_' . Str::random(8);

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $token,
            'X-APP-Key: ' . $this->appKey,
        ];

        $payload = [
            'amount'                => (string) $amount,
            'currency'              => 'BDT',
            'intent'                => 'sale',
            'merchantInvoiceNumber' => $invoice,
        ];

        $response = $this->sendRequest('/checkout/payment/create', 'POST', $headers, json_encode($payload));
        $data = json_decode($response, true);

        if (!is_array($data) || empty($data['paymentID'])) {
            $msg = $data['errorMessage'] ?? 'Failed to initialize payment with bKash';
            throw new Exception($msg);
        }

        return $data;
    }

    /**
     * Execute and capture an authorized payment by paymentID.
     *
     * @param string $paymentID
     * @return array
     * @throws Exception
     */
    public function executePayment(string $paymentID): array
    {
        $token = $this->grantToken();

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $token,
            'X-APP-Key: ' . $this->appKey,
        ];

        $response = $this->sendRequest('/checkout/payment/execute/' . $paymentID, 'POST', $headers);
        $data = json_decode($response, true);

        // Fallback to query if execute returned transient error or empty
        if (!is_array($data) || (isset($data['errorCode']) && $data['errorCode'] !== '0000')) {
            $queryData = $this->queryPayment($paymentID);
            if (!empty($queryData['transactionStatus']) && strtolower($queryData['transactionStatus']) === 'completed') {
                return $queryData;
            }
        }

        return is_array($data) ? $data : ['errorMessage' => 'Invalid gateway response'];
    }

    /**
     * Query payment status by paymentID.
     *
     * @param string $paymentID
     * @return array
     * @throws Exception
     */
    public function queryPayment(string $paymentID): array
    {
        $token = $this->grantToken();

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $token,
            'X-APP-Key: ' . $this->appKey,
        ];

        $response = $this->sendRequest('/checkout/payment/query/' . $paymentID, 'GET', $headers);
        return json_decode($response, true) ?: [];
    }

    /**
     * Search transaction by bKash trxID.
     *
     * @param string $trxID
     * @return array
     * @throws Exception
     */
    public function searchTransaction(string $trxID): array
    {
        $token = $this->grantToken();

        $headers = [
            'Content-Type: application/json',
            'Authorization: ' . $token,
            'X-APP-Key: ' . $this->appKey,
        ];

        $response = $this->sendRequest('/checkout/payment/search/' . $trxID, 'GET', $headers);
        return json_decode($response, true) ?: [];
    }

    /**
     * Execute an HTTP cURL request to the bKash API.
     *
     * @param string $endpoint
     * @param string $method
     * @param array $headers
     * @param string|null $body
     * @return string
     * @throws Exception
     */
    protected function sendRequest(string $endpoint, string $method = 'GET', array $headers = [], ?string $body = null): string
    {
        $url = $this->baseUrl . $endpoint;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        if ($body !== null && in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($err) {
            Log::channel('bkash')->error('bKash cURL failure: ' . $err, ['endpoint' => $endpoint]);
            throw new Exception('Payment gateway network failure: ' . $err);
        }

        return (string) $response;
    }
}
