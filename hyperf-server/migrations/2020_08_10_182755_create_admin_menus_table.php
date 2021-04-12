<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('admin_menus')) return;
        Schema::create('admin_menus', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('menu_id')->comment('菜单栏目表');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父级id');
            $table->string('menu_name', 200)->default('')->comment('栏目名称');

            $table->string('vue_path', 200)->default('')->comment('Vue路由');
            $table->string('vue_icon', 50)->default('')->comment('图标');
            $table->string('vue_component', 200)->default('')->comment('Vue文件路径');
            $table->string('vue_meta', 200)->default('')->comment('');
            $table->string('vue_redirect', 200)->default('')->comment('Vue的redirect');
            $table->string('external_links', 200)->default('')->comment('外链');

            $table->string('api_url', 200)->default('')->comment('接口路由');
            $table->string('api_method', 20)->default('GET')->comment('请求方式');
            $table->integer('menu_sort')->unsigned()->default(0)->comment('排序');
            $table->boolean('is_hidden')->unsigned()->default(0)->comment('是否隐藏菜单栏：1：是；0：否');
            $table->boolean('is_check')->unsigned()->default(1)->comment('是否可用：1：可用；0：禁用');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('parent_id');
            $table->index('is_check');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_menus');
    }
}
