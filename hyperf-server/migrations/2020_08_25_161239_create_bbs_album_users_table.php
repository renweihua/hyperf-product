<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsAlbumUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_album_users')) return;
        Schema::create('bbs_album_users', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->comment('会员的相册记录表');
            $table->integer('album_id')->unsigned()->default(0)->comment('相册Id');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('image_id')->unsigned()->default(0)->comment('图片Id');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('album_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_album_users');
    }
}
