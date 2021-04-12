<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsFilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_files')) return;
        //社区的所有素材文件表
        Schema::create('bbs_files', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('file_id')->comment('所有图片记录表 == upload_file');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->string('storage', 20)->default('')->comment('存储方式');
            $table->string('file_url', 200)->default('')->comment('存储域名');
            $table->string('file_name', 200)->default('')->comment('文件路径');
            $table->string('file_type', 20)->default('')->comment('文件类型');
            $table->integer('file_size')->unsigned()->default(0)->comment('文件大小(字节)');
            $table->string('extension', 20)->default('')->comment('文件扩展名');
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
        Schema::dropIfExists('bbs_files');
    }
}
