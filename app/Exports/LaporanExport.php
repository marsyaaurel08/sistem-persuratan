<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class LaporanExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $laporans;
    protected $periode;

    /**
     * @param \Illuminate\Support\Collection $laporans
     * @param string $periode
     */
    public function __construct(Collection $laporans, string $periode = 'Periode: Semua Data')
    {
        $this->laporans = $laporans;
        $this->periode = $periode;
    }

    /**
     * Data yang akan diexport ke Excel
     */
    public function collection()
    {
        return $this->laporans->map(function ($item) {
            return [
                'Kode Arsip'    => $item->kode_arsip,
                'No. Surat'     => $item->nomor_surat,
                'Perihal'       => $item->perihal,
                'Kategori'      => $item->kategori,
                'Tanggal Arsip' => $item->tanggal_arsip
                    ? Carbon::parse($item->tanggal_arsip)->format('d M Y')
                    : '-',
            ];
        });
    }

    /**
     * Header (judul + periode + kolom tabel)
     */
    public function headings(): array
    {
        return [
            ['LAPORAN PERSURATAN KLINIK JASA TIRTA'], // Judul
            [$this->periode],                         // Periode
            [],                                       // Baris kosong
            ['Kode Arsip', 'No. Surat', 'Perihal', 'Kategori', 'Tanggal Arsip'], // Header tabel
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Merge judul & periode
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');

        // Style Judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style Periode
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Header tabel
        $sheet->getStyle('A4:E4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '28A745'], // Hijau
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Tambahkan border
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A4:E{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '999999'],
                ],
            ],
        ]);

        // Auto-size semua kolom
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
