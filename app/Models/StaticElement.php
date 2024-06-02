<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StaticElement extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['elements', 'contents'];

    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user()->name ?? 'System';
        $element = $this->element;
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('about')
            ->setDescriptionForEvent(fn (string $eventName) => "{$user} {$eventName} Sekawan's {$element}");
    }
}
