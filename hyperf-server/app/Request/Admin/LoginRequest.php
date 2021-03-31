<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use Hyperf\Validation\Request\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'admin_name' => 'required|max:50',
            'password'   => 'required|max:50',
        ];
    }

    public function messages() : array
    {
        return [
            'admin_name.required' => '管理员账户为必填项！',
            'password.required'   => '管理员密码为必填项！',
        ];
    }
}
