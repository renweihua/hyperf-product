<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsGroupNoticesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_group_notices')) return;
        Schema::create('bbs_group_notices', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('notice_id')->comment('群公告表');
            $table->integer('group_id')->unsigned()->default(0)->comment('群聊Id');
            $table->integer('user_id')->unsigned()->default(0)->comment('发布者');
            $table->text('notice_content')->nullable()->comment('公告内容');
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
        Schema::dropIfExists('bbs_group_notices');
    }
}
