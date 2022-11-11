<?php

namespace App\Exports;

use App\Pasien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PasienExport implements WithHeadings, ShouldAutoSize, WithMapping, FromQuery, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pasien::all();
    }

    public function query()
    {
        return Pasien::query()->where('deleted', '=', 0);
    }

    public function headings(): array
    {
        return [
            'ID Pasien',
            'Nama',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'No Hp',
            'Pendidikan',
            'Pekerjaan',
            'Jenis Pasien',
            'No BPJS',
            'Alergi',
            'Tinggi Badan',
            'Berat Badan',
            'Lingkar Perut',
            'IMT',
            'Sistole',
            'Diastole',
            'Respiratory Rate',
            'Heart Rate',
            'Di Buat',
            'Di Update',
            ];
    }
    
    public function map($row): array
    {
        return [
            $row->no_pasien,
            $row->nama,
            $row->tgl_lhr,
            $row->jk,
            $row->alamat,
            $row->hp,
            $row->pendidikan,
            $row->pekerjaan,
            $row->jenis_asuransi,
            $row->no_bpjs,
            $row->alergi,
            $row->tb,
            $row->bb,
            $row->lp,
            $row->imt,
            $row->stole,
            $row->dtole,
            $row->rr,
            $row->hr,
            $row->created_time,
            $row->updated_time
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:U1')->getFont()->setBold(true);
    }
}
