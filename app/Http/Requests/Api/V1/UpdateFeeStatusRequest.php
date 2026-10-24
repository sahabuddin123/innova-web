<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateFeeStatusRequest
 *
 * Validates transaction approval status updates.
 * Status 0 = Approved, Status 1 = Pending.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateFeeStatusRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'status' => 'required|integer|in:0,1',
        ];
    }
}
