<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('admins')) return;
        Schema::create('admins', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('admin_id')->comment('管理员表');
            $table->string('admin_name', 100)->default('')->comment('管理员');
            $table->string('admin_email', 100)->default('')->comment('邮箱');
            $table->string('admin_head', 200)->unsigned()->default(0)->comment('头像');
            $table->string('password', 60)->default('')->comment('密码');
            $table->boolean('is_check')->unsigned()->default(0)->comment('是否审核：0：审核中；1：正常；2：禁用');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->boolean('kick_out')->unsigned()->default(2)->comment('是否踢出登录：0：表示在线；1：踢出登录；2.未登录');
            $table->integer('use_role')->unsigned()->default(0)->comment('正在使用的角色Id');
            // 索引
            $table->index('kick_out');
            $table->index('is_check');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
}
