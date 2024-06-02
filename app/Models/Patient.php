<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = false;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['district', 'education', 'religion', 'emergency_contact'];

    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user()->name ?? 'System';
        $name = $this->name;
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('patient')
            ->setDescriptionForEvent(fn (string $eventName) => "{$user} {$eventName} patient {$name}");
    }

    public function scopeLast($query)
    {
        $query->orderBy('id', 'desc')->take(1);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function emergency_contact()
    {
        return $this->belongsTo(EmergencyContact::class);
    }

    public function patientDetail()
    {
        return $this->hasOne(PatientDetail::class);
    }
}
