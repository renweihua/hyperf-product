<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGalleryWithTags extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('gallery_with_tags')) return;
        // 图库与标签关联表
        Schema::create('gallery_with_tags', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('图库与标签关联表');
            $table->integer('tag_id')->unsigned()->default(0)->comment('标签Id');
            $table->integer('gallery_id')->unsigned()->default(0)->comment('图库Id');
            // 索引
            $table->index('tag_id');
            $table->index('gallery_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_with_tags');
    }
}
