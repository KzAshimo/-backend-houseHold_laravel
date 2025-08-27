<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    #[\Override]
    protected function prepareForValidation()
    {
        // URLパラメータからincome_id取得
        $this->merge([
            'income_id' => $this->route('income_id'),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'income_id' => ['required', 'integer', 'exists:incomes,id'],
        ];
    }
}
