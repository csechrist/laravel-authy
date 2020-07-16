<?php

namespace Csechrist\LaravelAuthy;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Csechrist\LaravelAuthy\Skeleton\SkeletonClass
 */
class LaravelAuthyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-authy';
    }
}
