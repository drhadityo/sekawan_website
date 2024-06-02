<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Policies\AccessControlPolicy;

class User extends Authenticatable
{
    use HasApiTokens, LogsActivity, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $policies = [
        AccessControlPolicy::class,
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'number', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static $recordEvents = ['created', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        $user = auth()->user()->name ?? 'System';
        $name = $this->name;
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('user')
            ->setDescriptionForEvent(fn (string $eventName) => "{$user} {$eventName} user {$name}");
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
