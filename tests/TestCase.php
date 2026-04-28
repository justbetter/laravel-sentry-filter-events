<?php

declare(strict_types=1);

namespace JustBetter\LaravelSentryFilterEvents\Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            JustBetter\LaravelSentryFilterEvents\ServiceProvider::class,
        ];
    }
}
