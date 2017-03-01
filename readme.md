# Laravel FCM

A Simple package that help you send a firebase notification with your laravel applications

### Installation

You can pull the package via composer :

``` bash
$ composer require spatie/laravel-fractal
```

 Next, You must register the service provider :

 ``` php
// config/app.php

'Providers' => [
    ...
    Kawankoding\Fcm\Providers\FcmServiceProvider::class,
]
 ```

 If you want to make use of the facade you must install it as well:

```php
// config/app.php
'aliases' => [
    ...
    'Fcm' => Kawankoding\Fcm\Facades\Fcm::class,
];
```

Next, You must publish the config file to define your fcm server key :

```bash
php artisan vendor:publish --provider="Kawankoding\Fcm\Providers\FcmServiceProvider"
```

This is the contents of the published file:

```php
return [

    /*
    * Your Fcm Server Key
    * Change yo yours
    */

    'server_key' => '',

];
```

### Usage

If You want to send a FCM with just notification parameter, this is an example of usage sending a FCM with only data parameter :
```php
fcm()
    ->data([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->push();
```

If You want to send a FCM with just notification parameter,this is an example of usage sending a FCM with only notification parameter :
```php
fcm()
    ->notification([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->push();
```

If You want to send a FCM with both data & notification parameter, this is an example of usage sending a FCM with both data & notification parameter :
```php
fcm()
    ->data([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->notification([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->push();
```
