<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
        $isMethodPut = $this->method() == 'PUT';
        return [
            'firstname' => 'required|string|max:150',
            'middlename' => 'required|string|max:150',
            'lastname' => 'required|string|max:150',
            'user_type_id' => 'required',
            'gender' => 'required',
            'contact_no' => 'required|numeric',
            'birthday' => 'required|date',
            'username' => 'required|string|min:3|max:15',
            'email' => 'required|email',
            'password' => $isMethodPut ? '' : 'required|string|min:8|max:25'
        ];
    }
}
