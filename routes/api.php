<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReturnBook;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// reset password member
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/new-password', [AuthController::class, 'newPassword']);


// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // member
    Route::put('/update/profile/{id}', [MemberController::class, 'update']);
    Route::put('/update/password/{id}', [MemberController::class, 'UpdatePassword']);
    // Route::get('/profil/user', [AuthController::class, 'ProfilUser']);

    // Book routes
    Route::apiResource('books', BookController::class);

    // cari buku
    Route::get('/books/search', [BookController::class, 'search']);
    // Route::get('/books/latest', [BookController::class, 'latest']);

    // get buku by category
    Route::get('/books/category/{category}', [BookController::class, 'getByCategory']);

    // create buku hilang
    Route::post('/bookMissing/{id}', [LoanController::class, 'missingBooks']);

    // kompensasi ganti buku
    Route::post('/compensationBooks/{id_missing}', [LoanController::class, 'compensationBooks']);

    // buku favorite
    Route::get('/recomendation/{memberId}', [BookController::class, 'getRecomendation']);
    // buku terlaris /populer
    Route::get('/bestSeller', [BookController::class, 'bestSeller']);
    Route::get('/latestBook', [BookController::class, 'latestBooks']);

    // Category routes
    Route::apiResource('categories', CategoryController::class);

    // Member routesss
    Route::apiResource('members', MemberController::class);


    // member
    Route::get('/members/search', [MemberController::class, 'search']);
    Route::get('/myProfile/{id}', [MemberController::class, 'myProfile']);

    // Borrowing routes
    Route::apiResource('borrowings', BorrowingController::class);


    // Route::middleware('auth:sanctum')->get('/loans', [LoanController::class, 'index']);

    // create peminjaman
    Route::post('/loansBook', [LoanController::class, 'loanBook']);

    // acc peminjaman
    Route::post('/loans/{id}', [LoanController::class, 'approveBorrowing']);

    // tolak peminjaman
    Route::post('/loans/rejected/{id}', [LoanController::class, 'rejectedBorrowing']);

    // get pengembalian
    Route::get('/getReturned', [LoanController::class, 'getReturnedLoans']);

    // get all pending peminjaman
    Route::get('/getBorrowing', [LoanController::class, 'getBorrowing']);

    // get all borrowed peminjaman
    Route::get('/getLoan', [LoanController::class, 'getLoan']);

    // get all borrowed peminjaman by id
    Route::get('/getLoan/{id}', [LoanController::class, 'getLoanMember']);

    // delete peminjaman
    Route::post('/clearReturned', [LoanController::class, 'clearReturnedLoans']);

    // kembalikan peminjaman
    Route::put('/returns/{loan}', [ReturnBook::class, 'returnBook']);

    // get buku telat dikembalikan
    Route::get('/borrowings/overdue', [BorrowingController::class, 'getOverdue']);


    Route::get('/statistics', [StatisticsController::class, 'index']);

});
