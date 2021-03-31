<?php

namespace App\Event\Admin;

class AdminLoginEvent
{
    // 建议这里定义成 public 属性，以便监听器对该属性的直接使用，或者你提供该属性的 Getter
    public $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }
}