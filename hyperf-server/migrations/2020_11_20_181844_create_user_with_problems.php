<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserWithProblems extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('user_with_problems')) return;
        Schema::create('user_with_problems', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('with_id')->comment('会员关联安全问题表');
            $table->bigInteger('user_id')->unsigned()->default('0')->comment('会员主键');
            $table->bigInteger('problem_id')->unsigned()->default('0')->comment('安全问题主键');
            $table->string('question_answers', 256)->default('')->comment('安全问题答案');
            $table->string('created_ip', 20)->default('')->comment('创建时的IP');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('user_id');
            $table->index('problem_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_with_problems');
    }
}
