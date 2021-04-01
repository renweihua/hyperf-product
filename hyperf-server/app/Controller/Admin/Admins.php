<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class Admins
{
    public function index()
    {
        var_dump(__CLASS__ . '-' . __FUNCTION__);
    }

    public function detail()
    {
        var_dump(__CLASS__ . '-' . __FUNCTION__);
    }

    public function create()
    {
        var_dump(__CLASS__ . '-' . __FUNCTION__);
    }

    public function update()
    {
        var_dump(__CLASS__ . '-' . __FUNCTION__);
    }

    public function delete()
    {
        var_dump(__CLASS__ . '-' . __FUNCTION__);
    }
}
