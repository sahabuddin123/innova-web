<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreBranchRequest
 *
 * Validates branch creation requests.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreBranchRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'bname'     => 'required|string|max:191',
            'baddress'  => 'required|string|max:255',
            'startdate' => 'required|date',
            'btype'     => 'nullable|integer',
            'IsActive'  => 'nullable|integer|in:0,1',
        ];
    }
}
