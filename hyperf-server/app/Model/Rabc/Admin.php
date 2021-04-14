<?php

declare (strict_types = 1);

namespace App\Model\Rabc;

use App\Exception\Exception;
use App\Model\Model;
use App\Model\Upload\UploadFile;
use Hyperf\Database\Model\Events\Creating;
use Hyperf\DbConnection\Db;

class Admin extends Model
{
    protected $primaryKey = 'admin_id';
    public    $timestamps = false;
    // 设置隐藏属性
    protected $hidden = ['password', 'login_token'];

    public function admin_info()
    {
        return $this->hasOne(AdminInfo::class, 'admin_id', 'admin_id');
    }

    public function cover()
    {
        return $this->hasOne(UploadFile::class, 'file_id', 'admin_head');
    }

    public function roles()
    {
        return $this->belongsToMany(AdminRole::class, 'admin_with_roles', 'admin_id', 'role_id');
    }

    /**
     * 通过管理员账号进行搜索
     *
     * @param  string  $admin_name
     *
     * @return \Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model|object|null
     */
    public function getUserByName(string $admin_name)
    {
        return $this->query()->where('admin_name', $admin_name)->first();
    }

    public function setPasswordAttribute($value)
    {
        if ( !empty($value) ) $value = 123456;
        return $this->attributes['password'] = hash_encryption($value);
    }

    public function creating(Creating $event)
    {
        if ( empty($this->password) ) $this->password = 123456;
    }

    /**
     * 新增
     *
     * @param  array  $params
     * @param  int    $start_filter
     *
     * @return bool|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public function add(array $params, int $start_filter = 1)
    {
        Db::beginTransaction();
        try {
            // 管理员表
            $admin = $this->query()->create($start_filter === 1 ? $this->setFilterFields($params) : $params);
            // 管理员信息表
            $admin->admin_info()->create(['admin_id' => $admin->{$this->primaryKey}]);
            // 管理员关联角色
            $this->setAdminRole($admin, $params);

            Db::commit();
            return true;
        } catch (Exception $e) {
            Db::commit();
            return false;
        }
    }

    /**
     * 编辑
     *
     * @param $params
     *
     * @return bool|int
     */
    public function edit($params)
    {
        Db::beginTransaction();
        try {
            $admin_key = $this->getKeyName();
            // 管理员表
            $this->whereUpdate([$admin_key => $params[$admin_key]], $this->setFilterFields($params));
            // 获取管理员信息
            $admin = $this->find($params[$admin_key]);
            // 管理员信息表
            $adminInfo = AdminInfo::getInstance();
            $adminInfo->whereUpdate(['admin_id' => $admin->{$admin_key}], $adminInfo->setFilterFields($params));
            // 管理员关联角色
            $this->setAdminRole($admin, $params);

            Db::commit();
            return true;
        } catch (Exception $e) {
            Db::commit();
            return false;
        }
    }

    /**
     * 设置关联角色
     *
     * @param $admin
     * @param $params
     *
     * @return bool
     */
    private function setAdminRole($admin, $params) : bool
    {
        $request_roles = $params['role_id'] ?? [];
        $all_roles = empty($request_roles) ? [] : AdminRole::find($request_roles)->toArray();//当前选中的角色
        $new_all_roles = array_column($all_roles, 'role_id', 'role_id');
        $has_roles = $admin->roles->toArray(); // 当前已有的角色
        $new_has_roles = array_column($has_roles, 'role_id', 'role_id');

        // 管理员与角色关联表
        $adminWithRole = AdminWithRole::getInstance();

        /**
         * 添加的角色
         */
        $add_roles = get_array_diff($new_all_roles, $new_has_roles);
        if ( !empty($add_roles) ) {
            foreach ($add_roles as $role) {
                $adminWithRole->create(['admin_id' => $admin->admin_id, 'role_id' => $role,]);
            }
        }

        /**
         * 要删除的角色
         */
        $delete_roles = get_array_diff($new_has_roles, $new_all_roles);
        if ( !empty($delete_roles) ) {
            foreach ($delete_roles as $role) $adminWithRole->cnpscyWhere(['admin_id' => $admin->admin_id, 'role_id' => $role,])
                                                           ->delete();
        }
        return true;
    }
}
