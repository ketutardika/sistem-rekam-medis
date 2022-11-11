<?php

namespace App\Imports;

use App\Obat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Carbon\Carbon;

class ObatImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $rowCount = 0;

    public function model(array $row)
    {
        ++$this->rowCount;

        return new Obat([
            'nama_obat' => $row['nama_obat'],
            'sediaan' => $row['sediaan'],
            'dosis' => $row['dosis'],
            'satuan' => $row['satuan'],
            'stok' => $row['stok'],
            'harga' => $row['harga'],
            'created_time' => Carbon::now(),
            'updated_time' => Carbon::now(),
        ]);
    }

    public function getRowCount(): int
    {
        $count = count((array)$this->rowCount);
        return $count;
    }

    public function rules(): array
{
    return [
        'nama_obat' => 'required|string',
        'sediaan' => 'required|string',
        'dosis' => 'nullable|numeric',
        'satuan' => 'nullable|string',
        'stok' => 'nullable|numeric',
        'harga' => 'nullable|numeric',
        // so on
    ];
}
}
