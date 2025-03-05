<?php

namespace Novius\ArtisanCommands\Tests\Console\Database;

use Illuminate\Support\Facades\Artisan;
use Novius\ArtisanCommands\ArtisanCommandsServiceProvider;
use Orchestra\Testbench\TestCase;

class CreateTest extends TestCase
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
    public function test_create_db_command_exists()
    {
        $commands = Artisan::all();
        $this->assertArrayHasKey('db:create', $commands);
    }
}
