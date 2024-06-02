<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Patient;
use App\Models\PatientDetail;
use App\Models\EmergencyContact;

class CleanDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean unused database patient';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $patientId = collect([]);
        PatientDetail::select('patient_id')->get()->each(fn ($data) => $patientId->push($data->patient_id));
        $unsPatient = Patient::whereNotIn('id', $patientId)->get()->each(fn ($data) => $data->delete());

        $emergencyId = collect([]);
        Patient::select('emergency_contact_id')->get()->each(fn ($data) => $emergencyId->push($data->emergency_contact_id));
        $unsemergency = EmergencyContact::whereNotIn('id', $emergencyId)->get()->each(fn ($data) => $data->delete());
    }
}
