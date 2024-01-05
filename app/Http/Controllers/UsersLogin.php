<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UsersLogin extends Controller
{
   
    public function loginT()
    {
        return view('teacher_login/login');
    }

    public function loginActionTT(Request $request)
    {
  
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('teacher_login.failed')
            ]);
        }
  
        $request->session()->regenerate();
  
        return redirect()->route('teacher_dashboard');
    }
}
