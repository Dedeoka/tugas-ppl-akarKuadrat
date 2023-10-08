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
        $tests = Test::all();
        return response()->json($tests, 200);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'bilangan' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
                function ($attribute, $value, $fail) {
                    if ($value < 0) {
                        $fail('Tidak dapat menginputkan bilangan negatif pada form.');
                    }
                },
            ],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Hitung kuadrat bilangan
        $bilangan = $request->bilangan;
        $startTime = microtime(true);

        // Inisialisasi $kuadrat_manual
        $kuadrat_manual = 0;

        // Perhitungan manual akar kuadrat
        if ($bilangan != 0) {
            $x = $bilangan / 2;
            for ($i = 0; $i < 1000; $i++) { // Batasi iterasi ke 1000 untuk menghindari perulangan tak terbatas
                $estimate = 0.5 * ($x + $bilangan / $x);
                if (abs($estimate - $x) < 1e-6) {
                    $kuadrat_manual = $estimate;
                    break;
                }
                $x = $estimate;
            }
        }

        // Simpan bilangan, hasil kuadrat, dan waktu eksekusi ke dalam database
        $test = new Test;
        $test->bilangan = $bilangan;
        $test->akar_kuadrat = $kuadrat_manual;
        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000;
        $test->waktu = $executionTime;
        $test->save();

        // Mengembalikan respons JSON yang berisi bilangan terakhir, hasil kuadrat, dan waktu eksekusi
        return response()->json([
            'bilangan_terakhir' => $bilangan,
            'hasil_kuadrat' => $kuadrat_manual,
            'waktu_eksekusi' => $executionTime,
        ], 200);
    }
}
