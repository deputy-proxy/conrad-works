<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Policies\OwnedResourcePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerOwnershipPolicies();
        $this->configureDefaults();
    }

    /**
     * Apply the same owner-based authorization rules to every Filament resource model.
     */
    protected function registerOwnershipPolicies(): void
    {
        foreach ([
            \App\Models\Article::class,
            \App\Models\Book::class,
            \App\Models\BookableSlot::class,
            \App\Models\Booking::class,
            \App\Models\Course::class,
            \App\Models\DaughterMessage::class,
            \App\Models\Habit::class,
            \App\Models\HabitCompletion::class,
            \App\Models\MyRole::class,
            \App\Models\Song::class,
            \App\Models\Venture::class,
            \App\Models\WifeMessage::class,
        ] as $model) {
            Gate::policy($model, OwnedResourcePolicy::class);
        }
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
