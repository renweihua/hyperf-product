<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminWithRoles extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('admin_with_roles')) return;
        Schema::create('admin_with_roles', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('with_id')->comment('角色表');
            $table->integer('role_id')->unsigned()->default(0)->comment('角色Id');
            $table->integer('admin_id')->unsigned()->default(0)->comment('管理员Id');
            // 索引
            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_with_roles');
    }
}
