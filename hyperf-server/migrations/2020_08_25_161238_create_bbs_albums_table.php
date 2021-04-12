<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_albums')) return;
        Schema::create('bbs_albums', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('album_id')->comment('会员相册表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->string('album_name', 200)->default('')->comment('名称');
            $table->integer('album_logo')->unsigned()->default(0)->comment('封面');
            $table->boolean('is_public')->unsigned()->default(0)->comment('是否公开：0：否；1：是；2.密码访问');
            $table->string('visit_password', 60)->default('')->comment('访问密码');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('is_public');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs_albums');
    }
}
