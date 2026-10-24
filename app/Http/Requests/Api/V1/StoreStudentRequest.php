<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreStudentRequest
 *
 * Validates request payload for creating a new enrolled student.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreStudentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'course_id'      => 'required|integer|exists:courses,id',
            'batch_id'       => 'required|integer|exists:batchs,id',
            'branch_id'      => 'nullable|integer',
            'user_id'        => 'nullable|integer|exists:users,id',
            'sname'          => 'required|string|max:191',
            'gender'         => 'required|string|max:50',
            'religion'       => 'required|string|max:50',
            'phone'          => 'nullable|string|max:50',
            'g_name'         => 'required|string|max:191',
            'g_phone'        => 'required|string|max:50',
            'rel_g'          => 'required|string|max:50',
            'course_fee'     => 'required|string|max:50',
            'discount'       => 'nullable|string|max:50',
            'balance'        => 'nullable|string|max:50',
            'admission_date' => 'required|date',
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
