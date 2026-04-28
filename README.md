# Laravel Sentry Filter Events

A small package that lets you filter Sentry events with an ignore list. Can also use externally hosted json files as lists.

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
'ignoreErrors' => [
    ['message' => 'Unnecessary error'],
    ['exception' => \App\UnnecessaryError::class],
],
```

You can ignore either messages that contain certain strings, or whole Exception classes. 

### Global filtering

You can also use an external JSON file to filter errors globally. This has the same format as the list of ignoreErrors (but then in json). For example:

```json
{
    {"message": "Unnecessary error"},
    {"exception": "\\App\\UnnecessaryError"},
},
```
