<?php

declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\BaseRequest;

class FriendApplyRespondRequest extends BaseRequest
{
    public function rules() : array
    {
        return ['apply_id' => 'required|gt:0',];
    }

    public function messages() : array
    {
        return ['apply_id.required' => '请指定好友申请记录'];
    }
}
