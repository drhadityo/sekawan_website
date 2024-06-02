<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Message extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'nama',
        'alamat',
        'instansi',
        'nomor',
        'keperluan',
        'file_path',
    ];

    public function saveFile($file)
    {
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storeAs('files', $fileName); 

        $this->file_path = $filePath;
        $this->save();
    }

    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user()->name ?? 'System';
        $name = $this->nama; 
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('message')
            ->setDescriptionForEvent(fn (string $eventName) => "{$user} {$eventName} message {$name}");
    }
}
