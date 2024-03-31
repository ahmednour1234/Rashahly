<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Import Validator facade
use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json(['companies' => $companies]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'site' => 'nullable|url',
            'country' => 'nullable|string',
            'founded_at' => 'nullable|date',
            'number_of_employees' => 'nullable|integer',
            'description' => 'nullable|string',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $company = new Company($request->all());
        $company->user_id = Auth::id(); // Set user_id from authenticated user
        $company->save();

        return response()->json(['message' => 'Company created successfully', 'company' => $company]);
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json(['company' => $company]);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'site' => 'nullable|url',
            'country' => 'nullable|string',
            'founded_at' => 'nullable|date',
            'number_of_employees' => 'nullable|integer',
            'description' => 'nullable|string',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Check if the authenticated user owns the company
        if ($company->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $company->update($request->all());
        return response()->json(['message' => 'Company updated successfully', 'company' => $company]);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);

        // Check if the authenticated user owns the company
        if ($company->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
