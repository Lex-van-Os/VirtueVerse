<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\BookEdition;
use App\Observers\BookEditionObserver;
use App\Observers\BookObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Author;
use App\Observers\AuthorObserver;
use Illuminate\Database\Eloquent\Events\Creating;

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
        AuthorCreating::class => [
            AuthorObserver::class,
        ],
        BookEditionCreating::class => [
            BookEditionObserver::class,
        ],
        BookCreating::class => [
            BookObserver::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
