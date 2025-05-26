<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

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
}
