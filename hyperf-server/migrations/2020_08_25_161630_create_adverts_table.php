<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdvertsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('adverts')) return;
        Schema::create('adverts', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('advert_id')->comment('广告表');
            $table->string('advert_name', 200)->default('')->comment('标题');
            $table->integer('advert_cover')->unsigned()->default(0)->comment('封面');
            $table->string('advert_url', 200)->default('')->comment('外链');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
}
