<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function reportLoan(){
        $reportLoan = Loan::where('status', 'borrowed')->get();

        return $reportLoan;
    }

    public function reportReturn(){
        $reportReturn = Loan::where('status', 'returned')->get();

        return $reportReturn;
    }

    public function reportFine(){
            if (request()->ajax()) {
            $now = Carbon::now();

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
                ->addColumn('status', fn($row) => '<span class="badge bg-primary text-white">'.$row->status.'</span>')
                ->addColumn('fine', fn($row) => 'Rp'.number_format($row->fine ?? 0, 0, ',', '.'))
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('reports.report-fine', ['title' => 'Report Fine']);

        
    }
}
