<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'member', 'staff'])
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $borrowings
        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     */

    // create borrowing
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'book_id' => 'required|exists:books,id',
    //         'member_id' => 'required|exists:members,id',
    //         'borrow_date' => 'required|date|date_format:Y-m-d',
    //         'due_date' => 'required|date|date_format:Y-m-d|after_or_equal:borrow_date',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()
    //         ], 422);
    //     }

    //     // Check if book is available (stock > 0)
    //     $book = Book::find($request->book_id);
    //     if ($book->stock <= 0) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Book is not available for borrowing'
    //         ], 400);
    //     }

    //     // $member = auth()->user()->member_id;

    //     // Create new borrowing record
    //     $borrowing = new Borrowing();
    //     $borrowing->book_id = $request->book_id;
    //     $borrowing->member_id = $request->member_id;
    //     $borrowing->borrow_date = $request->borrow_date;
    //     $borrowing->due_date = $request->due_date;
    //     $borrowing->status = 'borrowed';
    //     $borrowing->staff_id = auth()->id(); // Current authenticated user (staff/admin)
    //     $borrowing->save();

    //     // Decrease book stock
    //     $book->stock -= 1;
    //     $book->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Book borrowed successfully',
    //         'data' => $borrowing->load(['book', 'member', 'staff'])
    //     ], 201);
    // }

    // create peminjaman
    // public function loanBook(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'book_id' => 'required|exists:books,id',
    //         'member_id' => 'required|exists:members,id',
    //         'borrow_date' => 'required|date|date_format:Y-m-d',
    //         'due_date' => 'required|date|date_format:Y-m-d|after_or_equal:borrow_date',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()
    //         ], 422);
    //     }

    //     // Check if book is available (stock > 0)
    //     $book = Book::find($request->book_id);
    //     if ($book->stock <= 0) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Book is not available for borrowing'
    //         ], 400);
    //     }

    //     // $member = auth()->user()->member_id;

    //     // Create new borrowing record
    //     $borrowing = new Borrowing();
    //     $borrowing->book_id = $request->book_id;
    //     $borrowing->member_id = $request->member_id;
    //     $borrowing->borrow_date = $request->borrow_date;
    //     $borrowing->due_date = $request->due_date;
    //     $borrowing->status = 'borrowed';
    //     $borrowing->staff_id = auth()->id(); // Current authenticated user (staff/admin)
    //     $borrowing->save();

    //     // Decrease book stock
    //     $book->stock -= 1;
    //     $book->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Book borrowed successfully',
    //         'data' => $borrowing->load(['book', 'member', 'staff'])
    //     ], 201);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['book', 'member', 'staff']);
        
        return response()->json([
            'status' => 'success',
            'data' => $borrowing
        ]);
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return response()->json([
                'status' => 'error',
                'message' => 'This book has already been returned'
            ], 400);
        }

        $today = Carbon::today();
        $borrowing->return_date = $today;
        
        // Calculate fine if returned late
        if ($today->isAfter($borrowing->due_date)) {
            $daysLate = $today->diffInDays($borrowing->due_date);
            $finePerDay = 1000; // Rp 1.000 per day
            $borrowing->fine = $daysLate * $finePerDay;
            $borrowing->status = 'overdue';
        } else {
            $borrowing->status = 'returned';
        }
        
        $borrowing->save();

        // Increase book stock
        $book = Book::find($borrowing->book_id);
        $book->stock += 1;
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book returned successfully',
            'data' => $borrowing->load(['book', 'member', 'staff'])
        ]);
    }

    /**
     * Get overdue borrowings.
     */

    
    public function getOverdue()
    {
        $today = Carbon::today();
        
        $overdue = Borrowing::where('status', 'borrowed')
                          ->where('due_date', '<', $today)
                          ->with(['book', 'member', 'staff'])
                          ->orderBy('due_date')
                          ->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $overdue
        ]);
    }

    public function getBorrowing() {
        $borrowing = Borrowing::where('status', 'pending')
            ->with(['book', 'member', 'staff'])
            ->get(); // <- tambahkan ini
    
        return response()->json([
            'status' => 'success',
            'data' => $borrowing
        ]);
    }
}