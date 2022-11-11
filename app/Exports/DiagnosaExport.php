<?php

namespace App\Exports;

use App\Diagnosa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DiagnosaExport implements WithHeadings, ShouldAutoSize, WithMapping, FromQuery, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Diagnosa::all();
    }

    public function query()
    {
        return Diagnosa::query()->where('deleted', '=', 0);
    }

    public function headings(): array
    {
        return [
            'Kode Diagnosa',
            'Nama Diagnosa',
            'Keterangan',
            'Di Buat',
            'Di Update',
            ];
    }
    
    public function map($row): array
    {
        return [
            $row->kode_diagnosa,
            $row->nama_diagnosa,
            $row->keterangan,
            $row->created_at,
            $row->updated_at
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
    }
}
