<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Validator;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve the name parameter from the request
        $name = $request->query('name');

        // Query jobs based on the provided name
        $jobs = Job::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', "%$name%");
        })->get();

        return response()->json(['jobs' => $jobs]);
    }
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return response()->json(['job' => $job]);
    }

    public function store(Request $request)
    {
        // Custom validation using Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'job_type' => 'nullable|string',
            'salary' => 'nullable|numeric',
            // Add validation rules for other fields as needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = auth()->user();
        $companyId = $user->company()->first()->id;

        $jobData = $request->all();
        $jobData['company_id'] = $companyId;

        $job = Job::create($jobData);

        return response()->json(['message' => 'Job created successfully', 'job' => $job]);
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        // Custom validation using Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'job_type' => 'nullable|string',
            'salary' => 'nullable|numeric',
            // Add validation rules for other fields as needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $job->update($request->all());

        return response()->json(['message' => 'Job updated successfully', 'job' => $job]);
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return response()->json(['message' => 'Job deleted successfully']);
    }
}
