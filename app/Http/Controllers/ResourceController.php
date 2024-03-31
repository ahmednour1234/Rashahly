<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::all();
        return response()->json($resources);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'article_id' => 'nullable|exists:articles,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'url' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Validation passed, create the resource
        $resource = Resource::create($validator->validated());
        return response()->json($resource, 201);
    }

    public function show(Resource $resource)
    {
        return response()->json($resource);
    }

    public function update(Request $request, Resource $resource)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'article_id' => 'nullable|exists:articles,id',
            'title' => 'required|string',
            'description' => 'required|string',
            'url' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Validation passed, update the resource
        $resource->update($validator->validated());
        return response()->json($resource, 200);
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(['message' => 'Resource deleted successfully'], 200);
    }
}
