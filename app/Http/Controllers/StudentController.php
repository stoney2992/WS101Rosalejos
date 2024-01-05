<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function viewTeachers()
    {
        $teachers = User::where('roles', 'teacher')
                        ->has('schedules') // This will only get teachers with schedules
                        ->with('schedules') // Eager load the schedules
                        ->get();

        return view('students.viewTeachers', compact('teachers'));
    }
}

