<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register
     * 
     * Register a new user with name, email and password
     */
    public function register(RegisterRequest $request) {
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);

        $user = User::create($request->toArray());

        return [
            'user' => $user->fresh(),
        ];
    }

    /**
     * Get User
     * 
     * Get the authenticated user
     */
    public function getUser(Request $request) {
        return [
            'data' => $request->user(),
        ];
    }

    /**
     * Get all users for admin
     */
    public function getAllUsers(Request $request) {
        if ($request->user()->role != 'admin') {
            return response([
                'message' => "This action is unauthorized."
            ], 403);
        }

        return [
            'data' => User::orderBy('name', 'ASC')->get()
        ];
    }

    /**
     * Logout
     * 
     * revoke the current access_token and refresh_token(s)
     */
    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();

        return [
            'message' => 'You have been successfully logged out!',
        ];
    }
}
