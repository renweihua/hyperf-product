<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class LoginRequest extends BaseRequest
{
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
