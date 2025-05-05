<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginRequest;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        try {
            return view('pages.auth.admin.login');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Unable to load login form. Please try again.');
        }
    }

    public function login(AdminLoginRequest $request)
    {
        try {
            
            // Credentials are already validated through AdminLoginRequest
            $credentials = $request->validated();
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back!');
            }
    
            return back()->with('error', 'Invalid credentials.')->withInput($request->except('password'));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again.')->withInput($request->except('password'));
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('admin')->logout();
            
          
            return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to logout. Please try again.');
        }
    }
}
