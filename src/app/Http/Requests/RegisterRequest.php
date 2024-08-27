<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages() {
        return [
            'name.required' => '名前を入力してください',
            'name.string' =>'名前を文字列で入力してください',
            'name.max' => '名前を255文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスをメール形式で入力してください',
            'email.unique' => 'メールアドレスがすでに使われています',
            'email.string' => 'メールアドレスを文字列で入力してください',
            'email.max' => 'メールアドレスを255文字以内で入力してください',
            'password.required' =>'パスワードを入力してください',
            'password.string' => 'パスワードを文字列で入力してください',
            'password.min:8' => 'パスワードを8文字以上で入力してください',
            'password.confirmed' => 'パスワードが一致しません'
        ];
    }
}



