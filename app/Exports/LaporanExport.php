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
        return $this->laporans->values()->map(function ($item, $index) {
            return [
                'No'            => $index + 1,
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
            ['LAPORAN PERSURATAN KLINIK JASA TIRTA'],
            [$this->periode],
            [],
            ['No', 'Kode Arsip', 'No. Surat', 'Perihal', 'Kategori', 'Tanggal Arsip'],
        ];
    }


    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Merge judul & periode
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        // =========================
        // STYLE JUDUL
        // =========================
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // =========================
        // STYLE PERIODE
        // =========================
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'italic' => true,
                'size'   => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // =========================
        // STYLE HEADER TABEL
        // =========================
        $sheet->getStyle('A4:F4')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'], // teks putih
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '000B58'], // WARNA BARU
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // =========================
        // BORDER SELURUH TABEL
        // =========================
        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle("A4:F{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => '999999'],
                ],
            ],
        ]);

        // =========================
        // CENTER KOLOM NO & KATEGORI
        // =========================
        $sheet->getStyle("A5:A{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("E5:E{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // =========================
        // AUTO SIZE KOLOM
        // =========================
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
