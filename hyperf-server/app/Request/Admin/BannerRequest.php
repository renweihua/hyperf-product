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
            'banner_title' => 'required|max:200',
            'banner_cover' => 'required|integer',
            'is_check'     => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'banner_id.required'    => 'BannerId为必填项！',
            'banner_title.required' => 'Banner标题为必填项！',
            'banner_title.max'      => 'Banner标题最大长度为200字符！',
            'banner_cover.required' => 'Banner封面为必填项！',
            'is_check.number'       => 'Banner状态为必选项！',
        ];
    }

    protected $scene = [
        'create' => [
            'banner_title',
            'banner_cover',
            'is_check',
        ],
        'update' => [
            'banner_id',
            'banner_title',
            'banner_cover',
            'is_check',
        ],
    ];
}
