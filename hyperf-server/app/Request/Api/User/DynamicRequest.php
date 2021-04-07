<?php

declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\BaseRequest;

class DynamicRequest extends BaseRequest
{
    public function rules() : array
    {
        return ['dynamic_content' => 'required|max:1000',];
    }

    public function messages() : array
    {
        return [
            'dynamic_content.required' => '输入动态内容',
            'dynamic_content.max'      => '动态内容最长可输入：1000字',
        ];
    }
}