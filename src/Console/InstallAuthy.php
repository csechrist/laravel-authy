<?php

namespace Csechrist\LaravelChargebee\Console;

use Illuminate\Console\Command;

class InstallAuthy extends Command {
    protected $signature = 'authy:install';

    protected $description = 'Install the Authy';

    public function handle() {
        $this->info( 'Installing Authy...' );

        $this->info( 'Installing the Authy package' );
        $bar = $this->output->createProgressBar( 3 );

        try {
            $this->info( 'Publishing Configuration...' );
            $this->call( 'vendor:publish', [
                '--provider' => 'Csechrist\LaravelAuthy\LaravelAuthyServiceProvider',
                '--tag' => 'config'
            ] );

            $bar->advance();

            $this->info( 'Publishing migrations...' );
            $this->call( 'vendor:publish', [
                '--provider' => 'Csechrist\LaravelAuthy\LaravelAuthyServiceProvider',
                '--tag' => 'migrations'
            ] );
            $bar->advance();

            if ( $this->confirm( 'Do you want to publish the views?' ) ) {
                $this->info( 'Publishing Views' );
                $this->call( 'vendor:publish', [
                    '--provider' => 'Csechrist\LaravelAuthy\LaravelAuthyServiceProvider',
                    '--tag' => 'views'
                ] );
            }
        } catch ( \Exception $e ) {
            $this->error( 'Could not fully install the Authy package' );
        }

        $bar->finish();
        $this->info( 'Installed Authy' );

    }
}
