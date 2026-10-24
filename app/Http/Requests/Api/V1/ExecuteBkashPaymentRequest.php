<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class ExecuteBkashPaymentRequest
 *
 * Validates request payload to execute and capture a bKash checkout payment.
 *
 * @package App\Http\Requests\Api\V1
 */
class ExecuteBkashPaymentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'payment_id'   => 'required|string|max:255',
            'student_id'   => 'nullable|integer|exists:students,id',
            'payment_type' => 'nullable|integer|in:1,2',
        ];
    }
}
