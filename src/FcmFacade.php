<?php

namespace Kawankoding\Fcm;

use Illuminate\Support\Facades\Facade;

/**
 * Class Fcm
 * @package Kawankoding\Fcm\Facades
 */
class FcmFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fcm';
    }
}
