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


// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // member
    Route::put('/update/profile/{id}', [MemberController::class, 'update']);
    Route::put('/update/password/{id}', [MemberController::class, 'UpdatePassword']);
    Route::get('/profil/user', [AuthController::class, 'ProfilUser']);

    // Book routes
    Route::apiResource('books', BookController::class);
    Route::get('/books/search', [BookController::class, 'search']);
    Route::get('/books/latest', [BookController::class, 'latest']);
    Route::get('/books/category/{category}', [BookController::class, 'getByCategory']);

    Route::post('/bookMissing/{id}', [LoanController::class, 'missingBooks']);
    Route::post('/compensationBooks/{id_missing}', [LoanController::class, 'compensationBooks']);

    // buku favorite
    Route::get('/recomendation/{memberId}', [BookController::class, 'getRecomendation']);
    // buku terlaris /populer
    Route::get('/bestSeller', [BookController::class, 'bestSeller']);

    // Category routes
    Route::apiResource('categories', CategoryController::class);

    // Member routesss
    Route::apiResource('members', MemberController::class);


    // member
    Route::get('/members/search', [MemberController::class, 'search']);
    Route::get('/myProfile/{id}', [MemberController::class, 'myProfile']);

    // Borrowing routes
    Route::apiResource('borrowings', BorrowingController::class);


    Route::middleware('auth:sanctum')->get('/loans', [LoanController::class, 'index']);
    Route::post('/loansBook', [LoanController::class, 'loanBook']);
    Route::post('/loans/{id}', [LoanController::class, 'approveBorrowing']);
    Route::post('/loans/rejected/{id}', [LoanController::class, 'rejectedBorrowing']);
    Route::get('/getReturned', [LoanController::class, 'getReturnedLoans']);

    Route::get('/getBorrowing', [LoanController::class, 'getBorrowing']);
    Route::get('/getLoan', [LoanController::class, 'getLoan']);
    Route::get('/getLoan/{id}', [LoanController::class, 'getLoanMember']);
    Route::delete('/clearReturned', [LoanController::class, 'clearReturnedLoans']);

    Route::put('/returns/{loan}', [ReturnBook::class, 'returnBook']);
    Route::get('/borrowings/overdue', [BorrowingController::class, 'getOverdue']);


    Route::get('/statistics', [StatisticsController::class, 'index']);

});
