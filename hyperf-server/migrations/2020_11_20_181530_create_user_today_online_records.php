<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserTodayOnlineRecords extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('user_today_online_records')) return;
        Schema::create('user_today_online_records', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('record_id')->comment('每天在线会员的记录表');
            $table->integer('day_time')->unsigned()->default(0)->comment('当天时间戳 - 年月日即可');
            $table->json('user_json')->nullable()->comment('会员Id记录JSON格式');
            // 索引
            $table->index('day_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_today_online_records');
    }
}
