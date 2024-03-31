<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReviewCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewCompanyController extends Controller
{
    // Action to show all reviews for a specific company
    public function index($company_id)
    {
        // Get all reviews for the specified company
        $reviews = ReviewCompany::where('company_id', $company_id)->get();

        // Count the total number of reviews
        $totalReviews = $reviews->count();

        // Count the number of reviews with a rating of 100%
        $perfectReviews = $reviews->where('rate', 100)->count();

        // Calculate the percentage of perfect reviews
        $percentage = $totalReviews > 0 ? ($perfectReviews / $totalReviews) * 100 : 0;

        // Return all reviews and the percentage as JSON response
        return response()->json([
            'reviews' => $reviews,
            'percentage' => $percentage
        ]);
    }

    // Action to store a newly created review in the database
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'feedback' => 'required',
            'rate' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Retrieve the authenticated user's ID
        $user_id = Auth::id();

        // Create the review with the authenticated user's ID
        $review = ReviewCompany::create([
            'user_id' => $user_id,
            'company_id' => $request->company_id,
            'feedback' => $request->feedback,
            'rate' => $request->rate,
        ]);

        return response()->json($review, 201);
    }

    // Action to show a specific review
    public function show(ReviewCompany $review)
    {
        return response()->json($review);
    }

    // Action to show a form to edit a review
    public function edit(ReviewCompany $review)
    {
        return response()->json($review);
    }

    // Action to update a review in the database
    public function update(Request $request, ReviewCompany $review)
    {
        $validator = Validator::make($request->all(), [
            'feedback' => 'required',
            'rate' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $review->update($request->all());

        return response()->json($review, 200);
    }

    // Action to delete a review from the database
    public function destroy(ReviewCompany $review)
    {
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
