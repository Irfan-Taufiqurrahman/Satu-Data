<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Dataset;
use App\Models\value;
use App\Models\Variable;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ExcelController extends Controller
{
    public function indexList(Request $request)
    {
        // $lastInsertId = $Dataset->datasetId;
        // $id = Dataset::where('datasetId', $lastInsertId)->first();
        //     $id = $id->datasetId;

        // $var_id = Variable::where(['id_dataset', $id]);
    }

    public function import(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'name_excel' => 'required|file|mimes:xls,xlsx',
                'description' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation',
                    'data' => $validator->errors(),
                ], 422);
            }

            $Dataset = Dataset::create([
                'title' => $request->title,
                'name_excel' => $request->name_excel->getClientOriginalName(),
                'description' => $request->description,
            ]);
            $lastInsertId = $Dataset->datasetId;
            //first()fungsi nya untuk return 1 data saja, kalau get() maka fungsi $id->datasetId akan useless karena akan meng get data secara keseluruhan
            $id = Dataset::where('datasetId', $lastInsertId)->first();
            $id = $id->datasetId;

            $filename = $request->file('name_excel')->hashName();

            Storage::disk('public')->put('excelRepo', $request->file('name_excel'));

            $path = storage_path('app/public/excelRepo/' . $filename);

            $reader = new Xlsx();
            $spreadsheet = $reader->load($path);

            // $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $sheet          = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $dataResult     = $sheet;
            $tempVar = array();
            foreach ($dataResult[1] as $key => $Value) {
                $var = new Variable();
                $var->setDataset($id);
                $var->setName($Value);
                $var->save();
                $tempVar[] = $var->varId;
            }

            unset($dataResult[1]);

            $row_id = 0;
            $count = 0;
            foreach ($dataResult as $detail) {
                $detail = array_values($detail);
                foreach ($detail as $key => $Value) {
                    $data = new value();
                    $data->setDataset($id);
                    $data->setVar($tempVar[$key]);
                    $data->setContent($Value);
                    $data->setRowId($row_id);
                    // return $row_id;
                    $data->save();
                    // return $data;
                    $count++;
                }
                $row_id++;
            }
            DB::commit();
            return response()->json([
                'message' => 'Import data excel successfull',
                'data' => $data,
            ], 200);

            // $data = array();
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => 'There was a problem uploading the data Excel!',
                'error' => $e->getMessage(),
            ], 'Error Uploading data Excel.');
        }
        // return response()->json([
        //     'message' => 'Create Dataset Successfull',
        //     'data' => $Dataset,
        // ], 200);
    }
}
