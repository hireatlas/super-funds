# Fetch the list of Australian superannuation funds straight from the government

[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hireatlas/super-funds/run-tests.yml)](https://github.com/hireatlas/super-funds/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/hireatlas/super-funds.svg)](https://packagist.org/packages/hireatlas/super-funds)
[![Total Downloads](https://img.shields.io/packagist/dt/hireatlas/super-funds.svg)](https://packagist.org/packages/hireatlas/super-funds)

This package is a fairly lightweight Laravel wrapper around the service provided by the Australian government that lists all superannuation funds and products by their identifier (USI).

You can find the download [here](https://superfundlookup.gov.au/Tools/DownloadUsiList?download=usi), and structural information about the download [here](https://superfundlookup.gov.au/Tools/DownloadUsiList). 

We download the text file from this URL, then parse it into some DTOs which you can then save in your database, or use however you wish.

## Installation

```bash
composer require hireatlas/super-funds
```

This package supports Laravel 10+, and PHP 8.1+.

## Usage

### Fetching the list of super funds as DTOs

To fetch the list of current super funds, you can call the `fetch()` method on the `SuperFunds` class. This will return a Collection of `SuperFundDTO` objects.

```php
use Atlas\SuperFunds\SuperFunds;

/** @var SuperFunds $superFundsFetcher */
$superFundsFetcher = app(SuperFunds::class);

$superFunds = $superFundsFetcher->fetch();

dd($superannuationFunds);
```

### Persisting the list of super funds as Eloquent models to your database

The package publishes a migration to store the super funds as Eloquent models in your database, so be sure to run `php artisan migrate` first before running the below.

To fetch and persist the list of current super funds to the database, you can call the `persist()` method on the `SuperFunds` class.

```php
use Atlas\SuperFunds\SuperFunds;

/** @var SuperFunds $superFundsFetcher */
$superFundsFetcher = app(SuperFunds::class);

$superannuationFunds = $superFundsFetcher->persist();

dd($superannuationFunds);
```

### Using a custom Eloquent model

You can use a custom Eloquent model by calling the `useModel()` method on the `SuperFunds` class. You should call this from the `boot()` method in your `App\Providers\AppServiceProvider`.

```php
use App\Models\SuperFund as CustomSuperFundModel;
use Atlas\SuperFunds\SuperFunds;

public function boot() {
    SuperFunds::useModel(CustomSuperFundModel::class);
}
```

### Disabling migrations

If you don't wish to use the default migration, or don't wish to persist models at all, then you can call the `ignoreMigrations()` method on the `SuperFunds` class. You should call this from the `boot()` method in your `App\Providers\AppServiceProvider`.

```php
use Atlas\SuperFunds\SuperFunds;

public function boot() {
    SuperFunds::ignoreMigrations();
}
```

### Regularly fetching the current list via task scheduling

The package includes both a command and a job for you to invoke from your `App\Console\Kernel`. They're equivalent, so use whichever method your prefer.

To avoid overloading the upstream service, please pick a random time of the day to fetch the list.

```php
use Atlas\SuperFunds\Jobs\UpdateSuperFunds;

$schedule->command('super-funds:update')->dailyAt('01:23');
// OR
$schedule->job(new UpdateSuperFunds)->dailyAt('01:23');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mitchell Davis](https://github.com/mitchdav)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.