<?php

declare(strict_types = 1);

namespace App\Request\Admin;

use App\Request\BaseRequest;

class AdminRoleRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'role_id' => 'required',
            'role_name' => 'required|max:200',
            'is_check' => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [

        ];
    }

    protected $scene = [
        'create' => [
            'role_name',
            'is_check',
        ],
        'update' => [
            'role_id',
            'role_name',
            'is_check',
        ],
    ];
}
