<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Rabc\Admin;
use App\Request\Admin\AdminRequest;

class Admins extends BaseController
{
    protected $model = Admin::class;
    protected $validator = AdminRequest::class;
    protected $withModel   = ['admin_info'];
    protected $detailWithModel   = ['admin_info', 'roles'];

    protected function setSearchWhereFilter(&$model, array $params = []) : void
    {
        if ( isset($params['search']) && !empty($params['search']) ) {
            $model->where(function($query) use ($params) {
                $query->where('admin_name', 'like', "%{$params['search']}%")
                      ->orWhere('admin_email', 'like', "%{$params['search']}%");
            });
        }
        if ( isset($params['is_check']) && !empty($params['is_check']) && $params['is_check'] > -1 ) {
            $model->where('is_check', $params['is_check']);
        }
        parent::setSearchWhereFilter($model, $params); // TODO: Change the autogenerated stub
    }
}
