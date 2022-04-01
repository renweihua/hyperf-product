<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('articles')) return;
        Schema::create('articles', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->bigIncrements('article_id')->comment('文章表');
            $table->integer('user_id')->unsigned()->default(0)->comment('会员Id');
            $table->integer('article_category')->unsigned()->default(0)->comment('分类Id');
            $table->string('article_title', 200)->default('')->comment('文章标题');
            $table->integer('article_cover')->unsigned()->default(0)->comment('封面');
            $table->string('article_keywords', 200)->default('')->comment('关键词');
            $table->string('article_description', 200)->default('')->comment('描述');
            $table->integer('article_sort')->unsigned()->default(0)->comment('排序');
            $table->boolean('set_top')->unsigned()->default(0)->comment('置顶');
            $table->boolean('is_recommend')->unsigned()->default(0)->comment('推荐');
            $table->boolean('is_public')->unsigned()->default(1)->comment('是否公开：0：私密；1：是；2.密码访问');
            $table->string('access_password', 60)->default('')->comment('访问密码');
            $table->string('article_origin', 200)->default('')->comment('文章来源');
            $table->string('article_author', 200)->default('')->comment('文章作者');
            $table->string('article_link', 300)->default('')->comment('详情外链');
            $table->integer('read_num')->unsigned()->default(0)->comment('阅读数量');
            $table->boolean('is_delete')->unsigned()->default(0)->comment('是否删除：1：删除；0：正常');
            $table->string('created_ip', 50)->default('')->comment('创建时的IP');
            $table->integer('praise_count')->unsigned()->default(0)->comment('点赞数量');
            $table->integer('collection_count')->unsigned()->default(0)->comment('收藏数量');
            $table->integer('comment_count')->unsigned()->default(0)->comment('评论数量');
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
        Schema::dropIfExists('articles');
    }
}
