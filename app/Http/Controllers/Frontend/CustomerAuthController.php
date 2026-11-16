<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    // Account Page
    public function index()
    {
        if (Auth::guard('customer')->check()) {
            return view('frontend.account.dashboard', [
                'customer' => Auth::guard('customer')->user(),
            ]);
        }

        return redirect()->route('account.login');
    }

    // Login Page
    public function showLogin()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('account.index');
        }

        return view('frontend.account.login');
    }

    // Registration Page
    public function showRegister()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('account.index');
        }

        return view('frontend.account.register');
    }

    // Customer Registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:30|unique:customers,phone',
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['status'] = 'active';

        $customer = Customer::create($validated);

        Auth::guard('customer')->login($customer);

        $request->session()->regenerate();

        return redirect()
            ->route('account.index')
            ->with('success', 'Your account has been created successfully!');
    }

    // Customer Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['status'] = 'active';

        if (Auth::guard('customer')->attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('account.index'))
                ->with('success', 'Welcome back!');
        }

        return back()
            ->withErrors([
                'email' => 'Invalid login details or your account is not active.',
            ])
            ->onlyInput('email');
    }

    // Customer Logout
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->regenerate();

        return redirect()
            ->route('account.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
