<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    // Ambil semua peminjaman (untuk admin / petugas)
    public function index()
    {
        return Borrowing::with(['book', 'member', 'staff'])->orderBy('created_at', 'desc')->get();
    }

    // Simpan peminjaman baru (oleh anggota)
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
        ]);

        $borrowing = Borrowing::create([
            'book_id' => $request->book_id,
            'member_id' => $request->member_id,
            'borrow_date' => $request->borrow_date,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Borrow request submitted', 'data' => $borrowing]);
    }

    // Konfirmasi peminjaman (oleh petugas)
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update([
            'status' => 'borrowed',
            'due_date' => now()->addDays(7), // atau sesuai aturan perpustakaan
        ]);

        return response()->json(['message' => 'Borrow approved']);
    }

    // Tolak peminjaman
    public function reject($id, Request $request)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update([
            'status' => 'rejected',
            'noted' => $request->noted,
        ]);

        return response()->json(['message' => 'Borrow rejected']);
    }

    // Pengembalian buku
    public function returnBook($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        return response()->json(['message' => 'Book returned']);
    }
}
