<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreShareholderRequest
 *
 * Validates shareholder creation requests.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreShareholderRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:191',
            'designation' => 'required|string|max:191',
            'email'       => 'nullable|email|max:150',
            'phone'       => 'nullable|string|max:50',
            'address'     => 'required|string|max:255',
            'shareType'   => 'required|integer',
            'isActive'    => 'required|in:0,1',
            'nid'         => 'nullable|string|max:100',
            'image'       => 'nullable|string|max:255',
        ];
    }
}
