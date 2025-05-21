<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function viewUsers()
    {
        if (request()->ajax()) {
            $users = User::latest();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('avatar', function ($user) {
                    return '<img src="' . asset('storage/' . $user->avatar) . '" class="product-img-2" alt="Avatar">';
                })
                ->addColumn('action', function ($user) {
                    return '
                        <a href="' . route('edit.user', $user->id) . '" class="badge bg-primary">Edit</a>
                        <a href="' . route('destroy.user', $user->id) . '" class="badge bg-danger delete-btn">Hapus</a>
                    ';
                })
                ->rawColumns(['avatar', 'action'])
                ->make(true);
        }

        // Jika bukan AJAX, render halaman
        $title = 'viewUsers';
        return view('users.index', compact('title'));
    }


    public function storeUsers(Request $request)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $avatar = NULL;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('users', 'public');
        }


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'avatar' => $avatar,
        ]);

        $notif = array(
            'message' => 'User Berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('view.user')->with($notif);
    }

    public function editUsers($id)
    {
        $users = User::findOrFail($id);
        return view('users.edit', compact('users'), ['title' => 'Edit User']);
    }

    public function updateUsers(Request $request, $id)
    {
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8',
            'role' => 'required|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $users = User::findOrFail($id);
        $users->name = $request->name;
        // $users->email = $request->email;
        $users->role = $request->role;

        if ($request->hasFile('avatar')) {
            if ($users->avatar) {
                Storage::disk('public')->delete($users->avatar);
            }

            $file = $request->file('avatar')->store('users', 'public');
            $users->avatar = $file;
        }

        $users->save();

        $notif = array(
            'message' => 'User Berhasil diedit',
            'alert-type' => 'success'
        );
        return redirect()->route('view.user')->with($notif);
    }

    public function destroyUsers($id)
    {
        $users = User::findOrFail($id);

        if ($users->avatar) {
            Storage::disk('public')->delete($users->avatar);
        }
        $users->delete();

        $notif = array(
            'message' => 'User Berhasil dihapus',
            'alert-type' => 'success'
        );
        return redirect()->route('view.user')->with($notif);
    }
}
