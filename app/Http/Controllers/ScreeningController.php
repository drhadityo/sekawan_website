<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\SatelliteHealthFacility;
use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Regency;
use Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

class ScreeningController extends Controller
{

    public function store(Request $request)
    {
        try {
            // Validasi input dari request
            $validated = $request->validate([
                'agreement' => 'required|boolean',

                // Identitas Diri
                'full_name' => 'required|string',
                'nik' => 'required|string',
                'contact' => 'required|string',
                'gender' => 'required|string',
                'age' => 'required|numeric|min:0',
                'address' => 'required|string',
                'district' => 'required|string',
                'screening_date' => 'required|date',

                // Screening Awal
                'cough' => 'required|boolean',
                'tb_diagnosed' => 'required|in:a,b,c',
                'home_contact' => 'required|boolean',
                'close_contact' => 'required|boolean',

                // Gejala Lain
                'weight_loss' => 'required|boolean',
                'fever' => 'required|boolean',
                'breath' => 'required|boolean',
                'smoking' => 'required|boolean',
                'sluggish' => 'required|boolean',
                'sweat' => 'required|boolean',

                // Faktor Risiko
                'ever_treatment' => 'required|boolean',
                'elderly' => 'required|boolean',
                'pregnant' => 'required|boolean',
                'diabetes' => 'required|boolean',

                // Kontak
                'contact1_name' => 'required|string',
                'contact1_number' => 'required|string',
                'contact2_name' => 'required|string',
                'contact2_number' => 'required|string',
                'contact3_name' => 'required|string',
                'contact3_number' => 'required|string'
            ]);

            // Hitung hasil screening
            $gejala = ['breath', 'fever', 'weight_loss', 'smoking', 'sluggish', 'sweat'];
            $resiko = ['pregnant', 'elderly', 'diabetes', 'ever_treatment'];

            // Logika untuk menentukan apakah positif atau tidak
            $has_cough = $validated['cough'];
            $has_gejala = collect($gejala)->filter(function ($item) use ($validated) {
                return $validated[$item];
            })->count() >= 1;

            $has_resiko = collect($resiko)->filter(function ($item) use ($validated) {
                return $validated[$item];
            })->count() >= 1;

            if ($has_cough || $has_gejala || $has_resiko) {
                $validated['is_positive'] = true;
            } else {
                $validated['is_positive'] = false;
            }

            // Simpan data ke dalam database
            $screening = Screening::create($validated);

            // Menyimpan data screening ke session
            session()->put('screening', $validated);
            
            return redirect()->route('screening.result')->with('success', 'Formulir berhasil disimpan!');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function result()
    {
        $screening = session()->get('screening');
        if ($screening) {
            // $district = District::where('name', $screening['district'])->first();
            // $faskes = $district->satelliteHealthFacility;

            $district = District::where('name', $screening['district'])->first();
            $faskes = $district->satelliteHealthFacility->pluck('url_map', 'name');

            // Ambil nilai variabel dari array $screening
            $full_name = $screening['full_name'];
            $nik = $screening['nik'];
            $gender = $screening['gender'];
            $age = $screening['age'];
            $address = $screening['address'];
            $screening_date = $screening['screening_date'];
            $cough = $screening['cough'];
            $tb_diagnosed = $screening['tb_diagnosed'];
            $home_contact = $screening['home_contact'];
            $close_contact = $screening['close_contact'];
            $weight_loss = $screening['weight_loss'];
            $fever = $screening['fever'];
            $breath = $screening['breath'];
            $smoking = $screening['smoking'];
            $sluggish = $screening['sluggish'];
            $sweat = $screening['sweat'];
            $ever_treatment = $screening['ever_treatment'];
            $elderly = $screening['elderly'];
            $pregnant = $screening['pregnant'];
            $diabetes = $screening['diabetes']; 

            return view('web.screening-result', compact(
                'screening',
                'district',
                'faskes',  
                'full_name',
                'nik',
                'gender',
                'age',
                'address',
                'screening_date',
                'cough',
                'tb_diagnosed',
                'home_contact',
                'close_contact',
                'weight_loss',
                'fever',
                'breath',
                'smoking',
                'sluggish',
                'sweat',
                'ever_treatment',
                'pregnant',
                'elderly',
                'diabetes',
                
            ));
        }
        return redirect()->route('screening');
    }

    public function downloadSuratRekomendasi(Request $request)
    {
        $screening = session()->get('screening');
        $selectedFaskes = $request->input('selectedFaskes');

        if ($screening) {
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);

            $pdf = new Dompdf($options);

            $html = view('web.suratrekomendasi', ['screening' => $screening, 'selectedFaskes' => $selectedFaskes])->render();

            $pdf->loadHtml($html);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();

            return $pdf->stream('Surat Rekomendasi TBC.pdf');
        } else {
            return redirect()->route('screening')->with('error', 'Data screening tidak tersedia.');
        }
    }

    public function index()
    {
        
        $screenings = Screening::all();
        $title = "Daftar Skrining";
        return view('admin.screening.index', compact('screenings', 'title'));
    }

    public function destroy($id)
    {
        try {
            $screening = Screening::findOrFail($id);
            $screening->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data'], 500);
        }
    }

    public function show($id)
    {
        $screening = Screening::findOrFail($id); 

        return view('admin.screening.show', compact('screening'));
    }

}
