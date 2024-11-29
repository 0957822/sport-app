<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('pages.register');
    }
    public function store(Request $request)
    {
        $messages = [
            'password.min' => 'The password must be at least 10 characters.',
            'password.regex' => 'The password must contain at least one number and one symbol (!@#$%^&*()).'
        ];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:10',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*()]/',
                'confirmed'
            ],
        ], $messages);

        // Create user with properly escaped data
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'login_count' => 0
        ]);

        session()->flash('success', 'Registration successful! Please login.');

        return redirect()->route('login')
            ->with('registration_success', true)
            ->with('email', $validated['email']);
    }}
