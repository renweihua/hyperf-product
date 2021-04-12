<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminInfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('admin_infos')) return;
        Schema::create('admin_infos', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->integer('admin_id')->unsigned()->default(0)->comment('管理员信息表');
            $table->integer('login_num')->unsigned()->default(0)->comment('登录次数');
            $table->string('created_ip', 20)->default('')->comment('创建时的IP');
            $table->string('browser_type', 200)->default('')->comment('创建时浏览器类型');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_infos');
    }
}
