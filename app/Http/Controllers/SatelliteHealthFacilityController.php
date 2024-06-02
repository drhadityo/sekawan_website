<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatelliteHealthFacility;
use App\Models\District;

class SatelliteHealthFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satellites = SatelliteHealthFacility::all();
        $districts = District::orderBy('name', 'asc')->get(); 
        return view('admin.fasyankes.index', compact('satellites', 'districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fasyankes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:satellite_health_facilities|max:64',
            'district' => 'required|exists:districts,id',
            'url_map' => 'nullable|string|max:1080', 
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Nama sudah digunakan.',
            'name.max' => 'Nama tidak boleh lebih dari 64 karakter.',
            'district.required' => 'Distrik harus dipilih.',
            'district.exists' => 'Distrik yang dipilih tidak valid.',
            'url_map.max' => 'URL peta tidak boleh lebih dari 1080 karakter.', 
        ]);

        $satellite = SatelliteHealthFacility::create([
            'name' => $request->name,
            'district_id' => $request->district,
            'url_map' => $request->url_map,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fasyankes Satelit berhasil ditambahkan.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SatelliteHealthFacility  $facility
     * @return \Illuminate\Http\Response
     */
    public function show(SatelliteHealthFacility $facility)
    {
        $patients = $facility->patientDetails()->get();
        return view('admin.fasyankes.show', compact('facility', 'patients'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SatelliteHealthFacility  $facility
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $satellite = SatelliteHealthFacility::findOrFail($id);
        $districts = District::orderBy('name', 'asc')->get();
        return view('admin.fasyankes.edit', compact('satellite', 'districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SatelliteHealthFacility  $facility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'district_id' => 'required|exists:districts,id',
            'url_map' => 'nullable|string|max:1080',
        ], [
            'district_id.required' => 'Distrik harus dipilih.',
            'district_id.exists' => 'Distrik yang dipilih tidak valid.',
        ]);

        $facility = SatelliteHealthFacility::findOrFail($id);

        $facility->name = $request->name;
        $facility->district_id = $request->district_id;
        $facility->url_map = $request->url_map;
        $facility->save();

        return response()->json(['success' => true, 'message' => 'Data Fasyankes Satelit berhasil diperbarui.']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SatelliteHealthFacility  $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(SatelliteHealthFacility $facility)
    {
        if ($facility->delete()) {
            return response()->json(['success' => true, 'message' => 'Fasyankes Satelit berhasil dihapus.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Fasyankes Satelit.'], 500);
        }
    }

}
