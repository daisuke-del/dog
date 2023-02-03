<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if ($this->is('user/signup')) {
            return [
                'email' => ['required', 'regex:' . config('const.REGEX_EMAIL')],
                'password' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32'],
                'name' => ['required', 'string'],
            ];
        } elseif ($this->is('user/login')) {
            return [
                'email' => ['required', 'regex:' . config('const.REGEX_EMAIL')],
                'password' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32'],
            ];
        } elseif ($this->is('user/logout')) {
            return [];
        } elseif ($this->is('user/update/email')) {
            return [
                'email' => ['required', 'regex:' . config('const.REGEX_EMAIL')]
            ];
        } elseif ($this->is('user/update/email/auth')) {
            return [
                'password' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32'],
                'email' => ['required', 'regex:' . config('const.REGEX_EMAIL')]
            ];
        } elseif ($this->is('user/update/password')) {
            return [
                'password' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32'],
                'new_password' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32'],
                'new_password_again' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32']
            ];
        } elseif ($this->is('user/update/name')) {
            return [
                'name' => ['required', 'string']
            ];
        } elseif ($this->is('user/forget/password/email')) {
            return [
                'email' => ['required', 'regex:' . config('const.REGEX_EMAIL')]
            ];
        } elseif ($this->is('user/forget/password/update')) {
            return [
                'password' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32'],
                'password_again' => ['required', 'regex:' . config('const.REGEX_PASSWORD'), 'min:6', 'max:32']
            ];
        } elseif ($this->is('api/match/gender')) {
            return [
                'gender' => ['required', 'string'],
                'email' => ['required', 'regex:' . config('const.REGEX_EMAIL')]
            ];
        }
        return [false];
    }

    /**
     * エラーメッセージのカスタマイズ
     *
     * @return array
     */
    public function messages(): array
    {
        if ($this->is('user/signup')) {
            return [
                'email.required' => 'email required',
                'email.regex' => 'email regex',
                'password.required' => 'password required',
                'password.regex' => 'password regex',
                'password.min' => 'password min',
                'password.max' => 'password max',
            ];
        } elseif ($this->is('user/login')) {
            return [
                'email.*' => 'email validate',
                'password.*' => 'password validate',
            ];
        } elseif ($this->is('user/logout')) {
            return [];
        } elseif ($this->is('user/update/email')) {
            return [
                'email.*' => 'email validate',
            ];
        } elseif ($this->is('user/update/email/auth')) {
            return [
                'password.*' => 'password validate',
                'email.*' => 'email validate',
                'auth_code.*' => 'auth_code validate',
            ];
        } elseif ($this->is('api/user/update/password')) {
            return [
                'password.*' => 'password validate',
                'new_password.*' => 'new_password validate',
                'new_password_again.*' => 'new_password_again validate',
            ];
        } elseif ($this->is('api/user/update/name')) {
            return [
                'handle_name.*' => 'handle_name validate',
            ];
        } elseif ($this->is('api/user/forget/password/email')) {
            return [
                'email.*' => 'email validate',
            ];
        } elseif ($this->is('api/user/forget/password/auth')) {
            return [
                'auth_code.*' => 'auth_code validate',
            ];
        } elseif ($this->is('api/user/forget/password/update')) {
            return [
                'password.*' => 'password validate',
                'password_again.*' => 'password_again validate',
            ];
        }
        return ['user root not found'];
    }

    /**
     * ルールに違反した場合の処理
     *
     * @param Validator $validator
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, null, $validator->getMessageBag());
    }
}
