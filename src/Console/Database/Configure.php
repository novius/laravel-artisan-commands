<?php

namespace Novius\ArtisanCommands\Console\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Configure extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the database configuration';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:configure';

    /**
     * Reset database configuration.
     */
    public function handle()
    {
        $dbName = 'lara_'.Str::slug(basename(base_path()), '_');

        $replaces = [
            'lara_base_xxx' => $dbName,
            'lara_user_xxx' => mb_substr($dbName, 0, 16),
            'lara_pass_xxx' => Str::random(20),
        ];

        $this->writeFile('.env', $replaces);
        $this->writeFile('config/database.php', $replaces);

        $this->info('DB successfully configured.');
    }

    protected function writeFile(string $relativeFilepath, array $replaces)
    {
        $filepath = base_path().'/'.$relativeFilepath;
        file_put_contents($filepath, strtr(
            file_get_contents($filepath),
            $replaces
        ));
    }
}
