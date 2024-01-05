<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MathGameController extends Controller
{
    public function index(Request $request)
    {
        // Generate the first question
        $question = $this->generateQuestion();

        // Check if the request expects a JSON response
        if ($request->wantsJson()) {
            // Return question as JSON for API
            return response()->json(['question' => $question]);
        } else {
            // Return view for web requests
            return view('math_game.index', compact('question'));
        }
    }

    public function submit(Request $request)
    {
        $user = Auth::user();
        $pointsForCorrectAnswer = 10; // Points for each correct answer

        $userAnswer = $request->input('answer');
        $correctAnswer = $this->evaluateQuestion($request->input('question'));

        $isCorrect = ((int)$userAnswer === $correctAnswer);
        if ($isCorrect) {
            $user->points += $pointsForCorrectAnswer;
            $user->save();
        }

        // Prepare the response
        $response = [
            'success' => $isCorrect,
            'points' => $user->points,
            'newQuestion' => $this->generateQuestion()
        ];

        return response()->json($response);
    }

    private function generateQuestion()
    {
        $operators = ['+', '-', '*', '/'];
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operation = $operators[array_rand($operators)];

        // Ensure no division by zero
        if ($operation === '/' && $num2 === 0) {
            $num2 = 1;
        }

        return "$num1 $operation $num2";
    }

    private function evaluateQuestion($question)
    {
        // Evaluate the arithmetic expression
        return eval("return $question;");
    }
}
