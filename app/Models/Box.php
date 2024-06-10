<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $table = 'box';
    protected $fillable = [
        'cabang_id', 
        'client_id',
        'unit_kerja_id',
        'lokasi_vault_id',
        'jenis_dok_id',
        'status_id',
        'status_approve',
        'nama',
        'jumlah_dok',
        'nomor_rak',
        'kode_box',
        'kode_box_sistem',
        'file_atc',
        'tgl_input',
        'tgl_pemindahan',
        'foto_1',
        'foto_2',
        'foto_3',
        'foto_3',
        'keterangan',
    ];
}