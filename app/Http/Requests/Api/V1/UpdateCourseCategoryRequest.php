<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateCourseCategoryRequest
 *
 * Validates request payload for updating an existing course category.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateCourseCategoryRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'CourseCategoris' => 'sometimes|required|string|max:191',
            'icon'            => 'nullable|string|max:255',
            'fontawesome'     => 'nullable|string|max:100',
            'isFeature'       => 'nullable|integer|in:0,1',
            'IsActive'        => 'nullable|integer|in:0,1',
        ];
    }
}
