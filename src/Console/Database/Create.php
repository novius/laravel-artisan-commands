<?php

namespace Novius\ArtisanCommands\Console\Database;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Create extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the database if not exists';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {--connection=}';

    /**
     * Database connection name.
     *
     * @var string
     */
    protected $connectionName;

    /**
     * Try to create the database. We use "--connection" option to find database connection configuration.
     *
     * @return mixed
     */
    public function handle()
    {
        // "--connection" option is required for now
        $this->connectionName = $this->option('connection');
        if ($this->connectionName === null) {
            return $this->error('Missing required option: --connection');
        }

        // Does this database connection configuration exist?
        if (! config()->has($this->databaseConfigName())) {
            return $this->error('Connection "'.$this->connectionName.'" isn\'t defined into config/database.php');
        }

        // Check database name validity
        $databaseName = config($this->databaseConfigName());
        if (! preg_match('`^\w+$`', $databaseName)) {
            return $this->error($databaseName.' isn\'t a valid database name.');
        }

        // Create Database using PDO (we can't use Migration for this, and we can't use binding for database name)
        // We have to clear database name config (and rollback it then), otherwise DB::unprepared() tries to connect
        // (and throw an "Unknown database" error)
        $this->changeDatabaseName('');
        $sqlExec = DB::unprepared('CREATE DATABASE IF NOT EXISTS '.(string) $databaseName);
        $this->changeDatabaseName($databaseName);

        return $sqlExec;
    }

    /**
     * Dynamicaly change "database" key into database config, and rebound "db".
     *
     * @param $databaseName string
     * @return void
     */
    protected function changeDatabaseName(string $databaseName)
    {
        config()->set($this->databaseConfigName(), $databaseName);

        // We have to rebound singleton, otherwise config isn't reloaded
        App::singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });
    }

    /**
     * Return complete database connection config name, using $this->connectionName.
     *
     * @return string
     */
    protected function databaseConfigName() : string
    {
        return 'database.connections.'.$this->connectionName.'.database';
    }
}
