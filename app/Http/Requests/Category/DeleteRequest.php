<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    #[\Override]
    protected function prepareForValidation()
    {
        // URLパラメータからcategory_id取得
        $this->merge([
            'category_id' => $this->route('category_id'),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
