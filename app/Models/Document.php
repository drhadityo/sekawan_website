<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'judul', 'deskripsi', 'file_path'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user()->name ?? 'System';
        $name = $this->judul;
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('document')
            ->setDescriptionForEvent(fn (string $eventName) => "{$user} {$eventName} document {$name}");
    }
}
