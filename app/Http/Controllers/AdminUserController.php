<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
    $users = User::whereIn('roles', ['teacher', 'student'])->get();
    return view('admin.users.index', compact('users'));
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $userId)
{
    // Validate the request data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $userId,
        'password' => 'nullable|string|min:6',
    ]);

    // Find the user
    $user = User::findOrFail($userId);

    // Update user details
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    
    // Update password if provided
    if (!empty($validatedData['password'])) {
        $user->password = Hash::make($validatedData['password']);
    }

    // Save the changes
    $user->save();

    // Redirect with a success message
    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
