<?php

declare(strict_types=1);

namespace JustBetter\LaravelSentryFilterEvents\Tests\Actions;

use Illuminate\Support\Facades\Http;
use JustBetter\LaravelSentryFilterEvents\Actions\GetFilterList;
use JustBetter\LaravelSentryFilterEvents\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class GetFilterListTest extends TestCase
{
    #[Test]
    public function it_can_get_filter_lists(): void
    {
        $testData = [['message' => 'test'], ['exception' => 'TestException']];
        Http::fake([
            'fake-url/test.json' => Http::response($testData),
        ]);

        config(['sentry-filter.scopes.laravel.filter_list' => 'fake-url/test.json']);

        /** @var GetFilterList $action */
        $action = resolve(GetFilterList::class);

        $messages = $action->getCached();

        $this->assertEqualsCanonicalizing($testData, $messages);
    }


    #[Test]
    public function it_handles_nonexistent_scopes(): void
    {
        /** @var GetFilterList $action */
        $action = resolve(GetFilterList::class);

        $messages = $action->getCached('invalid');

        $this->assertEquals([], $messages);
    }
}
