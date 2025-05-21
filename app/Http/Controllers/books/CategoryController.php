<?php

namespace App\Http\Controllers\books;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function viewCategory(){
        if (request()->ajax()) {
            $categories = Category::latest()->get();
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($category) {
                    return '
                        <a href="' . route('edit.category', $category->id) . '" class="badge bg-primary">Edit</a>
                        <a href="' . route('destroy.category', $category->id) . '" class="badge bg-danger delete-btn-category">Hapus</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Jika bukan AJAX, render halaman
        $title = 'viewCategory';
        $categories = Category::latest()->get();
        return view('category.index', compact('title', 'categories'));
    }

    public function addCategory(Request $request){
       $request->validate([
            'name' => 'required',
            'code' => 'required|unique:categories,code,'
        ]);

        Category::create([
           'name' => $request->name,
           'code' => $request->code,
        ]);

        session()->flash('active_tab', 'category');

        $notification = array(
                'message' => 'Kategori Berhasil ditambah',
                'alert-type' => 'success'
            );

        return redirect()->route('view.books')->with($notification);
    }

    public function editCategory($id){
        $categories = Category::findOrFail($id);

        return view('category.edit', compact('categories'), ['title' => 'viewEdit']);
    }

    public function updateCategory(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->code = $request->code;

        $category->save();
        session()->flash('active_tab', 'category');

        $notification = array(
                'message' => 'Kategori Berhasil diedit',
                'alert-type' => 'success'
            );

        return redirect()->route('view.books')->with($notification);        
    }

    public function destroyCategory($id){
        $category = Category::findOrFail($id);

        $category->delete();
        session()->flash('active_tab', 'category');

        $notification = array(
                'message' => 'Kategori Berhasil diedit',
                'alert-type' => 'success'
            );

        return redirect()->route('view.books')->with($notification);   
    }
}
