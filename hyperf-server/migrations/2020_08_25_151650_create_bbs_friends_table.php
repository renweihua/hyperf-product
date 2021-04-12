<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsFriendsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_friends')) return;
        // 两个人成为好友的话， 暂定：录入两条信息，方便查询【一条数据的话，每次需要user_id与friend_id的OR查询】
        Schema::create('bbs_friends', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('会员好友表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('friend_id')->unsigned()->default(0)->comment('好友Id');
            $table->integer('group_id')->unsigned()->default(0)->comment('好友分组');
            $table->boolean('is_special')->unsigned()->default(0)->comment('特别关注');
            $table->boolean('is_blacklist')->unsigned()->default(0)->comment('是否拉黑：1：是；0：否');
            $table->string('friend_remarks', 100)->default('')->comment('备注');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index(['is_special']);
            $table->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_friends');
    }
}
