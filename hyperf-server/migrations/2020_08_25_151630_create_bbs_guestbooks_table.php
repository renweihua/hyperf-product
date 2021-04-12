<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsGuestbooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_guestbooks')) return;
        Schema::create('bbs_guestbooks', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('会员留言表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('commenter_id')->unsigned()->default(0)->comment('留言会员的Id');
            $table->string('book_content', 1000)->default('')->comment('内容');
            $table->string('reply_content', 1000)->default('')->comment('回复内容');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('commenter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_guestbooks');
    }
}
