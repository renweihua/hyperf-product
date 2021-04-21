<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class AdminRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'admin_id'    => 'required',
            'admin_name'  => 'required|max:200',
            'admin_email' => 'required|max:200|email',
            'admin_head'  => 'required|integer',
            'is_check'    => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'admin_id.required'    => '管理员Id为必填项！',
            'admin_name.required'  => '管理员名称为必填项！',
            'admin_email.required' => '管理员邮箱为必填项！',
            'admin_email.email'    => '管理员邮箱格式非法！',
            'is_check.required'       => '设置是否启用！',
        ];
    }

    protected $scene = [
        'create' => [
            'admin_name',
            'admin_email',
            'admin_head',
            'is_check',
        ],
        'update' => [
            'admin_id',
            'admin_name',
            'admin_email',
            'admin_head',
            'is_check',
        ],
    ];
}
