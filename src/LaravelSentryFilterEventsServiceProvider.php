<?php

namespace JustBetter\LaravelSentryFilterEvents;

use Illuminate\Support\ServiceProvider;

class LaravelSentryFilterEventsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    protected function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sentry-filter.php');

        return $this;
    }
}
