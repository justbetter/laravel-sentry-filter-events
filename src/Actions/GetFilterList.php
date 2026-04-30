<?php

namespace JustBetter\LaravelSentryFilterEvents\Actions;

use Illuminate\Support\Facades\Http;
use JustBetter\LaravelSentryFilterEvents\Contracts\GetsFilterList;

class GetFilterList implements GetsFilterList
{
    /** @return array<array<string, string>> */
    public function getCached(?string $scope = null): array
    {
        if ($scope === null) {
            $scope = config('sentry-filter.default_scope');
        }
        $path = config("sentry-filter.scopes.$scope.filter_list");

        /** @var array<array<string, string>> $extraList */
        $extraList = config("sentry-filter.scopes.$scope.ignore_errors");

        if (! $path) {
            return $extraList;
        }

        $filterList = cache()
            ->flexible(
                'sentry-filter-list:'.str($path)->slug(),
                [now()->addHour(), now()->addDay()],
                fn () => $this->getFilterList($path),
            );

        return array_merge($filterList, $extraList);
    }

    /** @return array<array<string, string>> */
    protected function getFilterList(string $path): array
    {
        if (! $path) {
            return [];
        }

        $response = Http::get($path);

        return $response->json();
    }

    public static function bind(): void
    {
        app()->singleton(GetsFilterList::class, static::class);
    }
}
