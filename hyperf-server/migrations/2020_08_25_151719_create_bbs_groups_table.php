<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_groups')) return;
        Schema::create('bbs_groups', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('group_id')->comment('群聊/群组表');
            $table->integer('user_id')->unsigned()->default(0)->comment('创建者');
            $table->string('group_name', 200)->default('')->comment('群组名称');
            $table->string('group_introduce', 400)->default('')->comment('群介绍');
            $table->integer('group_cover')->unsigned()->default(0)->comment('封面');
            $table->integer('group_users')->unsigned()->default(0)->comment('人数');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_groups');
    }
}
