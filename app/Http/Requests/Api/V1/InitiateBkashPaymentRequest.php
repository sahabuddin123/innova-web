<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class InitiateBkashPaymentRequest
 *
 * Validates request payload to initiate a bKash checkout session.
 *
 * @package App\Http\Requests\Api\V1
 */
class InitiateBkashPaymentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'student_id'   => 'nullable|integer|exists:students,id',
            'amount'       => 'required|numeric|min:1',
            'payment_type' => 'nullable|integer|in:1,2',
        ];
    }
}
