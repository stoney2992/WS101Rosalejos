<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use Auth;
use App\Models\AddClass;
use App\Models\User;
use App\Models\AssignClassModel;
use App\Models\AssignClassPupil;
use App\Models\AddLesson;
use App\Models\Quiz;
use Twilio\Rest\Client;



class AssignClassController extends Controller 
{
    public function index()
{
    $teacherAssignments = AssignClassModel::getRecord();
    $assign_class = AddClass::orderBy('created_at')->get();
    $teachers = User::where('roles', 'teacher')->get();


    return view('assign_class.index', [
        'assign_class' => $assign_class,
        'teachers' => $teachers,
        'teacherAssignments' => $teacherAssignments,
    ]);
}
 
    
        public function assign(Request $request)
        {
            if (!empty($request->teacher_id)) {
                foreach ($request->teacher_id as $teacher_id) {
                    $getAlreadyFirst = AssignClassModel::getAlreadyFirst($request->class_id, $teacher_id);
        
                    if (!empty($getAlreadyFirst)) {
                        $getAlreadyFirst->status = $request->status;
                        $getAlreadyFirst->save();
                    } else {
                        $save = new AssignClassModel;
                        $save->class_id = $request->class_id;
                        $save->teacher_id = $teacher_id;
                        $save->status = $request->status;
                        $save->created_by = Auth::user()->id;
                        $save->save();
                    }
                }
                return redirect('assign_class/index')->with("Assign class to teacher successfully");
            } else {
                return redirect()->back()->with('error', 'Due to some error please try again');
            }
        }
        

        public function MyClass()
        {
            $getRecord = AssignClassModel::getMyClass(Auth::user()->id);
    
            if (request()->expectsJson()) {
                return response()->json($getRecord);
            } else {
                return view('assign_class.MyClass', compact('getRecord'));
            }
        }


        public function pupil()
    {
        $pupilAssignments = AssignClassPupil::getRecord();
        $assignClasses = AddClass::orderBy('created_at')->get();
        $pupils = User::where('roles', 'pupil')->get();

        if (request()->expectsJson()) {
            return response()->json(compact('assignClasses', 'pupils', 'pupilAssignments'));
        } else {
            return view('assign_class.pupil', compact('assignClasses', 'pupils', 'pupilAssignments'));
        }
    }


        public function addClass(Request $request)
        {
            // dd($request->all());

            if (!empty($request->pupil_id)) {
                foreach ($request->pupil_id as $pupil_id) {
                    $getAlreadyFirst = AssignClassPupil::getAlreadyFirst($request->class_id, $pupil_id);
        
                    if (!empty($getAlreadyFirst)) {
                        $getAlreadyFirst->status = $request->status;
                        $getAlreadyFirst->save();
                    } else {
                        $save = new AssignClassPupil;
                        $save->class_id = $request->class_id;
                        $save->pupil_id = $pupil_id;
                        $save->status = $request->status;
                        $save->created_by = Auth::user()->id;
                        $save->save();
                    }
                }
                return redirect('assign_class/pupil')->with("Assign class to pupil successfully");
            } else {
                return redirect()->back()->with('error', 'Due to some error please try again');
            }
        }

        public function myclassPupils()
    {
        $getRecord = AssignClassPupil::getMyClass(Auth::user()->id);

        if (request()->expectsJson()) {
            return response()->json($getRecord);
        } else {
            return view('assign_class.myclassPupils', compact('getRecord'));
        }
    }


        public function delete($id)
        {
            $save = AssignClassModel::getSingle($id);
            $save->delete();
            return redirect()->back()->with("Deleted successfully");
        } 

        public function destroy($id)
        {
            $save = AssignClassPupil::getSingle($id);
            $save->delete();
            return redirect()->back()->with("Deleted successfully");
        } 




        

        public function deleteLesson($id)
        {
    // Find the lesson by ID
    $lesson = AddLesson::find($id);

    // Check if the lesson exists
    if ($lesson) {
        // Check if the lesson belongs to the authenticated user
        if ($lesson->user_id == Auth::user()->id) {
            // Delete the lesson
            $lesson->delete();
            return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('success', 'Lesson deleted successfully');
        } else {
            return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('error', 'You do not have permission to delete this lesson');
        }
    } else {
        return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('error', 'Lesson not found');
    }
        }




        public function addLesson($id)
{
    // Get assigned pupils for the specified class
    $assignedPupils = AssignClassPupil::where('class_id', $id)->get();

    // Call the method to get saved lessons
    $savedLessons = $this->getSavedLessons($id);

    // Now, you can pass the $assignedPupils variable to the view
    return view('assign_class.addLesson', compact('savedLessons', 'id', 'assignedPupils'));
}




public function mylessonPupils($class_id)
{
    // Get class data with lessons using Eloquent relationships
    $classData = AddClass::with('lessons')->find($class_id);

    // Check if the class exists
    if (!$classData) {
        // Return a JSON response with an error message
        return response()->json(['error' => 'Class not found'], 404);
    }

    // Get lessons related to the class and the authenticated user
    
    $lessonData = $classData->lessons->where('user_id', Auth::user()->id);

    // Return the data as a JSON response
    return response()->json([
        'classData' => $classData,
        'lessonData' => $lessonData
    ]);
}



// Make sure the method is public
public function getSavedLessons($class_id)
{
    // Retrieve the lessons for the specified class ID and user ID
    $savedLessons = AddLesson::where('class_id', $class_id)
        ->where('user_id', Auth::user()->id)
        ->get();

    return $savedLessons;
}


public function postLesson(Request $request)
{
    // Validate the request data
    $request->validate([
        'class_id' => 'required',
        'quarter' => 'required',
        'topic' => 'required',
    ]);

    // Create a new Lesson instance
    $add_lesson = new AddLesson();

    // Set the values from the form data
    $add_lesson->class_id = $request->class_id;
    $add_lesson->quarter = $request->quarter;
    $add_lesson->topic = $request->topic;
    $add_lesson->user_id = Auth::user()->id; // Add the user_id

    // Save the lesson to the database
    $add_lesson->save();

    // Fetch all pupils in the class
    $pupils = AssignClassPupil::where('class_id', $request->class_id)
                              ->pluck('pupil_id')
                              ->toArray();
    $pupilUsers = User::whereIn('id', $pupils)->get();

    // SMS message content
    $message = "A new lesson on '{$request->quarter}' has been added to your class.";
    
    // Send SMS to all pupils
    $this->sendSmsToPupils($pupilUsers, $message);

    // Redirect to the addLesson route with the saved lesson ID
    return redirect()->route('assign_class.addLesson', $request->class_id);
}

private function sendSmsToPupils($pupils, $message)
{
    $twilio = new Client(getenv('TWILIO_SID'), getenv('TWILIO_TOKEN'));

    foreach ($pupils as $pupil) {
        if (!empty($pupil->phone)) {
            $formattedNumber = '+63' . substr($pupil->phone, 1);
            try {
                $twilio->messages->create($formattedNumber, [
                    'from' => getenv('TWILIO_PHONE'),
                    'body' => $message
                ]);
            } catch (\Exception $e) {
                \Log::error('SMS Sending Error to pupil ' . $pupil->id . ': ' . $e->getMessage());
            }
        }
    }
}


  

public function editLesson($id)
{
    // Find the lesson by ID
    $lesson = AddLesson::find($id);

    // Check if the lesson exists
    if ($lesson) {
        // Check if the lesson belongs to the authenticated user
        if ($lesson->user_id == Auth::user()->id) {
            return view('assign_class.editLesson', compact('lesson'));
        } else {
            return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('error', 'You do not have permission to edit this lesson');
        }
    } else {
        return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('error', 'Lesson not found');
    }
}

public function updateLesson(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'quarter' => 'required',
        'topic' => 'required',
    ]);

    // Find the lesson by ID
    $lesson = AddLesson::find($id);

    // Check if the lesson exists
    if ($lesson) {
        // Check if the lesson belongs to the authenticated user
        if ($lesson->user_id == Auth::user()->id) {
            // Update the lesson with new values
            $lesson->quarter = $request->quarter;
            $lesson->topic = $request->topic;
            // Update other fields as needed

            // Save the updated lesson
            $lesson->save();

            return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('success', 'Lesson updated successfully');
        } else {
            return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('error', 'You do not have permission to edit this lesson');
        }
    } else {
        return redirect()->route('assign_class.addLesson', $lesson->class_id)->with('error', 'Lesson not found');
    }


}







public function viewAssigned()
    {
        $assignedClasses = AssignClassPupil::getRecord();
        $groupedClasses = $assignedClasses->groupBy('class_id');
        $assignedTeachers = AssignClassModel::whereIn('class_id', $groupedClasses->keys())->get()->keyBy('class_id');

        if (request()->expectsJson()) {
            return response()->json(compact('groupedClasses', 'assignedTeachers'));
        } else {
            return view('assign_class.viewAssignClass', compact('groupedClasses', 'assignedTeachers'));
        }
    }


    public function viewQuizzes($classId)
    {
        $quizzes = Quiz::where('class_id', $classId)->get();

        if (request()->expectsJson()) {
            return response()->json($quizzes);
        } else {
            return view('assign_class.view_quizzes', compact('quizzes'));
        }
    }
















 


}
