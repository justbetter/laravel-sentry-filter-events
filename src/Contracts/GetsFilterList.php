<?php

declare(strict_types=1);

namespace JustBetter\LaravelSentryFilterEvents\Contracts;

interface GetsFilterList
{
    /** @return array<array<string, string>> */
    public function get(?string $path = null): array;

    /** @return array<array<string, string>> */
    public function getWithoutCache(?string $path = null): array;
}
