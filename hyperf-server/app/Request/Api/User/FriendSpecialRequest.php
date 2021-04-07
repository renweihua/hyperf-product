<?php

declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\BaseRequest;

class FriendSpecialRequest extends BaseRequest
{
    public function rules() : array
    {
        return ['friend_id'  => 'required|gt:0',
                'is_special' => 'required',
        ];
    }

    public function messages() : array
    {
        return ['friend_id.required'  => '请指定好友',
                'is_special.required' => '请设置关注状态',
        ];
    }
}
