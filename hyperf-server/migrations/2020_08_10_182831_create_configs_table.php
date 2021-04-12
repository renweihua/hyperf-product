<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('configs')) return;
        Schema::create('configs', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('config_id')->comment('系统参数配置表');
            $table->string('config_title', 200)->default('')->comment('标题');
            $table->string('config_name', 200)->default('')->comment('参数名');
            $table->string('config_value', 200)->default('')->comment('参数值');
            $table->smallInteger('config_group')->unsigned()->default(0)->comment('分组');
            $table->smallInteger('config_type')->unsigned()->default(0)->comment('类型');
            $table->integer('config_sort')->unsigned()->default(0)->comment('排序');
            $table->string('config_extra', 300)->default('')->comment('配置项');
            $table->string('config_remark', 300)->default('')->comment('说明');
            $table->boolean('is_check')->unsigned()->default(1)->comment('是否启用：1：是；0：否');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('config_group');
            $table->index('is_check');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
}
