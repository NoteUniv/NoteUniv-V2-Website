<?php

namespace App\Http\Controllers;

use App\Imports\GradesImport;
use App\Imports\MeccImport;
use App\Models\Mecc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class FileController extends Controller
{
    public function index()
    {
        $meccFiles = Storage::files('public/mecc');

        $meccFiles = array_map(function ($file) {
            if (substr(basename($file), 0, 1) === '.') {
                return null;
            }
            return str_replace('public/', 'storage/', $file);
        }, $meccFiles);

        $meccFiles = array_filter($meccFiles);

        $gradeFiles = Storage::files('public/grades');

        $gradeFiles = array_map(function ($file) {
            if (substr(basename($file), 0, 1) === '.') {
                return null;
            }
            return str_replace('public/', 'storage/', $file);
        }, $gradeFiles);

        $gradeFiles = array_filter($gradeFiles);

        return view('dashboard-admin', ['meccFiles' => $meccFiles, 'gradeFiles' => $gradeFiles]);
    }

    public function uploadMecc(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlx,xls,xlsx|max:2048'
        ]);
        $excel = $request->file('file');
        $filename = time() . '_' . $excel->getClientOriginalName();

        $excel->storeAs('public/mecc', $filename);

        Excel::import(new MeccImport, 'storage/mecc/' . $filename);

        return response()->json([
            'success' => $filename
        ]);
    }

    public function uploadGrade(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlx,xls,xlsx|max:2048'
        ]);
        $excel = $request->file('file');
        $filename = time() . '_' . $excel->getClientOriginalName();

        $excel->storeAs('public/grades', $filename);

        Excel::import(new GradesImport, 'storage/grades/' . $filename);

        return response()->json([
            'success' => $filename
        ]);
    }

    public function downloadMeccTemplate()
    {
        $file = storage_path('app/private/mecc_template.xlsx');

        return response()->download($file);
    }

    public function downloadGradesTemplate()
    {
        $file = storage_path('app/private/grades_template.xlsx');
        $reader = new XlsxReader();
        $spreadsheet = $reader->load($file);

        $sheet = $spreadsheet->getSheetByName('Select values');

        $data = $sheet->rangeToArray('B2:N2')[0];
        $alphas = range('B', 'N');

        $allMecc = Mecc::orderBy('promo')->get();

        for ($i = 3; $i <= count($allMecc) + 2; $i++) {
            $mecc = $allMecc[$i - 3];
            $promoCol = $alphas[array_search($mecc->promo, $data)];

            $sheet->setCellValue($promoCol . $i, $mecc->subject_name);
        }

        $hiddenSheet = $spreadsheet->getSheetByName('Select values');
        $hiddenSheet->setSheetState('veryHidden');

        $writer = new XlsxWriter($spreadsheet);
        $writer->save(storage_path('app/public/grades_template.xlsx'));

        return response()->download(public_path('storage/grades_template.xlsx'));
    }
}
