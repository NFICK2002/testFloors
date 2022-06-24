<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'surname' => ['required'],
            'name' => ['required'],
            'last_name' => ['required'],
            'login' => ['required', 'unique:users,login'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'surname.required' => 'Это поле является обязательным',
            'name.required' => 'Это поле является обязательным',
            'last_name.required' => 'Это поле является обязательным',
            'login.required' => 'Это поле является обязательным',
            'login.unique' => 'Такой логин уже занят',
            'email.required' => 'Это поле является обязательным',
            'email.unique' => 'Такой email уже занят',
            'password.required' => 'Это поле является обязательным',
            'password.confirmed' => 'Пароль не подтвержден',

        ];
    }
}
