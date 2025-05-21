<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Loan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Finemaster;

class ReturnBook extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function returnBook(Loan $loan)
    {
        if ($loan->status === 'returned') {
            return response()->json([
                'status' => 'error',
                'message' => 'This book has already been returned'
            ], 400);
        }

        $today = Carbon::today();

        $loan->return_date = $today;
        $finemaster = Finemaster::where('status', 'active')->first();

        if ($today->isAfter($loan->due_date)) {
            $daysLate = $today->diffInDays($finemaster->date_priode);
            $finePerDay = $finemaster->fine_amount;
            $loan->fine = $daysLate * $finePerDay;
            $loan->status = 'overdue';
        } else {
            $loan->status = 'returned';
        }

        $loan->save();

        // Increase book stock
        $book = Book::find($loan->book_id);
        $book->stock += 1;
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book returned successfully',
            'data' => $loan->load(['book', 'member', 'staff'])
        ]);
    }
}
