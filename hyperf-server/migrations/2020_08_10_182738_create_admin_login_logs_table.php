<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminLoginLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('admin_login_logs')) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        Schema::create('admin_login_logs', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('log_id')->comment('管理员登录日志');
            $table->integer('admin_id')->unsigned()->default(0)->comment('Id');
            $table->boolean('log_status')->unsigned()->default(1)->comment('登录状态：1：成功；0：失败');
            $table->string('log_description', 200)->default('')->comment('描述');
            $table->string('request_url', 200)->default('')->comment('请求方法/路由');
            $table->string('log_method', 20)->default('')->comment('请求类型/请求方式');
            $table->string('request_data', 500)->default('')->comment('请求参数');
            $table->string('created_ip', 20)->default('')->comment('创建时的IP');
            $table->string('browser_type', 200)->default('')->comment('创建时浏览器类型');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('admin_id');
            $table->index('log_status');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_login_logs');
    }
}
