<?php

namespace Immortal\Queue\Jobs;

use Immortal\Support\Arr;
use Immortal\Queue\RedisQueue;
use Immortal\Container\Container;
use Immortal\Contracts\Queue\Job as JobContract;

class RedisJob extends Job implements JobContract
{
    /**
     * The Redis queue instance.
     *
     * @var \Immortal\Queue\RedisQueue
     */
    protected $redis;

    /**
     * The Redis raw job payload.
     *
     * @var string
     */
    protected $job;

    /**
     * The JSON decoded version of "$job".
     *
     * @var array
     */
    protected $decoded;

    /**
     * The Redis job payload inside the reserved queue.
     *
     * @var string
     */
    protected $reserved;

    /**
     * Create a new job instance.
     *
     * @param  \Immortal\Container\Container  $container
     * @param  \Immortal\Queue\RedisQueue  $redis
     * @param  string  $job
     * @param  string  $reserved
     * @param  string  $queue
     */
    public function __construct(Container $container, RedisQueue $redis, $job, $reserved, $queue)
    {
        $this->job = $job;
        $this->redis = $redis;
        $this->queue = $queue;
        $this->reserved = $reserved;
        $this->container = $container;
        $this->decoded = $this->payload();
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->job;
    }

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        parent::delete();

        $this->redis->deleteReserved($this->queue, $this->reserved);
    }

    /**
     * Release the job back into the queue.
     *
     * @param  int   $delay
     * @return void
     */
    public function release($delay = 0)
    {
        parent::release($delay);

        $this->redis->deleteAndRelease($this->queue, $this->reserved, $delay);
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return Arr::get($this->decoded, 'attempts');
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return Arr::get($this->decoded, 'id');
    }

    /**
     * Get the underlying queue driver instance.
     *
     * @return \Immortal\Redis\Database
     */
    public function getRedisQueue()
    {
        return $this->redis;
    }

    /**
     * Get the underlying reserved Redis job.
     *
     * @return string
     */
    public function getReservedJob()
    {
        return $this->reserved;
    }
}
