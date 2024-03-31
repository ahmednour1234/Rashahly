<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCV;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserCVController extends Controller
{
    // Action to show all user CVs
    public function index($job_id)
    {
        // Get all user CVs for the specified job
        $userCVs = UserCV::where('job_id', $job_id)->get();

        return response()->json($userCVs);
    }

    // Action to store a newly created user CV in the database
    public function store(Request $request)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:jobs,id',
            'pdf' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Fetch the authenticated user's ID
        $user_id = Auth::id();

        // Create the user CV with the authenticated user's ID
        $userCV = UserCV::create([
            'user_id' => $user_id,
            'job_id' => $request->job_id,
            'pdf' => $request->pdf,
        ]);

        return response()->json($userCV, 201);
    }

    // Action to show a specific user CV
    public function show(UserCV $userCV)
    {
        return response()->json($userCV);
    }

    // Action to update a user CV in the database
    public function update(Request $request, UserCV $userCV)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:jobs,id',
            'pdf' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the user CV
        $userCV->update($request->all());

        return response()->json($userCV, 200);
    }

    // Action to delete a user CV from the database
    public function destroy(UserCV $userCV)
    {
        $userCV->delete();

        return response()->json(['message' => 'User CV deleted successfully'], 200);
    }
}
