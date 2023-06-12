<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\SubTopicData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TSubTopicController extends Controller
{
    public function index($topicCode)
    {
        $subTopicData = SubTopicData::where('topic_code', $topicCode)->get();
        return response()->json($subTopicData);
    }

    public function show($id)
    {
        $subTopic = SubTopicData::findOrFail($id);

        $error = ResponseFormatter::error([
            'message' => 'something went wrong',
        ], 'Topic data not found', 500);
        if (is_null($subTopic)) {
            return ResponseFormatter::error([
                'message' => $error,
            ]);
        }
        return response()->json([
            'message' => 'Show Sub Topic Data  Successful',
            'data' => $subTopic,
        ], 200);
    }

    public function store(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //     'code_subtopic' => 'required|string',
        //     'indikator_kinerja_utama' => 'required|string',
        //     'formula' => 'required|string',      
        //     'topic_code' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'Validation',
        //         'error' => $validator->errors(),
        //     ], 422);
        // }
        $Topic = $request->input('topic_code');
        $SubTopic = $request->input('code_subtopic');
        $subtopic = new SubTopicData();

        $subtopic->indikator_kinerja_utama = $request->indikator_kinerja_utama;
        $subtopic->formula = $request->formula;

        $customSubTopicCode = $Topic . "." . $SubTopic;
        $subtopic->topic_code = $request->topic_code;
        $subtopic->code_subtopic = $customSubTopicCode;

        $subtopic->save();
        return response()->json([
            'message' => 'SubTopic Data Created',
            'data' => $subtopic,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $subTopic = SubTopicData::find($id);
        if (is_null($subTopic)) {
            return ResponseFormatter::error([
                'message' => 'SubTopic data is null',
            ], `something went error`, 422);
        } else {
            $validator = Validator::make($request->all(), [
                'indikator_kinerja_utama' => 'required|string',
                'formula' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation',
                    'error' => $validator->errors(),
                ], 422);
            }

            $SubTopic = SubTopicData::findOrFail($id);

            $SubTopic->update([
                'indikator_kinerja_utama' => $request->indikator_kinerja_utama,
                'formula' => $request->formula,
            ]);

            $SubTopic = SubTopicData::where('code_topic', '=', $SubTopic->code_subtopic)->get();

            return response()->json([
                'message' => 'Update Topic Data Successful',
                'data' => $SubTopic,
            ], 200);
        }
    }

    public function delete($id)
    {
        try {
            $subtopic = SubTopicData::find($id);
            $subtopic->delete();
            return ResponseFormatter::success([
                'message' => 'SubTopic data deleted successful',
            ], 'Topic data deleted succesfull', 500);
        } catch (QueryException $error) {
            return ResponseFormatter::error([
                'message' => 'something went wrong',
                'error' => $error,
            ], 'Topic Data not deleted', 500);
        }
    }
}
