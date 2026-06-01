<?php

declare(strict_types=1);

namespace JustBetter\LaravelSentryFilterEvents\Actions;

use Illuminate\Support\Facades\Http;
use JustBetter\LaravelSentryFilterEvents\Contracts\GetsFilterList;

class GetFilterList implements GetsFilterList
{
    /** @return array<array<string, string>> */
    public function get(?string $scope = null): array
    {
        return cache()
            ->flexible(
                'sentry-filter-list:'.str($scope)->slug(),
                [
                    now()->addSeconds(config()->integer('sentry-filter.cache.fresh')),
                    now()->addSeconds(config()->integer('sentry-filter.cache.stale')),
                ],
                fn (): array => $this->getWithoutCache($scope),
            );
    }

    /** @return array<array<string, string>> */
    public function getWithoutCache(?string $scope = null): array
    {
        if ($scope === null) {
            $scope = config('sentry-filter.default_scope', 'default');
        }

        $path = config(sprintf('sentry-filter.scopes.%s.filter_list', $scope));

        /** @var array<array<string, string>> $extraList */
        $extraList = config(sprintf('sentry-filter.scopes.%s.ignore_errors', $scope), []);

        $filterList = $this->getFilterList($path);

        return array_merge($filterList, $extraList);
    }

    /** @return array<array<string, string>> */
    protected function getFilterList(?string $path): array
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
