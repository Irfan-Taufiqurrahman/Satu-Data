<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\MainData;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TMainDataController extends Controller
{
    public function index(Request $request)
    {
        $main = MainData::all();

        $id = $request->input('id');

        if ($id) {
            $main = MainData::find($id);
            if ($main) {
                return ResponseFormatter::success([
                    'data' => $main,
                    'message' => 'Data Main Data Berhasil diambil',
                ]);
            } else {
                return ResponseFormatter::error(404, 'Data Main tidak ditemukan');
            }
        }
        return ResponseFormatter::success([
            'data' => $main,
            'message' => 'Data Berhasil diambil',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_main' => 'required|integer',
            'title_main' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'error' => $validator->errors(),
            ], 422);
        }

        $main = MainData::create([
            'code_main' => $request->code_main,
            'title_main' => $request->title_main,
        ]);

        return response()->json([
            'message' => 'Create Main Data successful',
            'data' => $main,
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code_main' => 'required|integer',
            'title_main' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'error' => $validator->errors(),
            ], 422);
        }

        $main = MainData::findOrFail($id);
        // if ($data) {
        //     return ResponseFormatter::success(200, 'Success', $data);
        // } else {
        //     return ResponseFormatter::error(400, 'Failed');
        // }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code_main' => 'required|integer',
            'title_main' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'error' => $validator->errors(),
            ], 422);
        }

        $main = MainData::findOrFail($id);

        $main->update([
            'code_main' => $request->code_main,
            'title_main' => $request->title_main,
        ]);

        $main = MainData::where('code_main', '=', $main->code_main)->get();

        return response()->json([
            'message' => 'Create Main Data successful',
            'data' => $main,
        ], 200);
    }

    public function delete($id)
    {
        try {
            $main = MainData::find($id);
            $main->delete();
            return ResponseFormatter::success([
                'message' => 'Main Data deleted successful',
            ], 'Main Data deleted successfull', 500);
        } catch (QueryException $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error,
            ], 'Main Data not deleted', 500);
        }
    }
}
