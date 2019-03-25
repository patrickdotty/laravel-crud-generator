<?php

namespace Dottystyle\LaravelCrudGenerator\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

/**
 * Override the standard PHPUnit testcase with the Testbench testcase
 *
 * @see https://github.com/orchestral/testbench#usage
 */
class TestCase extends OrchestraTestCase
{
    /**
     * Include the package's service provider(s)
     *
     * @see https://github.com/orchestral/testbench#custom-service-provider
     * @param Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Dottystyle\LaravelCrudGenerator\Providers\LaravelCrudGeneratorServiceProvider::class
        ];
    }
}
