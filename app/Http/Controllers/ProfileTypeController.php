<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Validator; // Import Validator facade
use App\Models\ProfileType;

class ProfileTypeController extends Controller
{
    public function index()
    {
        $profileTypes = ProfileType::all();
        return response()->json(['profile_types' => $profileTypes]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'bio' => 'nullable',
            'full_name' => 'nullable',
            'profession' => 'nullable',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $profileType = new ProfileType($request->all());
        $profileType->user_id = Auth::id(); // Set user_id from authenticated user
        $profileType->save();

        return response()->json(['message' => 'Profile type created successfully', 'profile_type' => $profileType]);
    }

    public function update(Request $request, $id)
    {
        $profileType = ProfileType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'bio' => 'nullable',
            'full_name' => 'nullable',
            'profession' => 'nullable',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the authenticated user owns the profile type
        if ($profileType->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $profileType->update($request->all());
        return response()->json(['message' => 'Profile type updated successfully', 'profile_type' => $profileType]);
    }

    public function destroy($id)
    {
        $profileType = ProfileType::findOrFail($id);

        // Check if the authenticated user owns the profile type
        if ($profileType->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $profileType->delete();

        return response()->json(['message' => 'Profile type deleted successfully']);
    }
}
