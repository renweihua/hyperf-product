<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateFriendlinksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('friendlinks')) return;
        Schema::create('friendlinks ', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('link_id')->comment('友情链接表');
            $table->string('link_name', 100)->default('')->comment('外链名称');
            $table->string('link_url', 200)->default('')->comment('外链URL');
            $table->integer('link_cover')->unsigned()->default(0)->comment('封面');
            $table->smallInteger('link_sort')->unsigned()->default(0)->comment('排序【升序】');
            $table->boolean('open_window')->unsigned()->default(0)->comment('是否打开新窗口：1：是；0：否');
            $table->boolean('is_check')->unsigned()->default(0)->comment('是否审核：1：正常；0：禁用');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('link_sort');
            $table->index('is_check');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendlinks');
    }
}
