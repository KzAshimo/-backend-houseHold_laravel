<?php

namespace App\Http\Requests\Notification;

use App\Enums\Notification\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    #[\Override]
    protected function prepareForValidation()
    {
        // URLパラメータからnotification_id取得
        $this->merge([
            'notification_id' => $this->route('notification_id'),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'content' => ['required', 'string', 'max:255'],
            'type' => ['required', new Enum(TypeEnum::class)],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ];
    }
}
