<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsFriendGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_friend_groups')) return;
        Schema::create('bbs_friend_groups', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('group_id')->comment('好友分组表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->string('group_name', 100)->default('')->comment('名称');
            $table->integer('friend_nums')->unsigned()->default(0)->comment('好友数量');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_friend_groups');
    }
}
