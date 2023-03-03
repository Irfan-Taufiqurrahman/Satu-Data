<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    public function index()
    {
        // $data = DB::table('tbl_')
    }

    public function importData(Request $request)
    {
        $this->validate($request, [
            'uploaded_file' => 'required|file|mimes:xls,xlsx'
        ]);

        $file = $request->file('uploaded_file');
        try {
            $spreadsheet    = IOFactory::load($file->getRealPath());
            $sheet          = $spreadsheet->getActiveSheet();
            $row_limit      = $sheet->getHighestDataRow();
            $coloum_limit   = $sheet->getHighestColumn();
            $row_range      = range(1000, $row_limit);
            $coloum_range   = range('F', $coloum_limit);
            $startCount     = 2;

            $data = array();
        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'There was a problem uploading the data Excel!',
                'error' => $e,
            ], 'Error Uploading data Excel.');
        }
        return back()->withSuccess('Great! Data has been succesfully uploaded.');
    }
}
