<?php

namespace App\Exports;

use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class FinesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $now = Carbon::now();

        return Loan::with(['member', 'book'])
            ->where('status', 'overdue')
                ->orWhere('fine', '!=', 0)
                ->latest()
                ->get()
            ->map(function ($loan, $index) {
            return [
                'No' => $index + 1,
                'Nama Member' => $loan->member->name ?? '-',
                'Judul Buku' => $loan->book->title ?? '-',
                'Tanggal Pinjam' => Carbon::parse($loan->loan_date)->translatedFormat('d M Y'),
                'Jatuh Tempo' => Carbon::parse($loan->due_date)->translatedFormat('d M Y'),
                'Status' => match ($loan->status) {
                    'borrowed' => 'Dipinjam',
                    'returned' => 'Dikembalikan',
                    'overdue'  => 'Terlambat',
                    default    => '-',
                },
                'Denda' => 'Rp' . number_format($loan->fine ?? 0, 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'no',
            'Nama Member',
            'Judul Buku',
            'Tanggal Pinjam',
            'Jatuh Tempo',
            'Status',
            'Denda',
        ];
    }
}

