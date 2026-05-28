<?php

namespace App\Providers;

use App\Models\Action;
use App\Models\Entrepreneur;
use App\Models\Event;
use App\Models\IntegratorProject;
use App\Models\Unidade;
use App\Policies\ActionPolicy;
use App\Policies\EntrepreneurPolicy;
use App\Policies\EventPolicy;
use App\Policies\IntegratorProjectPolicy;
use App\Policies\UnidadePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::policy(Action::class, ActionPolicy::class);
        Gate::policy(Event::class, EventPolicy::class);
        Gate::policy(IntegratorProject::class, IntegratorProjectPolicy::class);
        Gate::policy(Entrepreneur::class, EntrepreneurPolicy::class);
        Gate::policy(Unidade::class, UnidadePolicy::class);
    }
}
