<?php

namespace Immortal\Foundation\Console;

use Immortal\Contracts\Console\Kernel as KernelContract;

class QueuedJob
{
    /**
     * The kernel instance.
     *
     * @var \Immortal\Contracts\Console\Kernel
     */
    protected $kernel;

    /**
     * Create a new job instance.
     *
     * @param  \Immortal\Contracts\Console\Kernel  $kernel
     * @return void
     */
    public function __construct(KernelContract $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Fire the job.
     *
     * @param  \Immortal\Queue\Jobs\Job  $job
     * @param  array  $data
     * @return void
     */
    public function fire($job, $data)
    {
        call_user_func_array([$this->kernel, 'call'], $data);

        $job->delete();
    }
}
