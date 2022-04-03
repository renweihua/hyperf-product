<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateVisitRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $table = 'visit_records';
        if (Schema::hasTable($table)) return;
        // 【按月分表】
        // 作为基础表，所有的分表生成按照词表的结构进行复制并重命名
        Schema::create($table, function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->comment('浏览日志记录表');
            $table->bigIncrements('log_id');
            $table->integer('user_id')->unsigned()->default(0)->comment('Id');
            $table->boolean('log_status')->unsigned()->default(1)->comment('状态：1：成功；0：失败');
            $table->string('api_url', 200)->default('')->comment('请求URL');
            $table->string('log_method', 200)->default('')->comment('请求方式');
            $table->string('log_description', 200)->default('')->comment('描述');
            $table->string('created_ip', 20)->default('')->comment('创建时的IP');
            $table->string('browser_type', 200)->default('')->comment('创建时浏览器类型');
            $table->string('log_duration', 200)->default('0')->comment('请求时长（s）');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            $table->json('request_data')->nullable()->comment('请求参数');
            $table->json('extend_json')->nullable()->comment('扩展信息');
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
        Schema::dropIfExists('visit_record');
    }
}
