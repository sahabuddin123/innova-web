<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateFeeTransactionRequest
 *
 * Validates updates to non-critical metadata of an existing fee transaction.
 * To maintain financial integrity, student_id and gateway references cannot be changed.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateFeeTransactionRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'paidamount'  => 'required|numeric|min:1',
            'paymentType' => 'required|integer|in:1,2',
            'paiddate'    => 'required|date',
            'paidremark'  => 'required|string|max:255',
        ];
    }
}
