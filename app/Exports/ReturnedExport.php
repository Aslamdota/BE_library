<?php

namespace App\Exports;

use App\Models\Loan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReturnedExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Loan::with(['member', 'book'])
        ->where('status', 'returned')
        ->latest()->get()
        ->map(function($loan, $index){
            return [
                'No' => $index + 1,
                'Nama Member' => $loan->member->name ?? '-',
                'Judul Buku' => $loan->book->title ?? '-',
                'Tanggal Pinjam' => Carbon::parse($loan->loan_date)->translatedFormat('d M Y'),
                'Jatuh Tempo' => Carbon::parse($loan->due_date)->translatedFormat('d M Y'),
                'Tanggal Dikembalikan' => Carbon::parse($loan->return_date)->translatedFormat('d M Y'),
                'Status' => match ($loan->status) {
                    'borrowed' => 'Dipinjam',
                    'returned' => 'Dikembalikan',
                    'overdue'  => 'Terlambat',
                    default    => '-',
                },
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
            'Tanggal Dikembalikan',
            'Status',
        ];
    }
}
