<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateShareholderRequest
 *
 * Validates shareholder update requests.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateShareholderRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => 'sometimes|required|string|max:191',
            'designation' => 'sometimes|required|string|max:191',
            'email'       => 'nullable|email|max:150',
            'phone'       => 'nullable|string|max:50',
            'address'     => 'sometimes|required|string|max:255',
            'shareType'   => 'sometimes|required|integer',
            'isActive'    => 'sometimes|required|in:0,1',
            'nid'         => 'nullable|string|max:100',
            'image'       => 'nullable|string|max:255',
        ];
    }
}
