<?php

namespace JustBetter\LaravelSentryFilterEvents\Contracts;

interface GetsFilterList
{
    /** @return array<array<string, string>> */
    public function getCached(?string $path = null): array;
}
