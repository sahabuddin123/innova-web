<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateBranchRequest
 *
 * Validates branch update requests.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateBranchRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'bname'     => 'sometimes|required|string|max:191',
            'baddress'  => 'sometimes|required|string|max:255',
            'startdate' => 'sometimes|required|date',
            'btype'     => 'nullable|integer',
            'IsActive'  => 'nullable|integer|in:0,1',
        ];
    }
}
