<?php

namespace App\Http\Requests\Api\V1;

/**
 * Class StoreInvestmentRequest
 *
 * Validates capital investment creation requests with automatic comma sanitization.
 *
 * @package App\Http\Requests\Api\V1
 */
class StoreInvestmentRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'shareholder_id' => 'required|integer|exists:shareholders,id',
            'amount'         => 'required|numeric|min:0.01',
            'recevedBy'      => 'required|string|max:191',
            'recevedDate'    => 'required|date',
            'paidremark'     => 'nullable|string|max:500',
            'isActive'       => 'required|in:0,1',
            'image'          => 'nullable|string|max:255',
        ];
    }

    /**
     * Prepare data for validation by stripping commas from amount.
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
