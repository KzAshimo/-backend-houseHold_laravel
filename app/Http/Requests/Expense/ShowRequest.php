<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    #[\Override]
    protected function prepareForValidation()
    {
        // URLパラメータからexpense_id取得
        $this->merge([
            'expense_id' => $this->route('expense_id'),
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
            'expense_id' => ['required', 'integer', 'exists:expenses,id'],
        ];
    }
}
