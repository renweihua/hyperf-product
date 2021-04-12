<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsDynamicsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_dynamics')) return;
        Schema::create('bbs_dynamics', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('dynamic_id')->comment('会员动态表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->string('dynamic_content', 1000)->default('')->comment('内容');
            $table->string('dynamic_file', 1000)->default('')->comment('素材');
            $table->boolean('file_type')->unsigned()->default(0)->comment('素材类型：0.无；1.图片；2.视频');
            $table->integer('praise_count')->unsigned()->default(0)->comment('点赞数量');
            $table->integer('comment_count')->unsigned()->default(0)->comment('评论数量');
            $table->integer('collection_count')->unsigned()->default(0)->comment('收藏数量');
            $table->boolean('is_public')->unsigned()->default(0)->comment('是否公开：0：否；1：是');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('is_public');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_dynamics');
    }
}
