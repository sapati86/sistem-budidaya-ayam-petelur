<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $jenis;
    protected $bulan;
    protected $tahun;

    public function __construct($data, $jenis, $bulan, $tahun)
    {
        $this->data = $data;
        $this->jenis = $jenis;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }


    public function collection()
    {
        return $this->data;
    }


    public function headings(): array
    {
        $headers = ['No', 'Tanggal'];

        switch ($this->jenis) {
            case 'produksi':
                $headers = array_merge($headers, [
                    'Kandang',
                    'Jumlah Produksi',
                    'Jumlah Rusak',
                    'Kualitas',
                    'Berat Rata-rata (gram)',
                    'Dicatat oleh'
                ]);
                break;

            case 'konsumsi':
                $headers = array_merge($headers, [
                    'Kandang',
                    'Pakan',
                    'Jumlah',
                    'Satuan',
                    'Dicatat oleh'
                ]);
                break;

            case 'kesehatan':
                $headers = array_merge($headers, [
                    'Kode Ayam',
                    'Jenis Penyakit',
                    'Gejala',
                    'Tindakan',
                    'Status',
                    'Dicatat oleh'
                ]);
                break;
        }

        return $headers;
    }

    public function map($item): array
    {
        static $no = 0;
        $no++;

        $row = [$no, $item->tanggal->format('d/m/Y')];

        switch ($this->jenis) {
            case 'produksi':
                $row = array_merge($row, [
                    $item->kandang->nama ?? '-',
                    $item->jumlah_produksi,
                    $item->jumlah_rusak,
                    $item->kualitas,
                    $item->berat_rata_rata ?? '-',
                    $item->creator->name ?? '-'
                ]);
                break;

            case 'konsumsi':
                $row = array_merge($row, [
                    $item->kandang->nama ?? '-',
                    $item->pakan->nama ?? '-',
                    $item->jumlah,
                    $item->satuan,
                    $item->creator->name ?? '-'
                ]);
                break;

            case 'kesehatan':
                $row = array_merge($row, [
                    $item->ayam->kode_ayam ?? '-',
                    $item->jenis_penyakit,
                    $item->gejala,
                    $item->tindakan,
                    $item->status_label ?? $item->status,
                    $item->creator->name ?? '-'
                ]);
                break;
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF3B82F6'],
                ],
                'font' => ['color' => ['argb' => 'FFFFFFFF']],
            ],
        ];
    }
}