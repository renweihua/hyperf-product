<?php

namespace App\Model\Gallery;

use App\Model\Model;

class Gallery extends Model
{
    protected $primaryKey = 'gallery_id';

    public function content_lists()
    {
        return $this->hasMany(GalleryDetail::class, $this->primaryKey, $this->primaryKey);
    }

    public function getGalleryByName($gallery_name)
    {
        return $this->cnpscyDetail(['gallery_name' => $gallery_name]);
    }
}