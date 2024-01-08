<?php

namespace App\Http\Controllers;

use App\Exports\LetterExport;
use App\Models\Letter;
use App\Models\LetterType;
use App\Models\User;
use Illuminate\Http\Request;
// use App\Exports\LetterExport;
// use Maatwebsite\Excel\Facades\Excel;
use Excel;

class LetterTypeController extends Controller
{


    
    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required',
        ]);
        
        // dd($request->all());

        LetterType::create([
            'letter_code' => $request->letter_code,
            'name_type' => $request->name_type,

        ]);

        return redirect()->route('klasifikasi.index')->with('success', 'Berhasil Menambahkan Data!');

    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $letterTypes = LetterType::orderBy('letter_code', 'ASC')->simplePaginate(5);
        $letters = Letter::get();

        $letterCounts = [];

        foreach ($letters as $letter) {

            if (!isset($letterCounts[$letter->letter_type_id])) {
                $letterCounts[$letter->letter_type_id] = 1;
            } else {
                $letterCounts[$letter->letter_type_id]++;
            }
        }

        return view('klasifikasi.index', compact('letterTypes', 'letterCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('klasifikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $letterTypes = LetterType::find($id);
        $dataLetter = Letter::where('letter_type_id', $id)->get();

        // Inisialisasi array untuk menyimpan jumlah data letter untuk setiap jenis surat
        $letterCounts = [];

        // Loop melalui setiap jenis surat
        foreach ($dataLetter as $letter) {
            // Parse kolom recipients (asumsi dalam bentuk array)
            $recipientId = json_decode($letter->recipients, true);

            // Ambil data pengguna berdasarkan ID
            $recipients = User::whereIn('id', $recipientId)->get();

            // Tambahkan data pengguna ke dalam model surat
            $letter->recipientsData = $recipients;

            // Hitung jumlah surat untuk setiap letter_type_id
            if (!isset($letterCounts[$letter->letter_type_id])) {
                $letterCounts[$letter->letter_type_id] = 1;
            } else {
                $letterCounts[$letter->letter_type_id]++;
            }
        }

        return view('letter.detail', compact('letterTypes','dataLetter', 'letterCounts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $letterType = LetterType::find($id);
        return view('klasifikasi.edit', compact('letterType'));
        

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'letter_code' => 'required|',
            'name_type' => 'required|',
        ]);


        
        LetterType::where('id', $id)->update([
            'letter_code'=> $request->letter_code,
            'name_type'=>$request->name_type,
        ]);

        return redirect()->route('klasifikasi.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        LetterType::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }






    public function downloadExcel(){
        $letterCounts = [];

        // ... (lakukan perhitungan sesuai kebutuhan)

        $file_name = 'Klasifikasi Surat.xlsx';

        // Buat instance dari LetterExport dan berikan $letterCounts
        $export = new LetterExport($letterCounts);

        return Excel::download($export, $file_name);
    }
}
