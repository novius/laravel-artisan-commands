<?php

namespace Novius\ArtisanCommands\Tests\Console\Database;

use Illuminate\Support\Facades\Artisan;
use Novius\ArtisanCommands\ArtisanCommandsServiceProvider;
use Orchestra\Testbench\TestCase;

class GetNameTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ArtisanCommandsServiceProvider::class,
        ];
    }

    /**
     * Does the new command db:create exist ? This doesn't check if this command actually work.
     */
    public function testConfigureDBCommandExists()
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey('db:get-name', $commands);
    }
}
