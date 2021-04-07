<?php

declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\BaseRequest;

class DynamicCommentRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'dynamic_id' => 'required|gt:0',
            'content'    => 'required|max:1000',
        ];
    }

    public function messages() : array
    {
        return [
            'dynamic_id.required' => '动态Id为必传项！',
            'content.required'    => '请输入评论内容',
        ];
    }
}
