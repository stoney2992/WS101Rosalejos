<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AssignClassPupil;
use App\Models\User;

class QuizController extends Controller
{
    public function index($classId)
    {
        $quizzes = Quiz::where('class_id', $classId)->with('questions.choices')->get();

        if (request()->expectsJson()) {
            return response()->json($quizzes);
        } else {
            $quizAttempts = QuizAttempt::whereIn('quiz_id', $quizzes->pluck('id'))->with('user')->get();
            return view('quiz.quizIndex', compact('quizzes', 'classId', 'quizAttempts'));
        }
    }

    public function store(Request $request)
    {
        $quiz = new Quiz();
        $quiz->class_id = $request->class_id;
        $quiz->title = $request->input('title');
        $quiz->description = $request->input('description');
        $quiz->teacher_id = auth()->user()->id;
        $quiz->save();
 
        $pupils = AssignClassPupil::where('class_id', $request->class_id)->pluck('pupil_id')->toArray();
        $pupilUsers = User::whereIn('id', $pupils)->get();

        $message = "A new quiz titled '{$quiz->title}' has been added to your class.";
        $this->sendSmsToPupils($pupilUsers, $message);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Quiz created successfully']);
        } else {
            return back()->with('success', 'Quiz created successfully');
        }
    }

    public function show($id)
    {
        $quiz = Quiz::with('questions.choices')->findOrFail($id);

        if (request()->expectsJson()) {
            return response()->json($quiz);
        } else {
            $questions = $quiz->questions;
            return view('quiz.show_quiz', compact('quiz', 'questions'));
        }
    }

    public function submit($quizId, Request $request)
    {
        $quiz = Quiz::findOrFail($quizId);
        $questions = $quiz->questions;

        $existingAttempt = QuizAttempt::where('quiz_id', $quiz->id)->where('user_id', Auth::user()->id)->first();

        if ($existingAttempt) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You have already attempted this quiz.'], 403);
            } else {
                return redirect()->route('student_dashboard')->with('error', 'You have already attempted this quiz.');
            }
        }

        $score = 0;

        foreach ($questions as $question) {
            $correctChoices = $question->choices()->where('is_correct', 1)->pluck('id')->toArray();
            $selectedChoices = (array) $request->input("answers.{$question->id}", []);

            if (count($correctChoices) == count($selectedChoices) && empty(array_diff($correctChoices, $selectedChoices))) {
                $score++;
            }
        }

        $quizAttempt = QuizAttempt::create([
            'user_id' => auth()->user()->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
        ]);

        $user = Auth::user();
        $user->points += $score;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Quiz submitted successfully']);
        } else {
            return redirect()->back()->with('success', 'Quiz submitted successfully');
        }
    }

    public function delete($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        DB::beginTransaction();
        try {
            $quiz->questions()->delete();
            $quiz->delete();
            DB::commit();

            if (request()->expectsJson()) {
                return response()->json(['message' => 'Quiz deleted successfully']);
            } else {
                return redirect()->back()->with('success', 'Quiz deleted successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to delete quiz'], 500);
            } else {
                return redirect()->back()->with('error', 'Failed to delete quiz');
            }
        }
    }

    private function sendSmsToPupils($pupils, $message)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

        foreach ($pupils as $pupil) {
            if (!empty($pupil->phone)) {
                $formattedNumber = '+63' . substr($pupil->phone, 1);
                try {
                    $twilio->messages->create($formattedNumber, [
                        'from' => env('TWILIO_PHONE'),
                        'body' => $message
                    ]);
                } catch (\Exception $e) {
                    \Log::error('SMS Sending Error to pupil ' . $pupil->id . ': ' . $e->getMessage());
                }
            }
        }
    }
}
