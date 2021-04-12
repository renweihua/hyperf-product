<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsFriendAppliesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_friend_applies')) return;
        Schema::create('bbs_friend_applies', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('apply_id')->comment('好友申请表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('friend_id')->unsigned()->default(0)->comment('申请人/好友Id');
            $table->string('apply_remark', 200)->default('')->comment('申请备注');
            $table->string('user_reason', 200)->default('')->comment('回应');
            $table->boolean('is_check')->unsigned()->default(0)->comment('状态：0.待审核；1.已同意；2.已拒绝');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('is_check');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_friend_applies');
    }
}
