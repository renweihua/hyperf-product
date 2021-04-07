<?php

declare(strict_types = 1);

namespace App\Request\Api;

use App\Request\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'user_name' => 'required',
            'password'  => 'required|confirmed',
        ];
    }

    public function messages() : array
    {
        return [
            'user_name.required' => '账户/邮箱为必填项！',
            'password.required'  => '登录密码为必填项！',
            'password.confirmed' => '两次输入密码不一致！',
        ];
    }
}
