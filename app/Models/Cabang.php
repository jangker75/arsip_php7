<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Cabang extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = "cabang";
    protected $fillable = [
        "client_id",
        "nama",
        "alamat",
        'created_at',
        'updated_at',
    ];
    public function getPhotosAttribute()
    {
        $files = $this->getMedia('photo_cabang');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
        });

        return $files;
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function attImage()
    {
        return $this->media()->where('collection_name', 'photo_cabang');
    }
}
