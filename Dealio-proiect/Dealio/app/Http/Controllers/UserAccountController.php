<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserAccountController extends Controller
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|unique:users',
            'full_name' => 'required',
            'phone_number' => 'required|unique:users|numeric',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',

        ]);

        $user = User::create($validated);
        Auth::login($user);
        return redirect()->route('products.index')
            ->with('success', 'Account created!');
    }
}

