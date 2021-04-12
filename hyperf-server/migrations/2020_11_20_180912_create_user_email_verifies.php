<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserEmailVerifies extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('user_email_verifies')) return;
        Schema::create('user_email_verifies', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('verify_id')->comment('邮箱验证表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->string('user_email', 100)->default('')->comment('邮箱');
            $table->string('verify_token', 256)->default('')->comment('验证TOKEN');
            $table->boolean('auth_email')->unsigned()->default(0)->comment('邮箱验证状态：0：否，1：是');
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
        Schema::dropIfExists('user_email_verifies');
    }
}
