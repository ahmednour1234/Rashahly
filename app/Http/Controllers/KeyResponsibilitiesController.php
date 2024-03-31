<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeyResponsibilities;
use Illuminate\Support\Facades\Validator;

class KeyResponsibilitiesController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the job_id from the request headers
        $jobId = $request->header('job_id');

        // Validate the job_id parameter
        if (!$jobId) {
            return response()->json(['error' => 'job_id header is required'], 400);
        }

        // Query key responsibilities based on the provided job_id
        $keyResponsibilities = KeyResponsibilities::where('job_id', $jobId)->get();

        return response()->json(['key_responsibilities' => $keyResponsibilities]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|json',
            'name' => 'required|string|max:255',
            'job_id' => 'required|exists:jobs,id',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $keyResponsibilities = KeyResponsibilities::create($request->all());

        return response()->json(['message' => 'Key responsibilities created successfully', 'key_responsibilities' => $keyResponsibilities]);
    }

    public function update(Request $request, $id)
    {
        $keyResponsibilities = KeyResponsibilities::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'data' => 'required|json',
            'name' => 'required|string|max:255',
            'job_id' => 'required|exists:jobs,id',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $keyResponsibilities->update($request->all());

        return response()->json(['message' => 'Key responsibilities updated successfully', 'key_responsibilities' => $keyResponsibilities]);
    }

    public function destroy($id)
    {
        $keyResponsibilities = KeyResponsibilities::findOrFail($id);
        $keyResponsibilities->delete();

        return response()->json(['message' => 'Key responsibilities deleted successfully']);
    }
}
