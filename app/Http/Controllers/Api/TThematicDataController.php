<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Models\ThematicData;
// use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class TThematicDataController extends Controller
{
    public function createThematic()
    {
        // $id = Auth::mainData()->id;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_thematic' => 'required|int|max:100',
            'title_thematic' => 'required|string',
            'name_opd' => 'required|string',
            'main_code' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'error' => $validator->errors(),
            ], 422);
        }
        $theamtic = ThematicData::create(
            [
                'code_thematic' => $request->code_thematic,
                'title_thematic' => $request->title_thematic,
                'name_opd' => $request->name_opd,
                'main_code' => $request->main_code,
            ]
        );
        return response()->json([
            'message' => 'Create Main Data Successful',
            'data' => $theamtic,
        ], 200);
    }
}
