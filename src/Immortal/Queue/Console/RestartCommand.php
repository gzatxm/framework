<?php

namespace Immortal\Queue\Console;

use Carbon\Carbon;
use Immortal\Console\Command;

class RestartCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'queue:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart queue worker daemons after their current job';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->zgutu['cache']->forever('immortal:queue:restart', Carbon::now()->getTimestamp());

        $this->info('Broadcasting queue restart signal.');
    }
}
