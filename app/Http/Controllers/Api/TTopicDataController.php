<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\MainData;
use App\Models\ThematicData;
use App\Models\TopicData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class TTopicDataController extends Controller
{
    public function index(Request $request, $thematicCode)
    {
        $topicData = TopicData::where('thematic_code', $thematicCode)->get();
        return response()->json($topicData);
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
            'kinerja_utama' => 'required|string',
            'sumber_data' => 'required|string',
            'penanggungjawab' => 'required|string',
            'thematic_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation',
                'error' => $validator->errors(),
            ], 422);
        }

        $Thematic = $request->input('thematic_code');
        $Topic = $request->input('code_topic');
        $topic = new TopicData();

        $topic->kinerja_utama = $request->kinerja_utama;
        $topic->sumber_data = $request->sumber_data;
        $topic->penanggungjawab = $request->penanggungjawab;

        $customTopicCode = $Thematic . "." . $Topic;
        $topic->thematic_code = $request->thematic_code;
        $topic->code_topic = $customTopicCode;

        $topic->save();
        return response()->json([
            'message' => 'Topic Data Created',
            'data' => $topic,
        ], 201);
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
                'kinerja_utama' => 'required|string',
                'sumber_data' => 'required|string',
                'penanggungjawab' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation',
                    'error' => $validator->errors(),
                ], 422);
            }

            $topic = TopicData::findOrFail($id);

            $topic->update([
                'kinerja_utama' => $request->kinerja_utama,
                'sumber_data' => $request->sumber_data,
                'penanggungjawab' => $request->penanggungjawab,
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
