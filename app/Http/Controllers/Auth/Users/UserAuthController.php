<?php

namespace App\Http\Controllers\Auth\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Intern;
use App\Http\Requests\InternRegisterRequest;
use App\Http\Requests\InternLoginRequest;
class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.intern.login');
    }

    public function login(InternLoginRequest $request)
    {
        try {
            $credentials = $request->validated();
          
            if (Auth::guard('intern')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('/'));
            }
            
            return back()
                ->with('error', 'Invalid credentials.')
                ->withInput($request->except('password'));
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput($request->except('password'));
        }
    }
    

    public function showRegisterForm()
    {
        return view('pages.auth.intern.register');
    }

    public function register(InternRegisterRequest $request)
    {
        try {
            $validated = $request->validated();
    
            $intern = Intern::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);
    
            return redirect()
                ->route('intern.login')
                ->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            // Log the error for debugging (optional but recommended)
            \Log::error('Intern Registration Failed: ' . $e->getMessage());
    
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong during registration. Please try again.');
        }
    }
    

    public function logout(Request $request)
    {
        try {
            
            Auth::guard('intern')->logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect()->route('intern.login')->with('success', 'You have been logged out.');
        } catch (\Exception $e) {
            \Log::error('Intern Logout Failed: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Something went wrong during logout. Please try again.');
        }
    }
    
}
