<?php

use App\Http\Controllers\auth\DashboardController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\ProfilController;
use App\Http\Controllers\books\BooksController;
use App\Http\Controllers\books\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\member\MembersController;
use App\Http\Controllers\member\UsersController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FineMasterController;
use App\Http\Controllers\peminjaman\PeminjamanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReportController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'viewLogin'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/dashboard', [DashboardController::class, 'viewDashboard'])->name('dashboard.admin')->middleware('auth');

Route::get('/profil/{id}', [ProfilController::class, 'viewProfil'])->name('profil.admin')->middleware('auth');
Route::post('/updateProfil/{id}', [ProfilController::class, 'updateProfil'])->name('update.admin')->middleware('auth');
Route::post('/updatePassword/{id}', [ProfilController::class, 'updatePassword'])->name('update.password')->middleware('auth');

Route::get('/viewBuku', [BooksController::class, 'viewBooks'])->name('view.books')->middleware('auth');
Route::post('/storeBook', [BooksController::class, 'storeBook'])->name('store.books')->middleware('auth');
Route::get('/editBook/{id}', [BooksController::class, 'editBook'])->name('edit.books')->middleware('auth');
Route::post('/updateBook/{id}', [BooksController::class, 'updateBook'])->name('update.books')->middleware('auth');
Route::get('/destroy/{id}', [BooksController::class, 'destroyBook'])->name('destroy.book');

// Route::get('/peminjaman', [LoanController::class, 'index'])->name('loans.index');
Route::get('/viewPeminjaman', [PeminjamanController::class, 'viewPeminjaman'])->name('view.peminjaman')->middleware('auth');
Route::post('/borrowings/confirm/{id}', [PeminjamanController::class, 'approveBorrowing'])->name('borrowings.confirm')->middleware('auth');
Route::post('/borrowings/reject/{id}', [PeminjamanController::class, 'rejectedBorrowing'])->name('borrowings.reject')->middleware('auth');

Route::get('/viewMembers', [MembersController::class, 'viewMembers'])->name('view.member')->middleware('auth');
Route::post('/storeMembers', [MembersController::class, 'storeMember'])->name('store.member')->middleware('auth');
Route::get('/editMember/{id}', [MembersController::class, 'editMember'])->name('edit.member');
Route::post('/updateMember/{id}', [MembersController::class, 'updateMember'])->name('update.member');
Route::get('/destroyMember/{id}', [MembersController::class, 'destroyMember'])->name('destroy.member');

Route::get('/viewUsers', [UsersController::class, 'viewUsers'])->name('view.user')->middleware('auth');
Route::get('/users/data', [UsersController::class, 'getUsersData'])->name('users.data');
Route::post('/storeUsers', [UsersController::class, 'storeUsers'])->name('store.user')->middleware('auth');
Route::get('/editUsers/{id}', [UsersController::class, 'editUsers'])->name('edit.user')->middleware('auth');
Route::post('/updateUsers/{id}', [UsersController::class, 'updateUsers'])->name('update.user')->middleware('auth');
Route::get('/destroyUsers/{id}', [UsersController::class, 'destroyUsers'])->name('destroy.user')->middleware('auth');
// web.php
// Route::delete('/users/{id}', [UsersController::class, 'destroyUsers'])->name('destroy.user')->middleware('auth');


Route::get('/viewCategory', [CategoryController::class, 'viewCategory'])->name('view.category')->middleware('auth');
Route::post('/addCategory', [CategoryController::class, 'addCategory'])->name('add.category')->middleware('auth');
Route::get('/editCategory/{id}', [CategoryController::class, 'editCategory'])->name('edit.category')->middleware('auth');
Route::post('/updateCategory/{id}', [CategoryController::class, 'updateCategory'])->name('update.category')->middleware('auth');
Route::get('/destriyCategory/{id}', [CategoryController::class, 'destroyCategory'])->name('destroy.category')->middleware('auth');


// Returns routes
Route::get('/loans/{loan}', [PeminjamanController::class, 'show'])->name('loans.show');

Route::get('/returns', [PeminjamanController::class, 'returnsIndex'])->name('returns.index');
Route::get('/returnsHistory', [PeminjamanController::class, 'returnsHistory'])->name('returns.history');

Route::get('/returns/data', [PeminjamanController::class, 'getLoansForReturn'])->name('returns.data');
Route::get('/returns/data_borrowing', [PeminjamanController::class, 'getLoansForBorrowing'])->name('returns.data_borrowing');

Route::get('/returns/data_pending', [PeminjamanController::class, 'getLoansForReturnPending'])->name('returns.pending_data');
Route::get('/returns/data_history', [PeminjamanController::class, 'getLoansForReturnHistory'])->name('returns.history_data');

Route::post('/loans/{loan}/return', [PeminjamanController::class, 'returnBook'])->name('loans.return');

// book missing
Route::get('/getBookMissing', [PeminjamanController::class, 'getBookMissing'])->name('get.book.missing');

// Fine settings routes
Route::get('/fine-settings', [FineMasterController::class, 'getFineSettings'])->name('fine.get');
Route::post('/fine-settings', [FineMasterController::class, 'updateFineSettings'])->name('fine.update');

// report
Route::get('/reportLoan', [ReportController::class, 'reportLoan'])->middleware('auth')->name('report.loan');
Route::get('/reportReturn', [ReportController::class, 'reportReturn'])->middleware('auth')->name('report.return');

