<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator facade
use App\Models\Experience;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');

        // Query experiences based on the provided name
        $experiences = Experience::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', "%$name%");
        })->get();

        return response()->json(['experiences' => $experiences]);
    }

    public function store(Request $request)
    {
        // Custom validation using Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $experience = Experience::create($request->all());

        return response()->json(['message' => 'Experience created successfully', 'experience' => $experience]);
    }

    public function show($id)
    {
        $experience = Experience::findOrFail($id);
        return response()->json(['experience' => $experience]);
    }

    public function update(Request $request, $id)
    {
        // Custom validation using Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $experience = Experience::findOrFail($id);
        $experience->update($request->all());

        return response()->json(['message' => 'Experience updated successfully', 'experience' => $experience]);
    }

    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json(['message' => 'Experience deleted successfully']);
    }
}
