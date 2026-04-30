<?php

declare(strict_types=1);

namespace JustBetter\LaravelSentryFilterEvents\Tests\Filters;

use Exception;
use Illuminate\Support\Facades\Http;
use JustBetter\LaravelSentryFilterEvents\Filters\SentryFilter;
use JustBetter\LaravelSentryFilterEvents\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Sentry\Event;
use Sentry\EventHint;
use Sentry\ExceptionDataBag;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class SentryFilterTest extends TestCase
{
    #[Test]
    public function it_can_filter_errors(): void
    {
        $testData = [['message' => 'First'], ['exception' => HttpException::class]];
        Http::fake([
            'fake-url/test.json' => Http::response($testData),
        ]);

        /** @var SentryFilter $action */
        $action = resolve(SentryFilter::class);
        config(['sentry-filter.scopes.laravel.filter_list' => 'fake-url/test.json']);

        $fakeExceptions = [
            ['exception' => new Exception('First exception 1'), 'shouldFilter' => true],
            ['exception' => new HttpException(401, 'Second exception'), 'shouldFilter' => true],
            ['exception' => new Exception('Third exception'), 'shouldFilter' => false],
        ];

        /** @var array{exception: Exception, shouldFilter: bool} $exception */
        foreach ($fakeExceptions as $exception) {
            $event = Event::createEvent();
            $event->setExceptions([
                new ExceptionDataBag($exception['exception']),
            ]);

            $hint = EventHint::fromArray(['exception' => $exception['exception']]);

            $result = $action->beforeSend($event, $hint);

            if ($exception['shouldFilter']) {
                $this->assertNull($result);
            } else {
                $this->assertNotNull($result);
            }
        }
    }
}
