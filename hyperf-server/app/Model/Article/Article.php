<?php

declare (strict_types = 1);

namespace App\Model\Article;

use App\Model\Model;
use App\Model\Upload\UploadFile;

/**
 */
class Article extends Model
{
    protected $primaryKey = 'article_id';

    public function cover()
    {
        return $this->hasOne(UploadFile::class, 'file_id', 'article_cover');
    }

    public function content()
    {
        return $this->hasOne(ArticleContent::class, 'article_id', 'article_id');
    }

    public function getArticleByTitle($article_title)
    {
        return $this->cnpscyDetail(['article_title' => $article_title]);
    }
}