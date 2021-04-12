<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsDynamicPraisesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_dynamic_praises')) return;
        Schema::create('bbs_dynamic_praises', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('会员动态的点赞记录表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('dynamic_id')->unsigned()->default(0)->comment('动态Id');
            $table->integer('author_id')->unsigned()->default(0)->comment('作者Id');
            $table->boolean('is_read')->unsigned()->default(0)->comment('是否已读：0：否；1：是');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_dynamic_praises');
    }
}
