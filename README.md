# Fetch the list of Australian superannuation funds straight from the government _in Laravel!_

**Disclaimer: This package is experimental, and you should not use it in production until version 1 is tagged and released.**

This package is a fairly lightweight wrapper around the service provided by the Australian government that lists all superannuation funds and products by their identifier (USI).

You can find the download [here](https://superfundlookup.gov.au/Tools/DownloadUsiList?download=usi), and structural information about the download [here](https://superfundlookup.gov.au/Tools/DownloadUsiList). 

We download the text file from this URL, then parse it into some DTOs which you can then save in your database, or use however you wish.

## Usage

```php
/** @var \Atlas\LaravelAustralianSuperannuationFunds\SuperannuationFunds $fetcher */
$fetcher = app(\Atlas\LaravelAustralianSuperannuationFunds\SuperannuationFunds::class);

$superannuationFunds = $fetcher->fetch();

dd($superannuationFunds);
```