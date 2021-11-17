<?php

namespace App\Http\Requests\Web\Admin\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
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
        $rules =  [
            'name'=>'required|max:100',
            'email'=>'required|email|unique:users,email',
            'default_module_id'=>'required',
            'role'=>'required',
            'status'=>'required',
        ];
        if (!empty($this->id)){
            $rules['email'] = 'required|email';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'=>__('Name field is required.'),
            'name.max'=>__('Name can\'t be more than 100 character.'),
            'email.required' => __('Email field can not be empty!'),
            'email.unique' => __('Email address already exists!'),
            'email.email' => __('Invalid email!'),
            'default_module_id.required' => __('Module can\'t be empty!'),
            'role.required' => __('Role can\'t be empty!'),
            'status.required'=>__('Status field is required.')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->header('accept') == "application/json") {
            $errors = [];
            if ($validator->fails()) {
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
            }
            $json = ['success'=>false,
                     'data'=>[],
                     'message' => $errors[0],
            ];
            $response = new JsonResponse($json, 200);

            throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }

    }
}
