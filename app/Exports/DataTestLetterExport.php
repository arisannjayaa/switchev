<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class DataTestLetterExport implements FromCollection, withHeadings, withStyles, WithEvents
{
    protected $start, $end, $type, $status;

    public function __construct($start, $end, $type, $status)
    {
        $this->start = $start;
        $this->end = $end;
        $this->type = $type;
        $this->status = $status;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $counter = 0;
        return \App\Models\CertificateTestLetter::with(['user', 'test_letter'])
            ->whereBetween('created_at', [$this->start, $this->end])
            ->when($this->type != "", function ($query) {
                $query->whereHas('test_letter', function ($q) {
                    $q->where('workshop_type', $this->type);
                });
            })
            ->when($this->status != "", function ($query) {
                $query->whereHas('test_letter', function ($q) {
                   $q->where('status', $this->status);
                });
            })
            ->get()
            ->map(function ($item) use (&$counter) {
                $counter++;
                return [
                    'No.' => $counter,
                    'Pemohon' => $item->user->name ?? '-',
                    'Penanggung Jawab' => $item->test_letter->responsible_person ?? '-',
                    'Tipe Bengkel' => $item->test_letter->workshop_type ?? '-',
                    'Nama Bengkel' => $item->test_letter->workshop ?? '-',
                    'Alamat Bengkel' => $item->test_letter->address ?? '-',
                    'No. Telepon' => $item->test_letter->telephone ?? '-',
                    'Status' => $item->status ?? '-',
                    'Tanggal' => $item->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            ['Laporan Data SRUT dan SUT'], // <-- Judul
            ['Periode: ' . $this->start . ' s/d ' . $this->end],
            [], // Baris kosong sebelum header tabel
            ['No.',
                'Pemohon',
                'Penanggung Jawab',
                'Tipe Bengkel',
                'Nama Bengkel',
                'Alamat Bengkel',
                'No. Telepon',
                'Status',
                'Tanggal',]
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Judul
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['italic' => true]],
            4 => ['font' => ['bold' => true]], // header tabel
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Menggabungkan sel untuk judul dan periode
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');

                // Format font dan ukuran judul dan subjudul
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Bold pada header kolom (baris ke-4)
                $sheet->getStyle('A4:I4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Menentukan tinggi baris header
                $sheet->getRowDimension(4)->setRowHeight(20);

                // Auto width kolom A sampai H
                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Hitung jumlah baris terakhir
                $lastRow = $sheet->getHighestRow();

                // Tambahkan border ke semua sel dari A4 sampai H[lastRow]
                $sheet->getStyle("A4:I{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

}
