<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Dataset;
use App\Models\value;
use App\Models\Variable;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ExcelController extends Controller
{
    public function indexDataset(Request $request)
    {
        $dataset = Dataset::all();
        $id = $request->input('datasetId');

        if ($id) {
            $dataset = Dataset::find($id);
            if ($dataset) {
                return ResponseFormatter::success([
                    'data' => $dataset,
                    'message' => 'Dataset Berhasil diambil',
                ]);
            } else {
                return ResponseFormatter::error(404, 'Dataset tidak ditemukan');
            }
        }
        return ResponseFormatter::success([
            'data' => $dataset,
            'message' => 'Data Berhasil diambil',
        ]);
    }

    public function indexList($id)
    {
        // $id = null;
        $var_id = Variable::where('id_dataset', $id)->orderBy('var_id', 'asc')->get();
        // $var_id = Variable::where(['id_dataset'], ['varId' => 'ASC'])->get();
        $temp = [];
        foreach ($var_id as $var) {
            $temp[] = $var->getName() . " varchar";
        }
        $column = implode(', ', $temp);

        $query = "
        SELECT * 
        FROM crosstab('SELECT a.row_id, b.var_id, a.content from 
        values a join variables b on a.id_variable = b.var_id WHERE a.id_dataset = $id ORDER BY 1,2 ASC'::text)
        ct(row_id integer, $column) ORDER BY ct.row_id;";

        if (empty($column)) {
            return response()->json([
                'message' => 'No columns found for crosstab',
            ], 400);
        }

        $setResult = DB::select($query);
        // $obj = json_decode(json_encode($setResult));
        // $result = $obj->fetchAll();
        // return ($setResult);

        return response()->json([
            'message' => 'Indexing data excel successfull',
            'data' => $setResult,
        ], 200);
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
                $tempVar[] = $var->var_id;
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

    public function delete($id)
    {
        try {
            $excel = Dataset::find($id);
            $excel->delete();
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
