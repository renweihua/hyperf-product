<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_group_users')) return;
        Schema::create('bbs_group_users', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('群聊的成员表');
            $table->integer('group_id')->unsigned()->default(0)->comment('群聊Id');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->string('card_name', 200)->default('')->comment('群名片');
            $table->boolean('is_admin')->unsigned()->default(0)->comment('是否管理员：0：普通；1：管理员；2.群主');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('group_id');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_group_users');
    }
}
