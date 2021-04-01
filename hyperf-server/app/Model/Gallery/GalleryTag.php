<?php

namespace App\Model\Gallery;

use App\Model\Model;
use App\Model\Rabc\AdminMenu;

class GalleryTag extends Model
{
    protected $primaryKey = 'tag_id';

    public function getGalleryTagByName($tag_name)
    {
        return $this->cnpscyDetail(['tag_name' => $tag_name]);
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class, 'gallery_with_tags', 'tag_id', 'gallery_id');
    }
}