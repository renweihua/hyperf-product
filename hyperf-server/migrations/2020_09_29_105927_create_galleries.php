<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGalleries extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('galleries')) return;
        // 图库标签表（直接存图片路径）
        Schema::create('galleries', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('gallery_id')->comment('图库表');
            $table->string('gallery_name', 200)->default('')->comment('图库名称');
            $table->string('gallery_cover', 200)->default('')->comment('封面');
            $table->string('gallery_origin', 200)->default('')->comment('来源链接');
            $table->integer('total_num')->unsigned()->default(0)->comment('图片总量');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('is_delete');
            $table->index('created_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
}
