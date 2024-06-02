<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Education;
use App\Models\EmergencyContact;
use App\Models\Meeting;
use App\Models\PatientDetail;
use App\Models\PatientStatus;
use App\Models\Regency;
use App\Models\Religion;
use App\Models\SatelliteHealthFacility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Facades\LogBatch;
use Spatie\Activitylog\Models\Activity;

use function PHPUnit\Framework\isNull;

class PatientController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regencies = Regency::all();
        $title = 'Data Pasien';
        return view('admin.patient.index', compact('regencies', 'title'));
    }

    public function regency($regency)
    {
        $patients = $regency !== '0' ? PatientDetail::withWhereHas('patient.district.regency', fn ($query) => $query->where('id', $regency))->get() : PatientDetail::all();
        return $patients;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fasyankes = collect(["RS PARU JEMBER", "RSD DR. SOEBANDI JEMBER"]);
        $satellites = SatelliteHealthFacility::all();
        $religions = Religion::all();
        $educations = Education::all();
        $regencies = Regency::withWhereHas('districts', fn ($query) => $query->without('regency'))->get();
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->can('superAdmin');
    
        // Jika user adalah superAdmin, sediakan daftar user
        $users = $isSuperAdmin ? User::all() : collect([$currentUser]);
    
        return view('admin.patient.create', compact('fasyankes', 'religions', 'currentUser', 'regencies', 'educations', 'satellites', 'users', 'isSuperAdmin'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePatientRequest  $request
     * @return \Illuminate\Http\Response 
     */
    public function store(StorePatientRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            LogBatch::startBatch();
            $emergency = EmergencyContact::create($validated['emergency']);
            isset($emergency) ? $patient = Patient::create($validated) : '';
            isset($patient) ? $detail = PatientDetail::create($validated) : '';
            LogBatch::endBatch();
            
            $detail = PatientDetail::find($detail->id);

            if ($request->pertemuan) {
                if (count(($request->pertemuan)) > 0) {
                    $deletedKey = ['status_ro','efek_samping_obat','persepsi_pasien','bantuan_sosial'];
                    $meetings = [];
                    foreach ($request->pertemuan as $item) {
                        $temp = [];
                        foreach ($item as $key => $value) {
                            if (in_array($key,$deletedKey) and $value == '1') {
                                continue;
                            }
                            $temp[$key] = $value;
                        }
                        $temp['patient_id'] = $detail->id;
                        $meetings[] = $temp;
                    }
                    foreach ($meetings as $key => $value) {
                        // Meeting::create($value);
                    }
                }
            }

            DB::commit();
            
            return redirect()->route('admin.patients.show', $detail)->withSuccess("Data berhasil dibuat!");;
        } catch (\Exception $ex) {
            DB::rollBack();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(PatientDetail $patient)
    {
        return view('admin.patient.show', ['patientDetail' => $patient]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientDetail $patient)
    {
        $fasyankes = collect(["RS PARU JEMBER", "RSD DR. SOEBANDI JEMBER"]);
        $satellites = SatelliteHealthFacility::all();
        $statuses = PatientStatus::get();
        $religions = Religion::all();
        $educations = Education::all();
        $regencies = Regency::withWhereHas('districts', fn ($query) => $query->without('regency'))->get();
        $detail = $patient;
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser->can('superAdmin');
    
        // Jika user adalah superAdmin, sediakan daftar user
        $users = $isSuperAdmin ? User::all() : collect([$currentUser]);
    
        return view('admin.patient.edit', compact('detail', 'fasyankes', 'satellites', 'religions', 'regencies', 'currentUser', 'educations', 'statuses', 'users', 'isSuperAdmin'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientRequest  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, PatientDetail $patient)
    {
        $request = $request->validated();
        LogBatch::startBatch();
        $patient->patient->emergency_contact->update($request['emergency']);
        $patient->patient->update($request);
        $patient->update($request);
        LogBatch::endBatch();
        // $detail = PatientDetail::find($patient);

        return redirect()->route('admin.patients.show', $patient)->withSuccess("Data berhasil diperbarui!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientDetail $patient)
    {
        LogBatch::startBatch();
        $patient->delete();
        if (request()->ajax()) {
            return true;
        };
        LogBatch::endBatch();
        return to_route('admin.patients.index');
    }
}