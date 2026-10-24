<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateCourseRequest
 *
 * Validates request payload for updating an existing course.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateCourseRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'           => 'sometimes|required|string|max:191',
            'coursefee'      => 'sometimes|required|string|max:50',
            'category_id'    => 'nullable|integer|exists:course_categories,id',
            'shortTitle'     => 'nullable|string|max:100',
            'courseduration' => 'nullable|string|max:100',
            'lacture'        => 'nullable|string|max:100',
            'totalmoduls'    => 'nullable|string|max:100',
            'totalproject'   => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'overview'       => 'nullable|string',
            'curriculum'     => 'nullable|string',
            'software'       => 'nullable|string',
            'trainee'        => 'nullable|string',
            'jobPlacement'   => 'nullable|string',
            'jobPosition'    => 'nullable|string',
            'IsActive'       => 'nullable|integer|in:0,1',
            'featured'       => 'nullable|integer|in:0,1',
            'image'          => 'nullable|string|max:255',
            'video'          => 'nullable|string|max:255',
            'Instructor'     => 'nullable|string|max:191',
            'Discount'       => 'nullable|numeric|min:0',
        ];
    }
}
