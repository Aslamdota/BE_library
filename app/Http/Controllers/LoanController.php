<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\DueDateMaster;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use App\Models\Book_missing;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data loans dengan relasi book dan member
        $loans = Loan::with(['book', 'member'])->get();

        // Debugging
        // dd($loans);

        // Kirim data ke view
        return view('peminjaman.index', ['title' => 'Peminjaman'], compact('loans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:Pending,Approved',
        ]);

        $loan->status = $validated['status'];
        $loan->save();

        return response()->json(['success' => true, 'data' => $loan]);
    }

    public function getBorrowing()
    {
        $borrowings = Loan::where('status', 'pending')->with(['book', 'member', 'staff'])->get();

        $borrowings = $borrowings->map(function ($loan) {
            $loan->book_title = $loan->book->title ?? null;
            return $loan;
        });

        return response()->json([
            'status' => 'success',
            'data' => $borrowings
        ]);
    }

    public function getLoan()
    {
        $borrowings = Loan::whereIn('status', ['borrowed', 'overdue'])
        ->where('status_delete', 0)
        ->with(['book', 'member', 'staff'])->get();

        $borrowings = $borrowings->map(function ($loan) {
            $loan->book_title = $loan->book->title ?? null;
            return $loan;
        });

        return response()->json([
            'status' => 'success',
            'data' => $borrowings
        ]);
    }

    public function getLoanMember($id)
    {
        $borrowings = Loan::findOrFail($id)->whereIn('status', ['borrowed', 'overdue'])
        ->where('status_delete', 0)
        ->with(['book', 'member', 'staff'])->get();

        $borrowings = $borrowings->map(function ($loan) {
            $loan->book_title = $loan->book->title ?? null;
            return $loan;
        });

        return response()->json([
            'status' => 'success',
            'data' => $borrowings
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $loan = Loan::create([
            'book_id' => $request->book_id,
            'user_id' => auth()->id(),
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Loan request created',
            'loan' => $loan
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = $request->status; // 'Approved' atau 'Rejected'
        $loan->save();

        return response()->json([
            'success' => true,
            'message' => 'Loan updated',
            'loan' => $loan
        ]);
    }


    public function loanBook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,member_id',
        ], [
            'member_id.exists' => 'The member ID is invalid or does not exist',
            'book_id.exists' => 'The book ID is invalid or does not exist'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $now = Carbon::now();

        $member = Member::where('member_id', $request->member_id)->first();
        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member not found'
            ], 404);
        }

        $book = Book::find($request->book_id);
        if (!$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found'
            ], 404);
        }

        if ($book->stock <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book is not available for borrowing'
            ], 400);
        }

        $existingLoan = Loan::where('book_id', $request->book_id)
            ->where('member_id', $member->id)
            ->whereNotIn('status', ['returned', 'rejected'])
            ->first();

        if ($existingLoan) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already borrowed this book and it has not been returned yet.',
            ], 409);
        }

        $dueDateSetting = DueDateMaster::where('status', 'active')->first();

        if (!$dueDateSetting) {
            return response()->json([
                'status' => 'error',
                'message' => 'Due date configuration not found'
            ], 400);
        }

        $randomStaff = User::whereIn('role', ['admin', 'karyawan'])->inRandomOrder()->first();

        try {
            DB::beginTransaction();

            $loan = Loan::create([
                'book_id' => $request->book_id,
                'member_id' => $member->id,
                'loan_date' => $now,
                'due_date' => Carbon::parse($dueDateSetting->due_date),
                'jumlah' => 1,
                'status' => 'pending',
                'staff_id' => $randomStaff ? $randomStaff->id : null
            ]);

            // $book->decrement('stock');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Book loan request created successfully',
                'data' => $loan->load(['book', 'member', 'staff'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create loan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function approveBorrowing($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'due_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $loan = Loan::find($id);
        if (!$loan || $loan->status != 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid loan request or already processed'
            ], 404);
        }

        $loan->status = 'borrowed';
        $loan->due_date = $request->due_date;
        // $loan->status_fine = 'unpaid';
        $loan->save();

        $book = $loan->book;
        $book->stock -= 1;
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book loan approved',
            'data' => $loan->load(['book', 'member', 'staff'])
        ], 200);
    }

    public function rejectedBorrowing($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'noted' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $loan = Loan::find($id);
        if (!$loan || $loan->status != 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid loan request or already processed'
            ], 404);
        }

        $loan->status = 'rejected';
        $loan->noted = $request->noted;
        $loan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book loan rejected',
            'data' => $loan->load(['book', 'member', 'staff'])
        ], 200);
    }

    public function getReturnedLoans()
    {
        $loans = Loan::where('status', 'returned')
        ->where('status_delete', 0)
        ->with(['book'])->get();

        $loans = $loans->map(function ($loan) {
            return [
                'id' => $loan->id,
                'book_title' => $loan->book->title ?? 'Tanpa Judul',
                'loan_date' => $loan->loan_date,
                'updated_at' => $loan->updated_at,
                'status' => $loan->status,
                // 'status_fine' => 'paid'
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $loans
        ]);
    }

    public function clearReturnedLoans(Request $request)
    {
        try {
            $member = Member::where('member_id', $request->member_id)->first();

            if (!$member) {
                return response()->json([
                    'message' => 'Member tidak ditemukan.'
                ], 404);
            }

            $updated = Loan::where('member_id', $member->id)
                ->where('status', 'returned')
                ->update(['status_delete' => 1]);

            if ($updated == 0) {
                return response()->json([
                    'message' => 'Tidak ada data peminjaman yang perlu dihapus.'
                ], 200);
            }

            return response()->json([
                'message' => 'Riwayat pengembalian berhasil dihapus.',
                'jumlah_dihapus' => $updated
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus riwayat.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    //aslam
    public function missingBooks(Request $request, $id){
        $book = Book::where('id', $id)->first();

        $isbn = $book->isbn;
        $month = Carbon::now();
        $loans = Loan::where('member_id', $request->member_id)
                ->where('book_id', $id)
                ->whereMonth('loan_date', $month->month)
                ->whereYear('loan_date', $month->year)
                ->count();

        if ($loans > 0) {
            $missing = new Book_missing();
            $missing->isbn = $isbn;
            $missing->member_id = $request->member_id;
            $missing->date_of_los = now();
            $missing->status = 'missing';
            $missing->save();

        }

        return response()->json([
            'status' => 'success',
            'message' => 'Book has missing'
        ], 200);
    }

    //regi
    public function compensationBooks(Request $request, $id)
    {
        try {
            $book_missing = Book_missing::find($id);

            if (!$book_missing) {
                return response()->json([
                    'message' => 'Data Buku Hilang Tidak Ditemukan.',
                    'status' => 404
                ], 404);
            }
            $book_missing->status = 'replaced';
            $book_missing->save();
            $book = Book::where('isbn', $book_missing->isbn)->first();
            if ($book) {
                $book->stock += 1;
                $book->save();
            }

           if ($request->has('member_id')) {
                $loan = Loan::where('member_id', $book_missing->member_id)
                ->where('book_id', $book->id)
                ->whereMonth('loan_date', now()->month)
                ->whereYear('loan_date', now()->year)
                ->first();

                if ($loan) {
                    $loan->status = 'lost-compensated';
                    $loan->save();
                }
            }
            return response()->json([
                'message' => 'Buku berhasil diganti, stok diperbarui, dan data peminjaman diperbarui.',
                'status' => 200
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada sistem.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function allFine(){
        $now = Carbon::now();

        $allFine = Loan::with('member')
        ->where(function ($query) use ($now) {
            $query->whereNotNull('fine')
                  ->where('fine', '>', 0);
        })
        ->orWhere(function ($query) use ($now) {
            $query->where('status', 'borrowed')
                  ->whereDate('due_date', '<', $now);
        })
        ->groupBy('member_id')
        ->selectRaw('member_id, SUM(fine) as total_fine')
        ->with('member')
        ->get();

        return response()->json([
            'message' => 'success',
            'data' => $allFine
        ]);
    }

    public function fineByMember($memberId){
         $now = Carbon::now();

        $fineData = Loan::with('member')
            ->where('member_id', $memberId)
            ->where(function ($query) use ($now) {
                $query->whereNotNull('fine')
                    ->where('fine', '>', 0)
                    ->orWhere(function ($q) use ($now) {
                        $q->where('status', 'borrowed')
                            ->whereDate('due_date', '<', $now);
                    })
                    ->orWhere(function ($q) {
                        $q->where('status', 'returned')
                            ->whereColumn('return_date', '>', 'due_date');
                    });
            })
            ->selectRaw('member_id, SUM(fine) as total_fine')
            ->groupBy('member_id')
            ->with('member')
            ->first();

            return response()->json([
                'message' => 'success',
                'data' => $fineData
            ]);
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
