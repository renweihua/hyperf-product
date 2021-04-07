<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class FriendlinkRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'link_id'   => 'required',
            'link_name' => 'required|max:200',
            'link_img'  => 'required|integer',
            'link_url'  => 'required|url',
            'is_check'  => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'link_id.required'   => '文章Id为必填项！',
            'link_name.required' => '友情链接站点名称为必填项！',
            'link_img.required'  => '站点图标为必传项！',
            'link_url.required'  => '站点网址为必填项！',
        ];
    }

    protected $scene = [
        'create' => [
            'link_name',
            'link_img',
            'link_url',
            'is_check',
        ],
        'update' => [
            'link_id',
            'link_name',
            'link_img',
            'link_url',
            'is_check',
        ],
    ];
}
