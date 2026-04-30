<?php

declare(strict_types=1);

namespace JustBetter\LaravelSentryFilterEvents\Tests;

use JustBetter\LaravelSentryFilterEvents\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }
}
