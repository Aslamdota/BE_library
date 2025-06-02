<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Member::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:15',
            'member_id' => 'required|string',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required',
            'address' => 'required|string|max:255'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validasi->errors()
            ], 422);
        }



        $member = new Member();
        $member->name = $request->name;
        $member->member_id = $request->member_id;
        $member->email = $request->email;
        $member->phone = $request->phone;
        $member->address = $request->address;

        if ($member->is_login) {
            return response()->json([
                'status' => 'error',
                'message' => 'This account is already logged in from another device',
            ], 403);
        }

        $member->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Members has a created',
            'data' => $member
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:15',
            // 'member_id' => 'sometimes|required|string',
            // 'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'required',
            'address' => 'required|string|max:255',
            'password' => 'sometimes|nullable|string|min:6'
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validasi->errors(),
            ], 422);
        }

        $member->update([
            'name' => $request->name,
            // 'member_id' => $member->member_id,
            // 'email' => $member->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $member->password = bcrypt($request->password);
            $member->save();
        }

        if ($request->hasFile('avatar')) {
            if ($member->avatar && $member->avatar !== 'avatar.jpg') {
                Storage::delete('members/' . $member->avatar);
            }

            $avatarName = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->storeAs('members', $avatarName);
            $member->avatar = $avatarName;
            $member->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Member updated successfully',
            'data' => $member

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'members has destroy'
        ]);
    }

    public function search(Request $request){
        $query = $request->input('query');

        $member = Member::where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $member
        ]);

    }

    public function myProfile($id){
        $member = Member::findOrFail($id);

        if (!$member) {
            return response()->json([
                'status' => 'errors',
                'message' => 'member notfound'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'  => $member
        ]);
    }


    // public function UpdateProfil($id, Request $request){

    //     $member = Member::findOrFail($id);

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|sometimes|string|max:255',
    //         'email' => 'required|sometimes',
    //         'avatar' => 'required|sometimes|image|mimes:jpg,jpeg,png|max:2048'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $validator->errors()
    //         ], 422);
    //     }


    //     if($request->has('name')) $member->name = $request->name;
    //     if($request->has('email')) $member->email = $request->name;

    //     if ($request->hasFile('avatar')) {
    //         if ($member->avatar !== 'avatar.jpg') {
    //             Storage::delete('avatars/' . $member->avatar);
    //         }

    //         $avatarName = time(). '.' . $request->file('avatar')->getClientOriginalExtension();
    //         $request->file('avatar')->storeAs('avatars', $avatarName);
    //         $member->avatar = $avatarName;
    //     }

    //     $member->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'mem$member has updated',
    //         'data' => $member
    //     ], 200);


    // }


    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|string|exists:members,member_id',
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $member = Member::where('member_id', $request->member_id)->first();

        if (!Hash::check($request->current_password, $member->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect.'
            ], 403);
        }

        $member->password = Hash::make($request->new_password);
        $member->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password has been updated.',
            'data' => $member
        ], 200);
    }


    public function ProfilUser(){
        // $member = Member::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'errors',
                'message' => 'user notfound'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'  => $user
        ]);
    }



}
