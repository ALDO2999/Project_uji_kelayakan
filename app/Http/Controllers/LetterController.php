<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterType;
use App\Models\Result;
use App\Models\User;
// use App\Models\LetterType;
use Illuminate\Http\Request;

class LetterController extends Controller
{



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data surat dari database
        $letters = Letter::orderBy('letter_type_id', 'ASC')->simplePaginate(5);
        $letterTypes = LetterType::get(); // Mengasumsikan bahwa LetterType adalah model untuk tabel letter_types
        $results = Result::get();

        // Inisialisasi array untuk menyimpan jumlah surat untuk setiap letter_type_id
        $letterCounts = [];

        foreach ($letters as $letter) {
            // Parse kolom recipients (asumsi dalam bentuk array)
            $recipientId = json_decode($letter->recipients, true);

            $letterTypeId = LetterType::find($letter->letter_type_id);

            // Tambahkan data pengguna ke dalam model surat
            $letter->letterTypeId = $letterTypeId;

            // Ambil data pengguna berdasarkan ID
            $recipients = User::whereIn('id', $recipientId)->get();

            // Tambahkan data pengguna ke dalam model surat
            $letter->recipientsData = $recipients;

            // Ambil data pengguna notulis
            $notulisUser = User::find($letter->notulis);

            // Tambahkan data pengguna notulis ke dalam model surat
            $letter->notulisUserData = $notulisUser;

            // Hitung jumlah surat untuk setiap letter_type_id
            if (!isset($letterCounts[$letter->letter_type_id])) {
                $letterCounts[$letter->letter_type_id] = 1;
            } else {
                $letterCounts[$letter->letter_type_id]++;
            }
        }
        return view('letter.index', compact('letters', 'results', 'letterTypes', 'letterCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $klasifikasi = LetterType::get();
        $user = User::where('role', 'guru')->get();


        return view('letter.create', compact('klasifikasi', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_type_id' => 'required',
            'letter_perihal' => 'required',
            'recipients' => 'required|array',
            'content' => 'required',
            'attachment' => 'nullable',
            'notulis' => 'required',
        ]);

        // dd($request->all());
        // $letter_type_ids = $request->input('letter_type_id', []);
        // $recipients = json_encode($request->recipients);

        Letter::create([
            'letter_type_id' => $request->letter_type_id,
            'letter_perihal' => $request->letter_perihal,
            'recipients' => json_encode($request->recipients), // Simpan sebagai JSON
            'content' => $request->content,
            'attachment' => $request->attachment,
            'notulis' => $request->notulis,
        ]);

        return redirect()->route('letter.index')->with('success', 'Berhasil Menambahkan Data!');
    }







    public function execute(Request $request)
    {
        // Mendapatkan ID dari item yang dicentang

        // Lakukan sesuatu dengan item yang dicentang
        // Misalnya, Anda dapat mengeksekusi operasi tertentu pada item yang dicentang

        // return redirect()->route('letter.index')->with('success', 'Items executed successfully!');
    }





    /**
     * Display the specified resource.
     */
    public function show(Letter $letter, $id)
    {
        $letterType = LetterType::get();
        $letter = Letter::find($id);
        $user = User::where('role', 'guru')->get();

        // Inisialisasi array untuk menyimpan penerima berdasarkan ID surat
        $recipientsArray = [];

    
        // Memisahkan penerima pada setiap surat
        $recipientsArray[$letter->id] = json_decode($letter->recipients, true);
        

        return view('letter.result', compact('user', 'letter', 'letterType', 'recipientsArray'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $letterType = LetterType::get();
        $letters = Letter::find($id);
        $user = User::where('role', 'guru')->get();

        return view('letter.edit', compact('user', 'letters', 'letterType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, letter $letter, $id)
    {
        $request->validate([
            'letter_type_id' => 'required',
            'letter_perihal' => 'required',
            'recipients' => 'required|array',
            'content' => 'required',
            'notulis' => 'required'
        ]);

        letter::where('id', $id)->update([
            'letter_type_id' => $request->letter_type_id,
            'letter_perihal' => $request->letter_perihal,
            'recipients' => json_encode($request->recipients), // Simpan sebagai JSON
            'content' => $request->content,
            'attachment' => $request->attachment,
            'notulis' => $request->notulis
        ]);

        return redirect()->route('letter.index')->with('success', 'Berhasil Mengubah Data Surat!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Letter $letter)
    {
        //
    }
}
