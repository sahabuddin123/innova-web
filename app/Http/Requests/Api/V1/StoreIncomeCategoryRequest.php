<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreIncomeCategoryRequest
 *
 * Validates income category creation requests.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreIncomeCategoryRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'categoris' => 'required|string|max:191',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'IsActive'  => 'nullable|integer|in:0,1',
        ];
    }
}
