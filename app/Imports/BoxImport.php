<?php

namespace App\Imports;

use App\Models\Box;
use Illuminate\Support\Collection;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BoxImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Box([
            'cabang_id' => $row['cabang_id'], 
            'client_id' => $row['client_id'],
            'unit_kerja_id' => $row['unit_kerja_id'],
            'lokasi_vault_id' => $row['lokasi_vault_id'],
            'jenis_dok_id' => $row['jenis_dok_id'],
            'status_id' => $row['status_id'],
            'status_approve' => $row['status_approve'],
            'nama' => $row['nama'],
            'jumlah_dok' => $row['jumlah_dok'],
            'nomor_rak' => $row['nomor_rak'],
            'kode_box' => $row['kode_box'],
            'kode_box_sistem' => $row['kode_box_sistem'],
            'file_atc' => $row['file_atc'],
            'tgl_input' => $row['tgl_input'],
            'tgl_pemindahan' => $row['tgl_pemindahan'],
            'foto_1' => $row['foto_1'],
            'foto_2' => $row['foto_2'],
            'foto_3' => $row['foto_3'],
            'foto_3' => $row['foto_3'],
            'keterangan' => $row['keterangan'],
        ]);
    }

}
