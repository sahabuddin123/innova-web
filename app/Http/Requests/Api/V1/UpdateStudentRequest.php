<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class UpdateStudentRequest
 *
 * Validates request payload for updating an existing student.
 *
 * @package App\Http\Requests\Api\V1
 */
class UpdateStudentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'course_id'      => 'nullable|integer|exists:courses,id',
            'batch_id'       => 'nullable|integer|exists:batchs,id',
            'branch_id'      => 'nullable|integer',
            'user_id'        => 'nullable|integer|exists:users,id',
            'sname'          => 'sometimes|required|string|max:191',
            'gender'         => 'sometimes|required|string|max:50',
            'religion'       => 'sometimes|required|string|max:50',
            'phone'          => 'nullable|string|max:50',
            'g_name'         => 'sometimes|required|string|max:191',
            'g_phone'        => 'sometimes|required|string|max:50',
            'rel_g'          => 'sometimes|required|string|max:50',
            'course_fee'     => 'sometimes|required|string|max:50',
            'discount'       => 'nullable|string|max:50',
            'balance'        => 'nullable|string|max:50',
            'admission_date' => 'sometimes|required|date',
            'dob'            => 'nullable|date',
            'bloodgroup'     => 'nullable|string|max:20',
            'height'         => 'nullable|string|max:50',
            'weight'         => 'nullable|string|max:50',
            'nid'            => 'nullable|string|max:50',
            'last_school'    => 'nullable|string|max:191',
            'f_name'         => 'nullable|string|max:191',
            'f_phone'        => 'nullable|string|max:50',
            'm_name'         => 'nullable|string|max:191',
            'm_phone'        => 'nullable|string|max:50',
            'ref'            => 'nullable|string|max:191',
            'image'          => 'nullable|string|max:255',
            'IsRegister'     => 'nullable|integer|in:0,1',
            'IsActive'       => 'nullable|integer|in:1,2,3,4,5',
        ];
    }
}
