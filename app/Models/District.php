<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $with = ['regency'];
    protected $fillable = ['latitude', 'longitude'];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function patientDetails()
    {
        return $this->hasmanyThrough(PatientDetail::class, Patient::class);
    }

    public function satelliteHealthFacility()
    {
        return $this->hasMany(SatelliteHealthFacility::class);
    }
}