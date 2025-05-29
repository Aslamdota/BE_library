<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class MembersController extends Controller
{
    public function viewMembers()
    {
        if (request()->ajax()) {
            $members = Member::latest();
            return DataTables::of($members)
                ->addIndexColumn()
                ->addColumn('avatar', function ($member) {
                    return '<img src="' . asset('storage/' . $member->avatar) . '" class="product-img-2" alt="Avatar">';
                })
                ->addColumn('address', function ($member) {
                    $short = Str::limit(strip_tags($member->address), 15);
                    return '<span title="' . e($member->address) . '">' . e($short) . '</span>';
                })
                ->addColumn('action', function ($member) {
                    return '
                        <a href="' . route('edit.member', $member->id) . '" class="badge bg-primary">Edit</a>
                        <a href="' . route('destroy.member', $member->id) . '" class="badge bg-danger delete-btn">Hapus</a>
                    ';
                })
                ->rawColumns(['avatar', 'action', 'address'])
                ->make(true);
        }

        // Jika bukan AJAX, render halaman
        $title = 'viewMember';
        return view('member.index', compact('title'));
    }

    public function storeMember(Request $request){
        // return $request;
        $request->validate([
            'name' => 'required|string|max:255',
            // 'member_id' => 'required|string|max:255|unique:members',
            'address' => 'required|string|max:255|',
            'email' => 'required|string|email|max:255|unique:members',
            'Password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $avatar = NULL;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('members', 'public');
        }

        Member::create([
            'name' => $request->name,
            'member_id' => hexdec(uniqid()),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'avatar' => $avatar,
        ]);

        $notif = array(
            'message' => 'Member Berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('view.member')->with($notif);
    }

    public function editMember($id){
        $members = Member::findOrFail($id);
        return view('member.edit', compact('members'), ['title' => 'Edit Member']);
    }

    public function updateMember(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // 'member_id' => 'required|string|max:255|unique:members',
            // 'email' => 'required|string|email|max:255|unique:members',
            // 'Password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $members = Member::findOrFail($id);

        if ($request->hasFile('avatar')) {
            if ($members->avatar) {
                Storage::disk('public')->delete($members->avatar);
            }

            $file = $request->file('avatar')->store('members', 'public');
            $members->avatar = $file;
        }

        $members->name = $request->name;
        // $members->member_id = $request->member_id;
        // $members->email = $request->email;
        $members->phone = $request->phone;
        $members->address = $request->address;

        $members->save();

        $notification = array(
                'message' => 'Members Berhasil diedit',
                'alert-type' => 'success'
            );

        return redirect()->route('view.member')->with($notification);
    }

    public function destroyMember($id){
        $members = Member::findOrFail($id);

        if ($members->avatar) {
            Storage::disk('public')->delete($members->avatar);    
        }

        $members->delete();
        $notification = array(
                'message' => 'Members Berhasil diedit',
                'alert-type' => 'success'
            );

        return redirect()->route('view.member')->with($notification);
    }
}
