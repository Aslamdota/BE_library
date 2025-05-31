<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function reportLoan(){
        if (request()->ajax()) {
            $loans = Loan::with(['member', 'book'])
            ->where('status', 'borrowed')->latest()->get();

            return DataTables::of($loans)
            ->addIndexColumn()
            ->addColumn('member_name', fn($row) => $row->member->name ?? '-')
            ->addColumn('book_title', fn($row) => $row->book->title ?? '-')
            ->addColumn('loan_date', fn($row) => Carbon::parse($row->loan_date)->translatedFormat('d M Y'))
            ->addColumn('due_date', fn($row) => Carbon::parse($row->due_date)->translatedFormat('d M Y'))
            ->addColumn('status', function($row) {
                $label = '-';
                if ($row->status === 'borrowed') {
                    $label = 'Dipinjam';
                } elseif ($row->status === 'returned') {
                    $label = 'Dikembalikan';
                } elseif ($row->status === 'overdue') {
                    $label = 'Terlambat';
                }

                return '<span class="badge bg-primary text-white">'.$label.'</span>';
            })

            ->addColumn('fine', fn($row) => 'Rp'.number_format($row->fine ?? 0, 0, ',', '.'))
            ->rawColumns(['status'])
            ->make(true);
        }

        return view('reports.report-loan', ['title' => 'Report Loan']);
    }

    public function cetakLoan(){
        $now = Carbon::now()->translatedFormat(' d F Y H:i:s');
        $loans = Loan::with(['member', 'book'])
            ->where('status', 'borrowed')->latest()->get();

        return view('reports.cetak-loan', compact('loans', 'now'), ['title' => 'cetakLoan']);
    }

    public function reportReturn(){
        if (request()->ajax()) {
            $returned = Loan::with(['member', 'book'])
            ->where('status', 'returned')->latest()->get();

            return DataTables::of($returned)
            ->addIndexColumn()
            ->addColumn('member_name', fn($row) => $row->member->name ?? '-')
            ->addColumn('book_title', fn($row) => $row->book->title ?? '-')
            ->addColumn('loan_date', fn($row) => Carbon::parse($row->loan_date)->translatedFormat('d M Y'))
            ->addColumn('due_date', fn($row) => Carbon::parse($row->due_date)->translatedFormat('d M Y'))
            ->addColumn('return_date', fn($row) => Carbon::parse($row->return_date)->translatedFormat('d M Y'))
            ->addColumn('status', function($row) {
                $label = '-';
                if ($row->status === 'borrowed') {
                    $label = 'Dipinjam';
                } elseif ($row->status === 'returned') {
                    $label = 'Dikembalikan';
                } elseif ($row->status === 'overdue') {
                    $label = 'Terlambat';
                }

                return '<span class="badge bg-primary text-white">'.$label.'</span>';
            })

            ->addColumn('fine', fn($row) => 'Rp'.number_format($row->fine ?? 0, 0, ',', '.'))
            ->rawColumns(['status'])
            ->make(true);
        }

        return view('reports.report-return', ['title' => 'Report Return']);
    }

    public function cetakReturn(){
        $now = Carbon::now()->translatedFormat('d F Y H:i:s');
        $returned = Loan::with(['member', 'book'])
            ->where('status', 'returned')->latest()->get();

        return view('reports.cetak-return', compact('returned', 'now'));
    }

    public function reportFine(){
            if (request()->ajax()) {
            $now = Carbon::now()->translatedFormat('d F Y H:i:s');

            $fines = Loan::with(['member', 'book'])
                ->where(function ($query) use ($now) {
                    $query->whereNotNull('fine')->where('fine', '>', 0)
                        ->orWhere(function ($q) use ($now) {
                            $q->where('status', 'borrowed')->whereDate('due_date', '<', $now);
                        })
                        ->orWhere(function ($q) {
                            $q->where('status', 'returned')->whereColumn('return_date', '>', 'due_date');
                        });
                })
                ->latest()
                ->get();

            return DataTables::of($fines)
                ->addIndexColumn()
                ->addColumn('member_name', fn($row) => $row->member->name ?? '-')
                ->addColumn('book_title', fn($row) => $row->book->title ?? '-')
                ->addColumn('loan_date', fn($row) => Carbon::parse($row->loan_date)->translatedFormat('d M Y'))
                ->addColumn('due_date', fn($row) => Carbon::parse($row->due_date)->translatedFormat('d M Y'))
                ->addColumn('status', function($row) {
                    $label = '-';
                    if ($row->status === 'borrowed') {
                        $label = 'Dipinjam';
                    } elseif ($row->status === 'returned') {
                        $label = 'Dikembalikan';
                    } elseif ($row->status === 'overdue') {
                        $label = 'Terlambat';
                    }

                    return '<span class="badge bg-primary text-white">'.$label.'</span>';
                })

                ->addColumn('fine', fn($row) => 'Rp'.number_format($row->fine ?? 0, 0, ',', '.'))
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('reports.report-fine', ['title' => 'Report Fine']);

        
    }

    public function cetakFIne(){
        $now = Carbon::now();
        
        $fines = Loan::with(['member', 'book', 'staff'])
            ->where(function ($query) use ($now) {
                $query->whereNotNull('fine')->where('fine', '>', 0)
                    ->orWhere(function ($q) use ($now) {
                        $q->where('status', 'borrowed')->whereDate('due_date', '<', $now);
                    })
                    ->orWhere(function ($q) {
                        $q->where('status', 'returned')->whereColumn('return_date', '>', 'due_date');
                    });
            })
            ->latest()
            ->get();

        return view('reports.cetak-fine', compact('fines', 'now'));
    }
}
