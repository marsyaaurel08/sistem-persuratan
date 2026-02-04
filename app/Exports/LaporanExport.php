<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $laporans;

    public function __construct(Collection $laporans)
    {
        $this->laporans = $laporans;
    }

    public function collection()
    {
        return $this->laporans->map(function ($item) {
            return [
                'No. Surat' => $item->no_surat,
                'Perihal' => $item->perihal,
                'Divisi' => $item->divisi,
                'Tanggal' => Carbon::parse($item->tanggal)->format('d M Y'),
                'Status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['No. Surat', 'Perihal', 'Divisi', 'Tanggal', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '28A745'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A:A')->getFont()->setBold(true);

        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
