<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class AppRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules() : array
    {
        return [
            'app_key'    => 'required|max:50',
            'app_secret' => 'required|max:50',
            'app_type'   => 'required|in:0,1,2',
        ];
    }

    public function messages() : array
    {
        return [
            'app_key.required'    => 'APPkey为必填项！',
            'app_secret.required' => 'APP秘钥为必填项！',
        ];
    }
}
