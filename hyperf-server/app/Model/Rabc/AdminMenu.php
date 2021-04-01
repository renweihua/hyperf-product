<?php

declare (strict_types = 1);

namespace App\Model\Rabc;

use App\Model\Model;

/**
 */
class AdminMenu extends Model
{
    protected $primaryKey = 'menu_id';

    public function getSelectLists($sort = 'ASC')
    {
        $model = $this->query();
        // 是否开启了假删除
        if ( $this->is_delete == 0 ) $model = $model->where(['is_delete' => '0']);

        $list = $model->orderBy('menu_sort', $sort)->get()->toArray();
        return list_to_tree($list);
    }

    public static function getMenusByIds(array $menu_ids)
    {
        return self::getInstance()
                    ->cnpscyWhereIn('menu_id', $menu_ids)
                    ->orderBy('menu_sort', 'ASC')
                    ->get()
                    ->toArray();
    }
}