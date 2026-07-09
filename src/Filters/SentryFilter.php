<?php

declare(strict_types=1);

namespace JustBetter\LaravelSentryFilterEvents\Filters;

use JustBetter\LaravelSentryFilterEvents\Actions\GetFilterList;
use Sentry\Event;
use Sentry\EventHint;

class SentryFilter
{
    public static function beforeSend(Event $event, EventHint $hint): ?Event
    {
        $filterList = resolve(GetFilterList::class)->get();

        $messagesToFilter = collect($filterList)->pluck('message')->whereNotNull();
        $exceptionsToFilter = collect($filterList)->pluck('exception')->whereNotNull();

        $exceptionMessages = collect($event->getExceptions())
            ->map(fn ($exception): string => $exception->getValue());

        if ($exceptionMessages->contains(
            fn ($exception) => $messagesToFilter->contains(fn ($message): bool => str_contains($exception, (string) $message))
        )) {
            return null;
        }

        if ($exceptionsToFilter->contains(fn ($exception): bool => $hint->exception instanceof $exception)) {
            return null;
        }

        return $event;
    }
}
