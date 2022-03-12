<?php

namespace App\Http\Controllers;

use App\Imports\MeccImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FileController extends Controller
{
    public function index()
    {
        $meccFiles = Storage::files('public/mecc');
        $meccFiles = array_map(function ($file) {
            return str_replace('public/', 'storage/', $file);
        }, $meccFiles);

        return view('dashboard-admin', ['meccFiles' => $meccFiles]);
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
}
