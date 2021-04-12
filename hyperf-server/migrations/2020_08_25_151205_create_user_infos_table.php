<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('user_infos')) return;
        Schema::create('user_infos', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->string('nick_name', 100)->default('')->comment('昵称');
            $table->string('user_uuid', 36)->default('')->comment('uuid');
            $table->string('personal_signature', 200)->default('')->comment('个性签名');
            $table->integer('user_avatar')->unsigned()->default(0)->comment('头像');
            $table->integer('birthday')->unsigned()->default(0)->comment('出生日期');
            $table->boolean('user_sex')->unsigned()->default(2)->comment('性别：0：男；1：女；2.保密');
            $table->boolean('is_public')->unsigned()->default(0)->comment('是否公开：0：私密；1：公开；2.密码访问');
            $table->string('visit_password', 60)->default('')->comment('访问密码');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
}
