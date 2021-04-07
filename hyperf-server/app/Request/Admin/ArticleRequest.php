<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class ArticleRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'article_id'    => 'required',
            'article_title' => 'required|max:200',
            'article_cover' => 'required|integer',
            'is_check'      => 'required|integer',
            'is_public'     => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'article_id.required'    => '文章Id为必填项！',
            'article_title.required' => '文章标题为必填项！',
            'article_cover.required' => '文章封面为必传项！',
            'is_check.number'        => '文章审核状态为必选项！',
            'is_public.number'       => '文章公开状态为必选项！',
        ];
    }

    protected $scene = [
        'create' => [
            'article_title',
            'article_cover',
            'is_public',
            'is_check',
        ],
        'update' => [
            'article_id',
            'article_title',
            'article_cover',
            'is_public',
            'is_check',
        ],
    ];
}
