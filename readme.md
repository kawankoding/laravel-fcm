# Laravel FCM

A simple package that help you send a Firebase notification with your Laravel applications

### Installation

You can pull the package via composer :

```bash
$ composer require kawankoding/laravel-fcm "^0.2.0"
```

#### Laravel

You must register the service provider :

```php
// config/app.php

'Providers' => [
   // ...
   Kawankoding\Fcm\FcmServiceProvider::class,
]
```

If you want to make use of the facade you must install it as well :

```php
// config/app.php

'aliases' => [
    // ...
    'Fcm' => Kawankoding\Fcm\FcmFacade::class,
];
```

Next, You must publish the config file to define your FCM server key :

```bash
php artisan vendor:publish --provider="Kawankoding\Fcm\FcmServiceProvider"
```

This is the contents of the published file :

```php
return [

    /**
     * Set your FCM Server Key
     * Change to yours
     */

    'server_key' => env('FCM_SERVER_KEY', ''),

];
```

#### Lumen

Add the following service provider to the `bootstrap/app.php` file
```php
$app->register(Kawankoding\Fcm\FcmServiceProvider::class);
```

Also copy the [laravel-fcm.php](https://github.com/kawankoding/laravel-fcm/blob/master/resources/config/laravel-fcm.php) config file to `config/laravel-fcm.php`


Add the configuration to the `bootstrap/app.php` file
    *Important:* this needs to be before the registration of the service provider
```php
$app->configure('laravel-fcm');
...
$app->register(Kawankoding\Fcm\FcmServiceProvider::class);
```

Set your FCM Server Key in `.env` file :

```
APP_NAME="Laravel"
# ...
FCM_SERVER_KEY=putYourKeyHere
```


### Methods Ref

- `->to()`

- `->toTopic()`

- `->data()`

- `->notification()`

- `->priority()`

- `->timeToLive()`

- `->enableResponseLog()`

- `->send()`


### Usage

If You want to send a FCM with just notification parameter, this is an example of usage sending a FCM with only data parameter :

```php
$recipients = [
    'clKMv.......',
    'GxQQW.......',
];

fcm()
    ->to($recipients)
    ->priority('high')
    ->timeToLive(0)
    ->data([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->send();
```

**NOTE**: By default, Firebase server will queue your notification in 4 weeks. You could change this behavior by setting `->timeToLive(value_in_seconds)`. For example snippet above "->timeToLive(0)" will skip the queue, the target device (eg. android) must be online when the notification arive, otherwhise the target device will not receive the notification.


If You want to send a FCM to topic, use method toTopic(\$topic) instead to() :

```php
fcm()
    ->toTopic($topic) // $topic must an string (topic name)
    ->priority('normal')
    ->timeToLive(0)
    ->notification([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->send();
```

If You want to send a FCM with just notification parameter, this is an example of usage sending a FCM with only notification parameter :

```php
fcm()
    ->to($recipients) // $recipients must an array
    ->priority('high')
    ->timeToLive(0)
    ->notification([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->send();
```

If You want to send a FCM with both data & notification parameter, this is an example of usage sending a FCM with both data & notification parameter :

```php
fcm()
    ->to($recipients) // $recipients must an array
    ->priority('normal')
    ->timeToLive(0)
    ->data([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->notification([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->send();
```

### Logging

To see the original response from Firebase, call `enableResponseLog()` method before calling the `send()` method.

```php
fcm()
    ->to($recipients)
    // ...
    ->enableResponseLog()
    ->send();

```

Then you can check the response log in the file `storage/logs/laravel.log`
