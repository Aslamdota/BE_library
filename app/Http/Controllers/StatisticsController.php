<?php


namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Returns;

class StatisticsController extends Controller
{
    public function index()
    {
        // data buku dengan jmlh peminjaman
        $books = Book::withCount('loans')->orderBy('loans_count', 'desc')->take(5)->get();
        $labels = $books->pluck('title');
        $counts = $books->pluck('loans_count');

        // Mengambil data peminjaman berdasarkan status
        $loanStatus = Loan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();
        $labelReturn = $loanStatus->pluck('status');
        $countReturn = $loanStatus->pluck('total');

        $countBook = Book::count();
        $countMember = Member::count();
        $loans = Loan::count();
        $return = Loan::where('status', 'returned')->count();

        return response()->json([
            'book' => $countBook,
            'member' => $countMember,
            'loan' => $loans,
            'return' => $return,

            'book_data' => [
                'labelBook' => $labels,
                'countBook' => $counts,
            ],
            'loan_data' => [
                'labelReturn' => $labelReturn,
                'countReturn' => $countReturn,
            ],

        ], 200);

    }
}


