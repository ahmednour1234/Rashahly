<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Custom validation using Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Authenticate the user
        Auth::login($user);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }

    public function login(Request $request)
    {
        // Custom validation using Validator
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Attempt to authenticate user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Generate Sanctum token
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout successful']);
    }

    public function update(Request $request)
{
    // Check if user is authenticated
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    // Get the authenticated user
    $user = Auth::user();

    // Custom validation using Validator
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8',
        'image_name' => 'nullable|mimes:jpeg,png,jpg,gif|max:5000', // Validate image upload (max size in KB)
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Update user data
    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }
    $user->save();

    // Handle image upload
    if ($request->hasFile('image_name')) {
        $image = $request->file('image_name');
        $imageName = $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName); // Save image to public directory

        // Store or update user image in the database
        $userImage = $user->image()->firstOrCreate([]); // Assuming there's a one-to-one relationship between users and images
        $userImage->image_name = $imageName;
        $userImage->save();
    }

    return response()->json(['message' => 'User data updated successfully', 'user' => $user]);
}

}
