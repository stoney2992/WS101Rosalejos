<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request) 
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();
  
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $request->roles
        ]);
  
        return redirect('login');
    }
    
    public function login()
    {
        return view('auth/login');
    }


    
    public function loginAction(Request $request)
{
    Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ])->validate();

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        // Check if the request expects a JSON response
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    $user = Auth::user();

    // If the request is from an API client
    if ($request->expectsJson()) {
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // For web requests, proceed as normal
    $request->session()->regenerate();
    $request->session()->put('name', $user->name);
    return $this->redirectBasedOnRole($user->roles);
}


private function redirectBasedOnRole($role)
{
    switch ($role) {
        case 'admin':
            return redirect('dashboard');
        case 'teacher':
            return redirect()->route('schedules.index');
        case 'student':
            return redirect()->route('students.viewTeachers');
        default:
            return redirect('/');
    }
}





    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
  
        $request->session()->invalidate();
  
        return redirect('/login');
    }

    public function profile()
    {
        return view('profile');
    }

    public function dashboard()
    {
        $username = auth()->user()->name; // Get the authenticated user's name

        return view('dashboard', compact('username'));
    }


    








}
