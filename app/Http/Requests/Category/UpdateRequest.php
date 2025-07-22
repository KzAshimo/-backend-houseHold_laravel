<?php

namespace App\Http\Requests\Category;

use App\Enums\Category\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
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
        return false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'type' => ['required', new Enum(TypeEnum::class)],
        ];
    }
}
