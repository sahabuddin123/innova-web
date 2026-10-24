<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreIncomeRequest
 *
 * Validates institutional income creation requests.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreIncomeRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'categoris_id' => 'required|integer|exists:income_categoris,id',
            'branch_id'    => 'nullable|integer|exists:branches,id',
            'title'        => 'required|string|max:191',
            'amount'       => 'required|numeric|min:0',
            'invoiceDate'  => 'required|date',
            'createDate'   => 'nullable|date',
            'bookNO'       => 'nullable|string|max:191',
            'invoiceID'    => 'nullable|string|max:191',
            'seller'       => 'nullable|string|max:191',
            'recever'      => 'nullable|string|max:191',
            'description'  => 'nullable|string',
            'IsActive'     => 'nullable|integer|in:0,1',
            'image'        => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('amount') && is_string($this->amount)) {
            $this->merge([
                'amount' => str_replace(',', '', $this->amount),
            ]);
        }
    }
}
