<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function viewDashboard(){
        $data = Book::withCount('loans')->get();

        $labels = $data->pluck('title')->toArray();
        $counts = $data->pluck('loans_count')->toArray();


        $dataReturn = Loan::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // Menyiapkan label dan jumlah peminjaman untuk chart
        $labelReturn = $dataReturn->pluck('status')->toArray();
        $countReturn = $dataReturn->pluck('total')->toArray();

        $pending = Loan::where('status', 'pending')->count();
        $borrowed = Loan::where('status', 'borrowed')->count();
        $rejected = Loan::where('status', 'rejected')->count();

        return view('dashboard.admin', 
        compact(
            'labels', 'counts', 
            'labelReturn', 'countReturn',
            'pending', 'rejected', 'borrowed'
        ),
        ['title' => 'Dashboard Page']);
    }
}
