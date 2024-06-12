<?php

namespace App\Imports;

use App\Models\Box;
use App\Models\Rak;
use Illuminate\Support\Collection;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RakImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Rak([
            'nomor_rak' => $row['nomor_rak'], 
            'deskripsi' => $row['deskripsi'],
        ]);
    }

}
