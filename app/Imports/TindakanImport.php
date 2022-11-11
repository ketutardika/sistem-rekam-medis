<?php

namespace App\Imports;

use App\Tindakan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Carbon\Carbon;

class TindakanImport implements ToModel, WithHeadingRow, WithValidation
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

        return new Tindakan([
            'no_tindakan' => $row['no_tindakan'],
            'nama' => $row['nama'],
            'satuan' => $row['satuan'],
            'harga' => $row['harga'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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
        'no_tindakan' => 'nullable|string',
        'nama' => 'required|string',
        'satuan' => 'nullable|string',
        'harga' => 'required|numeric',
        // so on
    ];
}
}
