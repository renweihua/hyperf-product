<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users')) return;
        Schema::create('users', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('user_id')->comment('会员表');
            $table->string('user_name', 100)->default('')->comment('账户');
            $table->string('user_email', 100)->default('')->comment('邮箱');
            $table->string('password', 60)->default('')->comment('登录密码');
            $table->boolean('is_check')->unsigned()->default(1)->comment('状态：1：启用；2：禁用');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            // 索引
            $table->index('is_check');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
