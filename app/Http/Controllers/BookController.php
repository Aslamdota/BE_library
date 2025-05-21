<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Loan;
use Carbon\Carbon;
use Carbon\Month;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\New_;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('category')->paginate(10);
        $books->getCollection()->transform(function ($book) {
            $book->cover_image = $book->cover_image 
                ? asset('storage/covers/' . $book->cover_image) 
                : null;
            return $book;
        });
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'required|string|unique:books',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->isbn = $request->isbn;
        $book->publication_year = $request->publication_year;
        $book->stock = $request->stock;
        $book->description = $request->description;
        $book->category_id = $request->category_id;

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/covers', $filename);
            $book->cover_image = $filename;
        }

        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('category');
        return response()->json([
            'status' => 'success',
            'data' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' . $book->id,
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stock' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        if ($request->has('title')) $book->title = $request->title;
        if ($request->has('author')) $book->author = $request->author;
        if ($request->has('publisher')) $book->publisher = $request->publisher;
        if ($request->has('isbn')) $book->isbn = $request->isbn;
        if ($request->has('publication_year')) $book->publication_year = $request->publication_year;
        if ($request->has('stock')) $book->stock = $request->stock;
        if ($request->has('description')) $book->description = $request->description;
        if ($request->has('category_id')) $book->category_id = $request->category_id;

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image) {
                Storage::delete('public/covers/' . $book->cover_image);
            }
            $image = $request->file('cover_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/covers', $filename);
            $book->cover_image = $filename;
        }

        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Book updated successfully',
            'data' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Delete cover image if exists
        if ($book->cover_image) {
            Storage::delete('public/covers/' . $book->cover_image);
        }
        
        $book->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Book deleted successfully'
        ]);
    }

    /**
     * Search books by title, author, or ISBN
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $books = Book::where('title', 'like', "%{$query}%")
                    ->orWhere('author', 'like', "%{$query}%")
                    ->orWhere('isbn', 'like', "%{$query}%")
                    ->with('category')
                    ->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    /**
     * Get books by category
     */
    public function getByCategory($categoryId)
    {
        $books = Book::where('category_id', $categoryId)
                    ->with('category')
                    ->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $books
        ]);
    }

    public function getRecomendation($memberId){
        $favorit = Borrowing::where('member_id', $memberId)
                        ->join('books', 'borrowings.book_id', '=', 'books.id')
                        ->join('categories', 'books.category_id', '=', 'categories.id')
                        ->select('categories.id')
                        ->groupBy('categories.id')
                        ->orderByRaw('COUNT(categories.id) DESC')
                        ->limit(3)
                        ->pluck('categories.id');

        $recommendedBooks = Book::whereIn('category_id', $favorit)
                        ->whereNotIn('id', Borrowing::where('member_id', $memberId)->pluck('book_id'))
                        ->orderBy('title', 'asc')
                        ->limit(5)
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $recommendedBooks
        ]);
    }

    public function bestSeller(){
        $bestSeller = Book::withCount('borrowings')
                    ->orderBy('borrowings_count', 'asc')->limit(5)->get();

        return response()->json([
            'status' => 'success',
            'data' => $bestSeller
        ]);
    }

    public function latestBooks()
    {
        // Ambil 4 buku terbaru berdasarkan created_at
        $books = Book::orderBy('created_at', 'desc')->take(4)->get();

        return response()->json($books);
    }
    
}