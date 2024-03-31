<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Problem;

class ProblemController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->query('search');

        // Retrieve all problems with related user and company data
        $problems = Problem::with(['user', 'user.company'])
                        ->when($searchQuery, function ($query) use ($searchQuery) {
                            // Filter problems by name if search query is provided
                            return $query->where('name', 'like', '%' . $searchQuery . '%');
                        })
                        ->get();

        return response()->json($problems);
    }

    public function show(Problem $problem)
    {
        // Load related user and company data
        $problem->load(['user', 'user.company']);

        return response()->json($problem);
    }


    public function store(Request $request)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Retrieve the authenticated user's ID
        $user_id = Auth::id();

        // Create the problem with the authenticated user's ID
        $problem = Problem::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user_id,
        ]);

        return response()->json($problem, 201);
    }

    public function update(Request $request, Problem $problem)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the problem
        $problem->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($problem, 200);
    }

    public function destroy(Problem $problem)
    {
        $problem->delete();
        return response()->json(['message' => 'Problem deleted successfully'], 200);
    }
}
