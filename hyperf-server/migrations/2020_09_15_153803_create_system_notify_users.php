<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSystemNotifyUsers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('system_notify_users')) return;
        // 只会与notifies表，notify_type == 0.系统通知/公告，相关联，其它类型无需关联
        Schema::create('system_notify_users', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('系统消息与会员的已读记录表');
            $table->integer('notify_id')->unsigned()->default(0)->comment('通知Id');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('notify_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_notify_users');
    }
}
