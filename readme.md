# Laravel FCM

A simple package that help you send a Firebase notification with your Laravel applications

### Installation

You can pull the package via composer :

```bash
$ composer require kawankoding/laravel-fcm
```

Next, You must register the service provider :

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

Set your FCM Server Key in `.env` file :

```
APP_NAME="Laravel"
# ...
FCM_SERVER_KEY=putYourKeyHere
```

### Usage

If You want to send a FCM with just notification parameter, this is an example of usage sending a FCM with only data parameter :

```php
fcm()
    ->to($recipients) // $recipients must an array
    ->priority('high')
    ->timeToLive(0)
    ->data([
        'title' => 'Test FCM',
        'body' => 'This is a test of FCM',
    ])
    ->send();
```

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

### Notes

## Sending different payloads

This packages uses a singleton pattern for the `Fcm` facade and `fcm()` helper.
If you want to send diffent payloads to Firebase in the same request you have to use use the `Kawankoding\Fcm\Fcm` class directly:

```php
use Kawankoding\Fcm\Fcm;

$fcm1 = new Fcm;
$fcm1->to($recipients)
    ->data([
        'title' => 'Test FCM 1',
        'body' => 'This is a test of FCM 1',
    ])
    ->send();

$fcm2 = new Fcm;
$fcm2->to($recipients)
    ->notification([
        'title' => 'Test FCM 2',
        'body' => 'This is a test of FCM 2',
    ])
    ->send();
```
