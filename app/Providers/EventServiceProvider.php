<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Patient;
use App\Models\PatientDetail;
use App\Models\User;
use App\Observers\ArticleObserver;
use App\Observers\UserObserver;
use App\Observers\PatientObserver;
use App\Observers\PatientDetailObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Article::observe(ArticleObserver::class);
        Patient::observe(PatientObserver::class);
        User::observe(UserObserver::class);
        PatientDetail::observe(PatientDetailObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
