<?php

declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\BaseRequest;

class FriendRemarkRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'friend_id' => 'required|gt:0',
            'friend_remarks' => 'required|max:100',
        ];
    }

    public function messages() : array
    {
        return [
            'friend_id.required' => '请指定好友',
            'friend_remarks.max' => '备注最长可输入：1000字',
        ];
    }
}
