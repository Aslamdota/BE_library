<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'sometimes|in:admin,staff,anggota',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'anggota',
            'avatar' => 'avatar.jpg'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'member has not actived'
            ]);
        }

        if (!$member || !Hash::check($request->password, $member->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login credentials',
            ], 401);
        }


        if ($member->is_login) {
            return response()->json([
                'status' => 'error',
                'message' => 'This account is already logged in from another device',
            ], 403);
        }

        $member->is_login = true;
        $member->save();


        // Buat token (jika Member pakai Laravel Sanctum)
        $token = $member->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $member,
        ]);
    }

    /**
     * Proses logout pengguna.
     */

    public function logout(Request $request)
    {
        $user = $request->user();

        // Hapus semua token
        $user->tokens()->delete();

        // Set is_login jadi false
        $user->is_login = false;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $member = Member::where('email', $request->email)->first();
        if (!$member) {
            return response()->json([
                'message' => 'Email not found'
            ], 404);
        }

        $credential = ['email' => $request->input('email')];
        $status = Password::broker('members')->sendResetLink($credential);
        // Buat token (jika Member pakai Laravel Sanctum)
        $token = $member->createToken('auth_token')->plainTextToken;

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status),
                                'acces_token' => $token
            ])
            : response()->json(['message' => __($status)], 400);

    }


    public function newPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $status = Password::broker('members')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($member, $password){
                $member->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }


}
