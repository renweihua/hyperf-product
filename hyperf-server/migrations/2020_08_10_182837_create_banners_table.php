<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('banners')) return;
        Schema::create('banners', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('banner_id')->comment('Banner表');
            $table->string('banner_name', 100)->default('')->comment('标题');
            $table->integer('banner_cover')->unsigned()->default(0)->comment('封面');
            $table->string('banner_link', 200)->default('')->comment('外链');
            $table->string('banner_words', 200)->default('')->comment('文字描述');
            $table->smallInteger('banner_sort')->unsigned()->default(0)->comment('排序【升序】');
            $table->boolean('is_check')->unsigned()->default(0)->comment('是否审核：1：正常；0：禁用');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('banner_sort');
            $table->index('is_check');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
}
