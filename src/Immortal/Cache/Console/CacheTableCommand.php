<?php

namespace Immortal\Cache\Console;

use Immortal\Console\Command;
use Immortal\Support\Composer;
use Immortal\Filesystem\Filesystem;

class CacheTableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cache:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the cache database table';

    /**
     * The filesystem instance.
     *
     * @var \Immortal\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Immortal\Support\Composer
     */
    protected $composer;

    /**
     * Create a new cache table command instance.
     *
     * @param  \Immortal\Filesystem\Filesystem  $files
     * @param  \Immortal\Support\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $fullPath = $this->createBaseMigration();

        $this->files->put($fullPath, $this->files->get(__DIR__.'/stubs/cache.stub'));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }

    /**
     * Create a base migration file for the table.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_cache_table';

        $path = $this->zgutu->databasePath().'/migrations';

        return $this->zgutu['migration.creator']->create($name, $path);
    }
}
