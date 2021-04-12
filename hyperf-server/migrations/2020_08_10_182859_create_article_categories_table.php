<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('article_categories')) return;
        Schema::create('article_categories', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('category_id')->comment('文章分类表');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父级Id');
            $table->string('category_name', 200)->default('')->comment('名称');
            $table->integer('category_cover')->unsigned()->default(0)->comment('封面');
            $table->string('category_description', 200)->default('')->comment('描述');
            $table->integer('category_sort')->unsigned()->default(0)->comment('排序');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->integer('created_time')->unsigned()->default(0)->comment('创建时间');
            $table->integer('updated_time')->unsigned()->default(0)->comment('更新时间');
            // 索引
            $table->index('parent_id');
            $table->index('is_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_categories');
    }
}
