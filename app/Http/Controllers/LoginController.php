<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; // Import the Auth facade for authentication
use Hash; // Import the Hash facade for password hashing

class LoginController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        try {
            // Validate the incoming login request data
            $validatedData = $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);

            // Attempt to authenticate the user with provided credentials
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication successful, generate and return an access token
                $user = Auth::user();
                $success['token'] =  $user->createToken('Token')->accessToken;
                $success['name'] =  $user;
                $message = 'Logged In';
                return $this->success($message, $success, 200);
            } else {
                // Authentication failed, return an unauthorized error
                $message = 'Unauthorized';
                return $this->error($message, 400);
            }
        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return $this->error($e->getMessage(), 400);
        }
    }
}
