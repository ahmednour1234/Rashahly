<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhyWorkWithUs;
use Illuminate\Support\Facades\Validator;

class WhyWorkWithUsController extends Controller
{
    public function index()
    {
        $whyWorkWithUsList = WhyWorkWithUs::all();
        return response()->json(['why_work_with_us' => $whyWorkWithUsList]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:jobs,id',
            'data' => 'required|json',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $whyWorkWithUs = WhyWorkWithUs::create([
            'company_id' => $request->company_id,
            'data' => json_decode($request->data, true), // Convert JSON string to array
        ]);

        return response()->json(['message' => 'Why work with us data created successfully', 'why_work_with_us' => $whyWorkWithUs]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|json',
            // Add validation rules for other fields as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $whyWorkWithUs = WhyWorkWithUs::findOrFail($id);
        $whyWorkWithUs->update([
            'data' => json_decode($request->data, true), // Convert JSON string to array
        ]);

        return response()->json(['message' => 'Why work with us data updated successfully', 'why_work_with_us' => $whyWorkWithUs]);
    }

    public function destroy($id)
    {
        $whyWorkWithUs = WhyWorkWithUs::findOrFail($id);
        $whyWorkWithUs->delete();

        return response()->json(['message' => 'Why work with us data deleted successfully']);
    }
}
