<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class BannerRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'banner_id'    => 'required',
            'banner_name' => 'required|max:200',
            'banner_cover' => 'required',
            'is_check'     => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'banner_id.required'    => 'BannerId为必填项！',
            'banner_name.required' => 'Banner标题为必填项！',
            'banner_name.max'      => 'Banner标题最大长度为200字符！',
            'banner_cover.required' => 'Banner封面为必填项！',
            'is_check.required'       => '设置是否启用！',
        ];
    }

    protected $scene = [
        'create' => [
            'banner_name',
            'banner_cover',
            'is_check',
        ],
        'update' => [
            'banner_id',
            'banner_name',
            'banner_cover',
            'is_check',
        ],
    ];
}
