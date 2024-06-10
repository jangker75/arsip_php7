<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "client";
    protected $fillable = [
        "nama",
        "keterangan",
        "attachment_pks",
        'created_at',
        'updated_at',
    ];
}
