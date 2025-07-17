<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
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
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'integer', 'min:0'],
            'content' => ['required', 'string', 'min:50'],
            'memo' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ];
    }
}
