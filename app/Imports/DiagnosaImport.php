<?php

namespace App\Imports;

use App\Diagnosa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Carbon\Carbon;

class DiagnosaImport implements ToModel, WithHeadingRow, WithValidation
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

        return new Diagnosa([
            'kode_diagnosa' => $row['kode_diagnosa'],
            'nama_diagnosa' => $row['nama_diagnosa'],
            'keterangan' => $row['keterangan'],
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
        'kode_diagnosa' => 'required|string',
        'nama_diagnosa' => 'required|string',
        'keterangan' => 'nullable|string',
        // so on
    ];
}
}
