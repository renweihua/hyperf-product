<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminRoutesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('admin_routes')) return;
        Schema::create('admin_routes', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->comment('后台API路由表');
            $table->bigIncrements('route_id')->comment('Id');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父级Id');
            $table->string('route_name', 100)->default('')->comment('路由名称');
            $table->string('route_prefix', 100)->default('')->comment('路由前缀');
            $table->string('route_url', 100)->default('')->comment('路由地址');
            $table->string('route_method', 10)->default('')->comment('路由请求方式');
            $table->string('route_controller', 100)->default('')->comment('路由控制器');
            $table->string('route_function', 100)->default('')->comment('路由的控制器方法');
            $table->string('route_group_middleware', 100)->default('')->comment('路由分组中间件（所有下级）');
            $table->string('route_middleware', 100)->default('')->comment('路由中间件');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('parent_id');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_routes');
    }
}
