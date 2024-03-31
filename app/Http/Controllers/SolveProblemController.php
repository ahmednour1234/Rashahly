<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SolveProblem;

class SolveProblemController extends Controller
{
    public function store(Request $request)
    {
        // Retrieve the authenticated user's ID
        $user_id = Auth::id();

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'file' => 'required|string',
            'pdf' => 'required|string',
            'problem_id' => 'required|exists:problems,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create the SolveProblem instance with the user_id
        $solveProblem = SolveProblem::create([
            'user_id' => $user_id,
            'file' => $request->file,
            'pdf' => $request->pdf,
            'problem_id' => $request->problem_id,
        ]);

        return response()->json($solveProblem, 201);
    }

    public function show($problem_id)
    {
        // Retrieve all solves for the specified problem
        $solves = SolveProblem::where('problem_id', $problem_id)->get();

        return response()->json($solves);
    }

    public function update(Request $request, SolveProblem $solveProblem)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'file' => 'required|string',
            'pdf' => 'required|string',
            'problem_id' => 'required|exists:problems,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the SolveProblem instance
        $solveProblem->update([
            'file' => $request->file,
            'pdf' => $request->pdf,
            'problem_id' => $request->problem_id,
        ]);

        return response()->json($solveProblem, 200);
    }

    public function destroy(SolveProblem $solveProblem)
    {
        $solveProblem->delete();

        return response()->json(['message' => 'Solve deleted successfully'], 200);
    }
}
