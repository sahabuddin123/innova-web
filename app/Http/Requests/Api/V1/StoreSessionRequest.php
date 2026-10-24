<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreSessionRequest
 *
 * Validates request payload for creating an academic session.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreSessionRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sessionName' => 'required|string|max:191',
            'startdate'   => 'nullable|date',
            'enddate'     => 'nullable|date|after_or_equal:startdate',
            'IsActive'    => 'nullable|integer|in:0,1',
        ];
    }
}
