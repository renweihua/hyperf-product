<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class AdminMenuRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'menu_id'       => 'required',
            'menu_name'     => 'required|max:200',
            'vue_path'      => 'required|max:200',
            'vue_component' => 'required',
            'api_url'       => 'required',
        ];
    }

    public function messages() : array
    {
        return [
            'menu_id.required'       => '菜单Id为必填项！',
            'menu_name.required'     => '菜单名称为必填项！',
            'vue_path.required'      => 'Vue路由为必填项！',
            'vue_component.required' => 'Vue文件路径为必填项！',
            'api_url.required'       => '接口路由为必填项！',
        ];
    }

    protected $scene = [
        'create' => [
            'menu_name',
            'vue_path',
            'vue_component',
            'api_url',
        ],
        'update' => [
            'menu_id',
            'menu_name',
            'vue_path',
            'vue_component',
            'api_url',
        ],
    ];
}
