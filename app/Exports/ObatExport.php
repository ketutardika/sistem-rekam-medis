<?php

namespace App\Exports;

use App\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObatExport implements WithHeadings, ShouldAutoSize, WithMapping, FromQuery, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Obat::all();
    }

    public function query()
    {
        return Obat::query()->where('deleted', '=', 0);
    }

    public function headings(): array
    {
        return [
            'Nama Obat',
            'Sediaan',
            'Dosis',
            'Satuan',
            'Stok',
            'Harga',
            'Di Buat',
            'Di Update',
            ];
    }
    
    public function map($row): array
    {
        return [
            $row->nama_obat,
            $row->sediaan,
            $row->dosis,
            $row->satuan,
            $row->stok,
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
