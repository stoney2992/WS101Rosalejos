<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\User;
use Twilio\Rest\Client;
use App\Models\ClaimedReward;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::all(); // Fetch all rewards
        $userPoints = Auth::user()->points;

        if (request()->expectsJson()) {
            return response()->json(compact('rewards', 'userPoints'));
        } else {
            return view('rewards.index', compact('rewards', 'userPoints'));
        }
    }


//Crud Rewards
    public function reward()
{
    $rewards = Reward::all(); // Fetch all rewards from the database
    return view('rewards.reward', compact('rewards')); // Pass the rewards to the view
}

    public function create()
{
    return view('rewards.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'points_required' => 'required|numeric'
    ]);

    Reward::create($request->all());
    return redirect()->route('rewards.reward')->with('success', 'Reward created successfully.');
}


public function edit(Reward $reward)
{
    return view('rewards.edit', compact('reward')); // Ensure this view exists
}

public function update(Request $request, Reward $reward)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'points_required' => 'required|numeric'
    ]);

    $reward->update($request->all());
    return redirect()->route('rewards.reward')->with('success', 'Reward updated successfully.');
}

public function destroy(Reward $reward)
{
    $reward->delete();
    return redirect()->route('rewards.reward')->with('success', 'Reward deleted successfully.');
}
// Crud Rewards


public function claim(Request $request, $rewardId)
    {
        $reward = Reward::findOrFail($rewardId);
        $pupil = Auth::user();

        if ($pupil->points >= $reward->points_required) {
            $pupil->points -= $reward->points_required;
            $pupil->save();

            ClaimedReward::create([
                'user_id' => $pupil->id,
                'reward_id' => $reward->id 
            ]);

            // Fetch all teachers
            $teachers = User::where('roles', 'teacher')->get();

            // Send SMS to all teachers
            $this->sendSmsNotification($teachers, "A pupil has claimed a reward: {$reward->name}");

            $response = ['success' => true, 'message' => 'Reward claimed successfully!'];
        } else {
            $response = ['success' => false, 'message' => 'Not enough points to claim this reward.'];
        }

        if (request()->expectsJson()) {
            return response()->json($response);
        } else {
            return back()->with($response['success'] ? 'success' : 'error', $response['message']);
        }
    }

    private function sendSmsNotification($recipients, $message)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

        foreach ($recipients as $recipient) {
            // Format to E.164 if needed
            $formattedNumber = '+63' . substr($recipient->phone, 1);
            
            try {
                $twilio->messages->create($formattedNumber, [
                    'from' => env('TWILIO_PHONE'),
                    'body' => $message
                ]);
            } catch (\Exception $e) {
                \Log::error('SMS Sending Error: ' . $e->getMessage());
            }
        }
    }

    public function claimedRewards()
    {
        $user = Auth::user();
        $claimedRewards = ClaimedReward::with('reward', 'user')->get();

        if (request()->expectsJson()) {
            return response()->json($claimedRewards);
        } else {
            return view('rewards.claimed', compact('claimedRewards'));
        }
    }






}

