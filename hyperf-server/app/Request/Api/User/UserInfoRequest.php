<?php

declare(strict_types = 1);

namespace App\Request\Api\User;

use App\Request\BaseRequest;

class UserInfoRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'nick_name' => 'required|max:20',
            'user_sex'  => 'required',
            'birthday'  => 'required',
        ];
    }

    public function messages() : array
    {
        return [
            'nick_name.required' => '请输入昵称',
            'nick_name.max'      => '动态内容最长可输入：20字',
            'user_sex.required'  => '请选择性别',
            'birthday.required'  => '请设置生日',
        ];
    }
}
