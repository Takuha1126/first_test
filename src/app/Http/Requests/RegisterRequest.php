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
    public function rules(Request $request)
    {
            if (isset($request->name)){
        return [
            'name' => 'required|string|max:191',
            'email' => ['required|email|string|max:191',
            Rule::unique('RegisterUser')->ignore($request->name,'name')],
            'password' => 'string|min:8|max:191',
            'password_confirmation' => 'string|confirmed'
        ];
        }else {
            return [
            'name' => 'required|string|max:191',
            'email' => ['required|email|unique:users|string|max:191'],
            'password' => 'string|min:8|max:191',
            'password_confirmation' => 'string|confirmed'
            ];

        }
    }
    public function message() {
        return [
            'name.required' => '名前を入力してください',
            'name.string' =>'名前を文字列で入力してください',
            'name.max:191' => '名前を191文字以内で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスをメール形式で入力してください',
            'email.unique' => 'メールアドレスがすでに使われています',
            'email.string' => 'メールアドレスを文字列で入力してください',
            'email.max:191' => 'メールアドレスを191文字以内で入力してください',
            'password.string' => 'パスワードを入力してください',
            'password.min:8' => 'パスワードを8文字以上で入力してください',
            'password.max:191' => 'パスワードを191文字以下で入力してください',
            'password_confirmation.required' => '確認パスワードを入力してください',
            'password_confirmation.confirmed' => 'パスワードが一致しません'
        ];
    }
}



