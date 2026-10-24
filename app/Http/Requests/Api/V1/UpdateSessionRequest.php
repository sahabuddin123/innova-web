<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateSessionRequest
 *
 * Validates request payload for updating an academic session.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateSessionRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sessionName' => 'sometimes|required|string|max:191',
            'startdate'   => 'nullable|date',
            'enddate'     => 'nullable|date|after_or_equal:startdate',
            'IsActive'    => 'nullable|integer|in:0,1',
        ];
    }
}
