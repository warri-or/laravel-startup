<?php

namespace App\Http\Requests\Web\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => __('Old password field can not be empty!'),
            'password.required' => __('Password field can not be empty!'),
            'password.min' => __('Password length must be minimum 6 characters!'),
            'password_confirmation.required' => __('Confirm password field can not be empty!'),
            'password_confirmation.same' => __('Password not mached!')
        ];
    }
}
