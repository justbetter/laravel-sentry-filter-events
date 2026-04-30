<?php

namespace JustBetter\LaravelSentryFilterEvents;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\LaravelSentryFilterEvents\Actions\GetFilterList;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this
            ->registerActions()
            ->registerConfig();
    }

    protected function registerActions(): static
    {
        GetFilterList::bind();

        return $this;
    }

    protected function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sentry-filter.php', 'sentry-filter');

        return $this;
    }
}
