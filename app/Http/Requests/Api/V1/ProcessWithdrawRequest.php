<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class ProcessWithdrawRequest
 *
 * Validates processing remarks for withdrawal approval and rejection endpoints.
 *
 * @package App\Http\Requests\Api\V1
 */
class ProcessWithdrawRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}
