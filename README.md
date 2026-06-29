# Laravel Sentry Filter Events

A small package that lets you filter Sentry events with an ignore list. Can also use externally hosted JSON files as lists.

## Installation

```sh
composer require justbetter/laravel-sentry-filter-events
```

## Configuration

You will have to enable the `before_send` handler in your `config/sentry.php`:

```php
'before_send' => [\JustBetter\LaravelSentryFilterEvents\Filters\SentryFilter::class, 'beforeSend'],
```

You can then configure your `config/sentry-filter.php`, for example:
```php
// List of errors to ignore
'ignore_errors' => [
    ['message' => 'Unnecessary error'],
    ['exception' => \App\UnnecessaryError::class],
],
```

You can ignore either messages that contain certain strings, or whole Exception classes. 

### Global filtering

You can also use an external JSON file to filter errors globally. This has the same format as the list of ignore_errors (but then in JSON). Note that Exception class names need to be complete. For example:

```json
{
    {"message": "Unnecessary error"},
    {"exception": "\\App\\UnnecessaryError"},
},
```

For simplicity, the config uses the `SENTRY_FILTER_LIST_LARAVEL` env variable by default to define the filter list url. This means that if you only want to use an external filter list, you don't need to publish the config file.

## Scopes

This package contains the ability to use multiple scopes (defined in the config file). This allows you to filter different errors in different situations.

For example, if you have Sentry enabled on your frontend, you don't want to use the same filter list as you would for your backend errors. In that case, you could create a new scope in the config for your frontend errors and retrieve the list like so:

```php
$filterList = resolve(\JustBetter\LaravelSentryFilterEvents\Actions\GetFilterList::class)->get('frontend');
```

Take a look at how `src/filters/SentryFilter.php` works for more information.
