<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ResponseFormatter;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //start of function register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:100',
            'confirm_password' => 'required|same:password',
            // 'confirmed' => false,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => 2, // Assign role_id to 2
            'password' => FacadesHash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Registration successful',
            'data' => $user,
        ], 200);
    }
    //end of function register

    //Start of function of login
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required'],
                'password' => ['required'],
                // 'confirmed' => true,
            ]);

            $user = User::where('email', $request->email)->first();
            if (!FacadesHash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }
            if (!$user->confirmed) {
                throw new \Exception('Your account has not been confirmed yet');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                "message" => "Successfully Logged in",
                "token" => $tokenResult,
                // 'access_token' => $tokenResult,
                // 'token_type' => 'Bearer',
                // 'user' => $user
            ], 'Authenticated');
        } catch (QueryException $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }
    //End of function of login

    public function updateProfile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:80',
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user = User::where('email', '=', $user->email)->get();

        return response()->json([
            'message' => 'Create Main Data Successful',
            'data' => $user,
        ], 200);
        // return redirect()->route('');
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => auth()->user()
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User successfull logout',
        ], 200);
    }
}
