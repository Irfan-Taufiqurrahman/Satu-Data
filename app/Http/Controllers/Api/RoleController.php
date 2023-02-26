<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $response = [
            'message' => 'Data list role berhasil di ambil',
            'roles' => $roles,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'error' => $validator->errors(),
            ], 422);
        }
        $current_date_time = Carbon::now();
        $role = Role::create([
            'name' => $request->name,
            "created_at" => $current_date_time,
            "updated_at" => $current_date_time,
        ]);

        return response()->json([
            'message' => 'Registration Successfull',
            'data' => $role,
        ], 200);
    }
}
