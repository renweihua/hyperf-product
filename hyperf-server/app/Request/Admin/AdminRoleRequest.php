<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class AdminRoleRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'role_id' => 'required',
            'role_name' => 'required|max:200',
            'is_check' => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'role_id.required'    => '角色Id为必填项！',
            'role_name.required'  => '角色名称为必填项！',
            'role_name.max'      => '角色名称最大长度为200字符！',
            'is_check.required'       => '设置是否启用！',
        ];
    }

    protected $scene = [
        'create' => [
            'role_name',
            'is_check',
        ],
        'update' => [
            'role_id',
            'role_name',
            'is_check',
        ],
    ];
}
