# Citronel error catalogue

A catalogue of errors to use in your Laravel project that uses a standard format. This can be useful for customer support staff and to perform further analysis of errors after logging.

## Features
* A catalogue of errors modelled in the following format: [main-process code]-[sub-process code]-[event code]
* General error codes for validation, authentication
* Commands to dump error codes and messages in CSV

## Requirements

* [Composer](https://getcomposer.org/)
* [Laravel](http://laravel.com/)

## Installation

* Install the package using composer:

```bash
 $ composer require aliirfaan/citronel-error-catalogue
```

* Publish files with:

```bash
 $ php artisan vendor:publish --provider="aliirfaan\CitronelErrorCatalogue\CitronelErrorCatalogueProvider"
```

or by using only `php artisan vendor:publish` and select the `aliirfaan\CitronelErrorCatalogue\CitronelErrorCatalogueProvider` from the outputted list.

## Configuration

This package publishes two configuration files. Please view configuration files for documentation.
* citronel-error-catalogue.php - the error catalogue
* citronel-error-config.php - package configuration

## Commands
* Dump error catalogue in CSV
```bash
 $ php artisan citronel:error-catalogue:dump {filename=error-catalogue.csv} {folder=error-catalogue}
```

* Dump messages in CSV
```bash
 $ php artisan citronel:messages:dump {filename=messages.csv} {folder=messages}
```

## Traits
* ErrorCatalogue.php

## Usage

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use aliirfaan\CitronelErrorCatalogue\Traits\ErrorCatalogue;
use aliirfaan\CitronelErrorCatalogue\Services\CitronelErrorCatalogueService;

class TestController extends Controller
{
    // use trait
    use ErrorCatalogue;

    public function test(Request $request, CitronelErrorCatalogueService $citronelErrorCatalogueService)
    {
        try {

            // validation error example, pass general validation error code as extra code
            $mainProcess = config('citronel-error-catalogue.process.customer');
            $mainProcessKey = $mainProcess['key'];

            $subProcess = $mainProcess['sub_process']['register'];
            $subProcessKey = $subProcess['key'];

            $code = $citronelErrorCatalogueService->generateCodeFromCatalogue($mainProcessKey, $subProcessKey, null, $this->validationErrorCatalogue()['code']);

            // event example
            $event = $subProcess['events']['customer_already_exists'];
            $eventKey = $event['key'];

            $code = $citronelErrorCatalogueService->generateCodeFromCatalogue($mainProcessKey, $subProcessKey, $eventKey);

        } catch (\Exception $e) {
            report($e);
        }
    }
}
```