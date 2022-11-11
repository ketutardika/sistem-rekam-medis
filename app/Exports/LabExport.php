<?php

namespace App\Exports;

use App\Lab;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LabExport implements WithHeadings, ShouldAutoSize, WithMapping, FromQuery, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Lab::all();
    }

    public function query()
    {
        return Lab::query()->where('deleted', '=', 0);
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Satuan',
            'Harga',
            'Di Buat',
            'Di Update',
            ];
    }
    
    public function map($row): array
    {
        return [
            $row->nama,
            $row->satuan,
            $row->harga,
            $row->created_time,
            $row->updated_time
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
    }
}
