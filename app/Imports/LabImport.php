<?php

namespace App\Imports;

use App\Lab;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Carbon\Carbon;

class LabImport implements ToModel, WithHeadingRow, WithValidation
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

        return new Lab([
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
        'nama' => 'required|string',
        'satuan' => 'required|string',
        'harga' => 'nullable|numeric',
        // so on
    ];
}
}
