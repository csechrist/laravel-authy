<?php

namespace Csechrist\LaravelAuthy\Tests;

use Orchestra\Testbench\TestCase;
use Csechrist\LaravelAuthy\LaravelAuthyServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelAuthyServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
