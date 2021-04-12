<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsChatRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_chat_records')) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        Schema::create('bbs_chat_records', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('record_id')->comment('会员的聊天记录表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('friend_id')->unsigned()->default(0)->comment('好友Id');
            $table->boolean('friend_type')->unsigned()->default(1)->comment('好友类型：1：好友；2：临时会话');
            $table->boolean('chat_type')->unsigned()->default(0)->comment('内容格式：0：文本；1.图片；2.语音；3.视频');
            $table->text('chat_content')->nullable()->comment('聊天内容');
            $table->boolean('is_recall')->unsigned()->default(0)->comment('是否撤回：1：是；0：否');
            $table->boolean('is_read')->unsigned()->default(0)->comment('是否已读：1：是；0：否');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('friend_id');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_chat_records');
    }
}
