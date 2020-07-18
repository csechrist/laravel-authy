<?php
namespace CSechrist\LaravelAuthy;

use CSechrist\LaravelAuthy\LaravelAuthy;

trait Use2fa {
    /**
    * The user has been authenticated.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  mixed  $user
    * @return mixed
    */
    protected function authenticated( Request $request, $user ) {
        if ( $user->require_authy && !\session( 'mfa' ) ) {
            $authy_api = new LaravelAuthy();
            $authy_api->sendMFA( $user->authy_id );
            \session( ['mfa' => false] );
            return \redirect()->route( 'authy.verify' );
        }
    }
}
