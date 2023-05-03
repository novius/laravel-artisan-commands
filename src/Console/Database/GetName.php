<?php

namespace Novius\ArtisanCommands\Console\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetName extends Command
{
    protected $signature = 'db:get-name {--connection=}';

    protected $description = 'Get database name for current or given connection name.';

    protected ?string $connectionName;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->connectionName = $this->option('connection');
        $dbName = DB::getDatabaseName();

        if ($this->connectionName !== null) {
            if (! config()->has($this->databaseConfigName())) {
                return Command::FAILURE;
            }

            $dbName = config($this->databaseConfigName());
        }

        $this->line($dbName);

        return Command::SUCCESS;
    }

    /**
     * Return complete database connection config name, using $this->connectionName.
     */
    protected function databaseConfigName(): string
    {
        return 'database.connections.'.$this->connectionName.'.database';
    }
}
