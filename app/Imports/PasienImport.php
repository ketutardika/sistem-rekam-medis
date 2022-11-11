<?php

namespace App\Imports;

use App\Pasien;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Carbon\Carbon;

class PasienImport implements ToModel, WithHeadingRow, WithValidation
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

        return new Pasien([
            'no_pasien' => $row['no_pasien'],
            'nama' => $row['nama'],
            'tgl_lhr' => $row['tgl_lhr'],
            'alamat' =>  $row['alamat'],
            'pekerjaan' => $row['pekerjaan'],
            'hp' => $row['hp'],
            'jk' => $row['jk'],
            'pendidikan' => $row['pendidikan'],
            'jenis_asuransi' => $row['jenis_asuransi'],
            'no_bpjs' => $row['no_bpjs'],
            'alergi' => $row['alergi'],
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
        'no_pasien' => 'required|string',
        'nama' => 'required|string',
        'tgl_lhr' => 'required|date',
        'alamat' => 'required|string',
        'pekerjaan' => 'required|string',
        'hp' => 'required|numeric',
        'jk' => 'required|string',
        'pendidikan' => 'nullable|string',
        'jenis_asuransi' => 'nullable|string',
        'no_bpjs' => 'nullable|numeric',
        'alergi' => 'nullable|string',
        // so on
    ];
}
}
