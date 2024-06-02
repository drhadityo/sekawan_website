<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EmergencyContact extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    protected $with = ['district'];

    public $timestamps = false;

    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user()->name ?? 'System';
        $name = $this->patient[0]->name ?? request('name');
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('emergency contact')
            ->setDescriptionForEvent(fn (string $eventName) => "{$user} {$eventName} patient emergency contact {$name}");
    }

    public function scopeLast($query)
    {
        $query->orderBy('id', 'desc')->take(1);
    }

    public function patient()
    {
        return $this->hasMany(Patient::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
