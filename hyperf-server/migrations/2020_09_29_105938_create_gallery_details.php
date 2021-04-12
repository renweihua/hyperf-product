<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGalleryDetails extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('gallery_details')) return;
        // 图库标签表（直接存图片路径）
        Schema::create('gallery_details', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('detail_id')->comment('图库详情表');
            $table->integer('gallery_id')->unsigned()->default(0)->comment('图片库Id');
            $table->string('gallery_describe', 300)->nullable()->comment('描述');
            $table->text('gallery_pictures')->nullable()->comment('图片列表（JSON）');
            $table->integer('picture_nums')->unsigned()->default(0)->comment('图片数量');
            $table->string('origin_link', 200)->default('')->comment('来源链接');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('gallery_id');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_details');
    }
}
