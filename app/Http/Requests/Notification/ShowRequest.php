<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
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
            'notification_id' => ['required', 'integer', 'exists:notifications,id'],
        ];
    }
}
