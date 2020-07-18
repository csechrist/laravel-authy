<?php

namespace Csechrist\LaravelAuthy;
use Authy\AuthyApi;

class LaravelAuthy {
    /**
    * Laravel Authy Version
    *
    * @var string
    */

    const VERSION = '1.0.0';

    /**
    * Authy Version
    *
    * @var string
    */

    const AUTHY_VERSION = 'v2';

    /**
    * Indicates if LaravelAuthy migrations will be run.
    *
    * @var bool
    */
    public static $runsMigrations = true;

    /**
    * Indicates if LaravelAuthy routes will be registered.
    *
    * @var bool
    */
    public static $registersRoutes = true;

    /**
    * Authy API Instance
    *
    * @var AuthyApi
    */
    private $auth_api;

    /**
    * Creates the main authy instance
    */

    public function __construct() {
        if ( config( 'authy.api_key' ) ) {
            $this->authy_api = new AuthyApi( config( 'authy.api_key' ) );
        }
    }

    /**
    * Configure LaravelAuthy to not register its migrations.
    *
    * @return static
    */
    public static function ignoreMigrations() {
        static::$runsMigrations = false;

        return new static;
    }

    /**
    * Configure LaravelAuthy to not register its routes.
    *
    * @return static
    */
    public static function ignoreRoutes() {
        static::$registersRoutes = false;

        return new static;
    }

    /**
    * Starts the verification process
    *
    * @param string $authy_id
    */

    public function sendMfa( $authy_id ) {
        // For right now, this is just going to use the SMS verification method
        $this->authy_api->requestSms( $authy_id );
    }
}
