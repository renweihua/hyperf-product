<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateNotifies extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('notifies')) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        Schema::create('notifies', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('notify_id')->comment('系统消息通知记录表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->boolean('is_read')->unsigned()->default(0)->comment('是否已读：1：是；0：否');
            $table->boolean('notify_type')->unsigned()->default(0)->comment('通知类型：0.系统通知/公告；1.提醒；2.私信');
            $table->integer('target_id')->unsigned()->default(0)->comment('目标Id(比如动态ID)');
            $table->boolean('target_type')->unsigned()->default(0)->comment('目标类型：0.动态');
            $table->integer('sender_id')->unsigned()->default(0)->comment('发送者Id');
            $table->integer('sender_type')->unsigned()->default(0)->comment('发送者类型：0.系统通知；1.指定会员');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            $table->text('notify_content')->nullable()->comment('通知内容');
            // 索引
            $table->index('user_id');
            $table->index('is_read');
            $table->index('notify_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifies');
    }
}
