<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreBatchRequest
 *
 * Validates request payload for creating an academic batch.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreBatchRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'batchnum'  => 'required|string|max:191',
            'totalseat' => 'required|string|max:50',
            'stuff_id'  => 'nullable|integer',
            'startdate' => 'nullable|date',
            'enddate'   => 'nullable|date|after_or_equal:startdate',
            'day1'      => 'nullable|integer',
            'schedule1' => 'nullable|string|max:191',
            'day2'      => 'nullable|integer',
            'schedule2' => 'nullable|string|max:191',
            'day3'      => 'nullable|integer',
            'schedule3' => 'nullable|string|max:191',
            'day4'      => 'nullable|integer',
            'schedule4' => 'nullable|string|max:191',
            'day5'      => 'nullable|integer',
            'schedule5' => 'nullable|string|max:191',
            'day6'      => 'nullable|integer',
            'schedule6' => 'nullable|string|max:191',
            'day7'      => 'nullable|integer',
            'schedule7' => 'nullable|string|max:191',
            'IsActive'  => 'nullable|integer|in:0,1,2,3',
        ];
    }
}
