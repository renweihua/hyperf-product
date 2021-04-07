<?php

declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\BaseRequest;

class FriendApplyRequest extends BaseRequest
{
    public function rules() : array
    {
        return ['user_uuid' => 'required|max:100',];
    }

    public function messages() : array
    {
        return ['user_uuid.required' => '请指定会员'];
    }
}
