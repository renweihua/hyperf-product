<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateArticleContentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('article_contents')) return;
        Schema::create('article_contents', function (Blueprint $table) {
            // 指定表存储引擎
            $table->engine = 'InnoDB';
            $table->integer('article_id')->unsigned()->default(0)->comment('文章Id');
            $table->text('article_content')->nullable()->comment('内容');
            // 索引
            $table->index('article_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_contents');
    }
}
