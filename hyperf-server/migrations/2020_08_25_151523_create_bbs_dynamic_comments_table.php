<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsDynamicCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_dynamic_comments')) return;
        Schema::create('bbs_dynamic_comments', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('会员动态的评论记录表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('dynamic_id')->unsigned()->default(0)->comment('动态Id');
            $table->integer('top_level')->unsigned()->default(0)->comment('顶级的Id（顶级上一级的reply_id = 0）');
            $table->integer('reply_user')->unsigned()->default(0)->comment('回复会员Id');
            $table->integer('reply_id')->unsigned()->default(0)->comment('回复的动态Id');
            $table->string('comment_content', 1000)->default('')->comment('内容');
            $table->integer('author_id')->unsigned()->default(0)->comment('作者Id');
            $table->boolean('is_read')->unsigned()->default(0)->comment('是否已读：0：否；1：是');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('dynamic_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_dynamic_comments');
    }
}
