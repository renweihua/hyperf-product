<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class ConfigRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'config_id'    => 'required',
            'config_title' => 'required|max:200',
            'config_name'  => 'required|max:200',
        ];
    }

    public function messages() : array
    {
        return [
            'config_id.required'    => '配置Id为必填项！',
            'config_title.required' => '配置标题为必填项！',
            'config_title.max'      => '配置标题最大长度为200字符！',
            'config_name.required'  => '配置名称为必填项！',
            'config_name.max'       => '配置名称最大长度为200字符！',
        ];
    }

    protected $scene = [
        'create' => [
            'config_title',
            'config_name',
            'is_check',
        ],
        'update' => [
            'config_id',
            'config_title',
            'config_name',
            'is_check',
        ],
    ];
}
