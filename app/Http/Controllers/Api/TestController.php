<?php

namespace App\Http\Controllers\Api;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TestResource;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $lastNumber = Test::latest()->value('bilangan'); // Mengambil bilangan terakhir dari tabel Test
        $kuadrat = $lastNumber * $lastNumber; // Mengkuadratkan bilangan terakhir

        return response()->json(['kuadrat_terakhir' => $kuadrat]);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'bilangan' => 'required|numeric', // Pastikan input adalah angka
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Hitung kuadrat bilangan
        $bilangan = $request->bilangan;
        $kuadrat = sqrt($bilangan);

        // Simpan bilangan dan hasil kuadrat ke dalam database
        $test = Test::create([
            'bilangan' => $bilangan,
        ]);

        // Mengembalikan respons JSON yang berisi bilangan terakhir dan hasil kuadratnya
        return response()->json([
            'bilangan_terakhir' => $bilangan,
            'hasil_kuadrat' => $kuadrat,
        ], 200);
    }

}
