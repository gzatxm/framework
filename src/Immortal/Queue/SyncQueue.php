<?php

namespace Immortal\Queue;

use Exception;
use Throwable;
use Immortal\Queue\Jobs\SyncJob;
use Immortal\Contracts\Queue\Job;
use Immortal\Contracts\Queue\Queue as QueueContract;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class SyncQueue extends Queue implements QueueContract
{
    /**
     * Get the size of the queue.
     *
     * @param  string  $queue
     * @return int
     */
    public function size($queue = null)
    {
        return 0;
    }

    /**
     * Push a new job onto the queue.
     *
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return mixed
     *
     * @throws \Exception|\Throwable
     */
    public function push($job, $data = '', $queue = null)
    {
        $queueJob = $this->resolveJob($this->createPayload($job, $data, $queue), $queue);

        try {
            $this->raiseBeforeJobEvent($queueJob);

            $queueJob->fire();

            $this->raiseAfterJobEvent($queueJob);
        } catch (Exception $e) {
            $this->handleSyncException($queueJob, $e);
        } catch (Throwable $e) {
            $this->handleSyncException($queueJob, new FatalThrowableError($e));
        }

        return 0;
    }

    /**
     * Handle an exception that occurred while processing a job.
     *
     * @param  \Immortal\Queue\Jobs\Job  $queueJob
     * @param  \Exception  $e
     * @return void
     *
     * @throws \Exception
     */
    protected function handleSyncException($queueJob, $e)
    {
        $this->raiseExceptionOccurredJobEvent($queueJob, $e);

        $this->handleFailedJob($queueJob, $e);

        throw $e;
    }

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string  $payload
     * @param  string  $queue
     * @param  array   $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        //
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTime|int  $delay
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        return $this->push($job, $data, $queue);
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param  string  $queue
     * @return \Immortal\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        //
    }

    /**
     * Resolve a Sync job instance.
     *
     * @param  string  $payload
     * @param  string  $queue
     * @return \Immortal\Queue\Jobs\SyncJob
     */
    protected function resolveJob($payload, $queue)
    {
        return new SyncJob($this->container, $payload, $queue);
    }

    /**
     * Raise the before queue job event.
     *
     * @param  \Immortal\Contracts\Queue\Job  $job
     * @return void
     */
    protected function raiseBeforeJobEvent(Job $job)
    {
        if ($this->container->bound('events')) {
            $this->container['events']->fire(new Events\JobProcessing('sync', $job));
        }
    }

    /**
     * Raise the after queue job event.
     *
     * @param  \Immortal\Contracts\Queue\Job  $job
     * @return void
     */
    protected function raiseAfterJobEvent(Job $job)
    {
        if ($this->container->bound('events')) {
            $this->container['events']->fire(new Events\JobProcessed('sync', $job));
        }
    }

    /**
     * Raise the exception occurred queue job event.
     *
     * @param  \Immortal\Contracts\Queue\Job  $job
     * @param  \Exception  $e
     * @return void
     */
    protected function raiseExceptionOccurredJobEvent(Job $job, $e)
    {
        if ($this->container->bound('events')) {
            $this->container['events']->fire(new Events\JobExceptionOccurred('sync', $job, $e));
        }
    }

    /**
     * Handle the failed job.
     *
     * @param  \Immortal\Contracts\Queue\Job  $job
     * @param  \Exception  $e
     * @return array
     */
    protected function handleFailedJob(Job $job, $e)
    {
        $job->failed($e);

        $this->raiseFailedJobEvent($job, $e);
    }

    /**
     * Raise the failed queue job event.
     *
     * @param  \Immortal\Contracts\Queue\Job  $job
     * @param  \Exception  $e
     * @return void
     */
    protected function raiseFailedJobEvent(Job $job, $e)
    {
        if ($this->container->bound('events')) {
            $this->container['events']->fire(new Events\JobFailed('sync', $job, $e));
        }
    }
}
