<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Stilinski Ussd Package

Stilinski Ussd is a modern multi-language (english and swahili) laravel dynamic ussd application framework with expressive, elegant syntax. Very easy to use. It also has a ussd simulator for  easy debugging & maintenance.

## Installation Procedure

### Add the following to your root composer.json

    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:StilinskiCyril/ussd.git"
        }
    ],

### Require the package

    composer require stilinski/ussd

### Also require these additional packages

    composer require doctrine/dbal
    composer require giggsey/libphonenumber-for-php

### Run the migrations

    php artisan migrate

### Listen to the following queues
    save-ussd-messages - save ussd session data into the database

### Publish package support files
    php artisan vendor:publish --tag=ussd-lang,ussd-repositories

### Add the following variables in your root project's .env

    RESTRICT_TO_WHITELIST=true
    WHITELIST_MSISDNS="254705799644" #Comma separated phone numbers that you want to have access to the app *N/B* should be in 254 format
    END_SESSION_SLEEP_SECONDS= 2
    USSD_CODE=657 #This is the ussd code given to you by your provider eg 999
    LOG_USSD_REQUEST=true #Log the requests hitting your endpoint
    ONLINE_ENDPOINT='api/process-payload/55034fd5-bd23h5d9948f' #The target url that your service provider will be hitting your app

### Simulator URL

    The ussd simulator can be found in the url "/simulator". Kindly note that it mimics a live ussd environment meaning that you have to click "new session" button whenever you want to simulate the start of a new session.

## Security Vulnerabilities

If you discover a security vulnerability within the library, please send an e-mail to [Cyril Aguvasu](mailto:aguvasucyril@gmail.com). All security vulnerabilities will be promptly addressed.

## License

This framework is owned and maintained by [Cyril Aguvasu](https://github.com/StilinskiCyril)