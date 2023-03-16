<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\TopicData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class TTopicDataController extends Controller
{
    public function index(Request $request)
    {
        $topic = TopicData::all();
        $id = $request->input('id');

        if ($id) {
            $topic = TopicData::find($id);
            if ($topic) {
                return ResponseFormatter::success([
                    'data' => $topic,
                    'message' => 'Data Topic Berhasil diambil',
                ]);
            } else {
                return ResponseFormatter::error(404, 'Data Topic tidak ditemukan');
            }
        }
        return ResponseFormatter::success([
            'data' => $topic,
            'message' => 'Data Berhasil diambil',
        ]);
    }

    public function show(Request $request, $id)
    {
        $topic = Topicdata::findOrFail($id);

        $error = ResponseFormatter::error([
            'message' => 'something went wrong',
        ], 'Topic data not found', 500);
        if (is_null($topic)) {
            return ResponseFormatter::error([
                'message' => $error,
            ]);
        }
        return response()->json([
            'message' => 'Show Topic Data  Successful',
            'data' => $topic,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_topic' => 'required|integer',
            'indicator' => 'required|string',
            'formula' => 'required|string',
            'code_thematic' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'error' => $validator->errors(),
            ], 422);
        }

        $topic = TopicData::create([
            'code_topic' => $request->code_topic,
            'code_thematic' => $request->code_thematic,
            'indicator' => $request->indicator,
            'formula' => $request->formula,
        ]);

        return response()->json([
            'message' => 'Create Topic Data successful',
            'data' => $topic,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $topic = Topicdata::find($id);
        if (is_null($topic)) {
            return ResponseFormatter::error([
                'message' => 'Topic data is null',
            ], `something went error`, 422);
        } else {
            $validator = Validator::make($request->all(), [
                'indicator' => 'required',
                'formula' => 'required',
                'code_thematic' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation',
                    'error' => $validator->errors(),
                ], 422);
            }

            $topic = TopicData::findOrFail($id);

            $topic->update([
                'indicator' => $request->indicator,
                'formula' => $request->formula,
                'code_thematic' => $request->code_thematic,
            ]);

            $topic = TopicData::where('code_topic', '=', $topic->code_topic)->get();

            return response()->json([
                'message' => 'Update Topic Data Successful',
                'data' => $topic,
            ], 200);
        }
    }

    public function delete($id)
    {
        try {
            $topic = TopicData::find($id);
            $topic->delete();
            return ResponseFormatter::success([
                'message' => 'Topic data deleted successful',
            ], 'Topic data deleted succesfull', 500);
        } catch (QueryException $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error,
            ], 'Topic Data not deleted', 500);
        }
    }
}
