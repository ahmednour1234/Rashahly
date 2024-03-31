<?php

// app/Http/Controllers/UserExperienceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExperience;
use Illuminate\Support\Facades\Validator;

class UserExperienceController extends Controller
{
    public function index()
    {
        $userExperiences = UserExperience::all();
        return response()->json(['user_experiences' => $userExperiences]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'experience_id' => 'required|exists:experiences,id',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $userExperience = new UserExperience($request->all());
        $userExperience->user_id = auth()->id(); // Set user_id from authenticated user
        $userExperience->save();

        return response()->json(['message' => 'User experience created successfully', 'user_experience' => $userExperience]);
    }
    public function update(Request $request, $id)
    {
        $userExperience = UserExperience::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'experience_id' => 'required|exists:experiences,id',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the authenticated user owns the user experience
        if ($userExperience->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userExperience->update($request->all());
        return response()->json(['message' => 'User experience updated successfully', 'user_experience' => $userExperience]);
    }
    public function destroy($id)
    {
        $userExperience = UserExperience::findOrFail($id);

        // Check if the authenticated user owns the user experience
        if ($userExperience->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userExperience->delete();

        return response()->json(['message' => 'User experience deleted successfully']);
    }
}
