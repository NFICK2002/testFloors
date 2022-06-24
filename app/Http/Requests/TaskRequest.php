<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'description' => ['required'],
            'date_end' => ['required', 'after:today'],
            'priority' => ['required'],
            'creator_id' => ['required'],
            'responsible_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле является обязательным',
            'description.required' => 'Поле является обязательным',
            'date_end.required' => 'Поле является обязательным',
            'date_end.after' => 'Выберите дату > чем сегодня',
            'priority.required' => 'Поле является обязательным',
            'responsible_id.required' => 'Поле является обязательным',
        ];
    }
}
