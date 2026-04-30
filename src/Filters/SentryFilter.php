<?php

namespace JustBetter\LaravelSentryFilterEvents\Filters;

use JustBetter\LaravelSentryFilterEvents\Actions\GetFilterList;
use Sentry\Event;
use Sentry\EventHint;

class SentryFilter
{
    public static function beforeSend(Event $event, EventHint $hint): ?Event
    {
        $filterList = resolve(GetFilterList::class)->getCached();

        $scope = config('sentry-filter.default_scope');

        $messagesToFilter = collect($filterList)->pluck('message')->whereNotNull();
        $exceptionsToFilter = collect($filterList)->pluck('exception')->whereNotNull();

        $exceptionMessages = collect($event->getExceptions())
            ->map(fn ($exception) => $exception->getValue());

        if ($exceptionMessages->contains(
            fn ($exception) => $messagesToFilter->contains(fn ($message) => str_contains($exception, $message))
        )) {
            return null;
        }

        if ($exceptionsToFilter->contains(fn ($exception) => $hint->exception instanceof $exception)) {
            return null;
        }

        return $event;
    }
}
