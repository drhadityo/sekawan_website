<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientStatus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function patientDetails()
    {
        return $this->hasMany(PatientDetail::class);
    }
}
