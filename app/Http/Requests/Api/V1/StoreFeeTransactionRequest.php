<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreFeeTransactionRequest
 *
 * Validates manual or counter fee collection recorded by authorized administrators.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreFeeTransactionRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'student_id'  => 'required|integer|exists:students,id',
            'paidamount'  => 'required|numeric|min:1',
            'paymentType' => 'required|integer|in:1,2',
            'paiddate'    => 'required|date',
            'paidremark'  => 'required|string|max:255',
            'channel'     => 'nullable|integer|in:1,2',
        ];
    }
}
