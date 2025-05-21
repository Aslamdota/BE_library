<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProfilController extends Controller
{
    public function viewProfil($id){
        $users = User::findOrFail($id);
        return view('profil.index', compact('users'), ['title' => 'Profil Admin']);
    }

    public function updateProfil(Request $request, $id){
        // return $request;
        $request->validate([
            'name' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $users = User::findOrFail($id);
        $users->name = $request->name;

        if ($request->hasFile('avatar')) {

            if ($users->avatar) {
                Storage::disk('public')->delete($users->avatar);    
            }

            $file = $request->file('avatar')->store('users', 'public');
            $users->avatar = $file;
        }

        
        $users->save();

        $notif = array(
            'message' => 'User berhasil diupdate',
            'alert-type' => 'info'
        );

        return redirect()->route('profil.admin', $users->id)->with($notif);
    }

    public function updatePassword(Request $request, $id){
        // return $request;
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|max:10|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::findOrFail($id);
        if (!Hash::check($request->old_password, $user->password)) {

            throw ValidationException::withMessages([
                'old_password' => 'Password Lama Tidak Sesuai'
            ]);

        }

        
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }
}
