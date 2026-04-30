# Laravel Sentry Filter Events

A small package that lets you filter Sentry events with an ignore list. Can also use externally hosted JSON files as lists.

## Installation

```sh
composer require justbetter/laravel-sentry-filter-events
```

## Configuration

You will have to enable the `before_send` handler in your `config/sentry.php`:

```php
'before_send' => [\Rapidez\Sentry\Filters\SentryFilter::class, 'beforeSend'],
```

You can then configure your `config/rapidez/sentry.php` as follows:
```php
// List of errors to ignore
'ignore_errors' => [
    ['message' => 'Unnecessary error'],
    ['exception' => \App\UnnecessaryError::class],
],
```

You can ignore either messages that contain certain strings, or whole Exception classes. 

### Global filtering

You can also use an external JSON file to filter errors globally. This has the same format as the list of ignore_errors (but then in JSON). For example:

```json
{
    {"message": "Unnecessary error"},
    {"exception": "\\App\\UnnecessaryError"},
},
```

## Scopes

This package contains the ability to use multiple scopes (defined in the config file). This allows you to filter different errors in different situations.

For example, you could create a scope for your frontend errors and retrieve the list like so:

```php
$filterList = resolve(\JustBetter\LaravelSentryFilterEvents\GetFilterList::class)->getCached('frontend');
```

Take a look at how `src/filters/SentryFilter.php` works for more information.
