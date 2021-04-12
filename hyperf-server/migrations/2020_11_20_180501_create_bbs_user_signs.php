<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateBbsUserSigns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('bbs_user_signs')) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        Schema::create('bbs_user_signs', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('sign_id')->comment('签到记录表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('integral_reward')->unsigned()->default(0)->comment('签到:积分奖励');
            $table->boolean('sign_type')->unsigned()->default(0)->comment('签到状态：0.签到；1.补签；2.管理员签到');
            $table->string('description', 256)->default('')->comment('描述');
            $table->bigInteger('created_ip')->default(0)->comment('创建时的IP-ip2long转换');
            $table->string('browser_type', 256)->default('')->comment('创建时浏览器类型');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
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
        Schema::dropIfExists('bbs_user_signs');
    }
}
