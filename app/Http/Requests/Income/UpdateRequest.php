<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    #[\Override]
    protected function prepareForValidation()
    {
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
            'amount' => ['required', 'integer', 'min:1'],
            'content' => ['required', 'string', 'max:255'],
            'memo' => ['nullable', 'string', 'max:255'],
        ];
    }
}
