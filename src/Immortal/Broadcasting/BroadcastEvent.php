<?php

namespace Immortal\Broadcasting;

use ReflectionClass;
use ReflectionProperty;
use Immortal\Contracts\Queue\Job;
use Immortal\Contracts\Support\Arrayable;
use Immortal\Contracts\Broadcasting\Broadcaster;

class BroadcastEvent
{
    /**
     * The broadcaster implementation.
     *
     * @var \Immortal\Contracts\Broadcasting\Broadcaster
     */
    protected $broadcaster;

    /**
     * Create a new job handler instance.
     *
     * @param  \Immortal\Contracts\Broadcasting\Broadcaster  $broadcaster
     * @return void
     */
    public function __construct(Broadcaster $broadcaster)
    {
        $this->broadcaster = $broadcaster;
    }

    /**
     * Handle the queued job.
     *
     * @param  \Immortal\Contracts\Queue\Job  $job
     * @param  array  $data
     * @return void
     */
    public function fire(Job $job, array $data)
    {
        $event = unserialize($data['event']);

        $name = method_exists($event, 'broadcastAs')
                ? $event->broadcastAs() : get_class($event);

        $channels = $event->broadcastOn();

        if (! is_array($channels)) {
            $channels = [$channels];
        }

        $this->broadcaster->broadcast(
            $channels, $name, $this->getPayloadFromEvent($event)
        );

        $job->delete();
    }

    /**
     * Get the payload for the given event.
     *
     * @param  mixed  $event
     * @return array
     */
    protected function getPayloadFromEvent($event)
    {
        if (method_exists($event, 'broadcastWith')) {
            return array_merge(
                $event->broadcastWith(), ['socket' => data_get($event, 'socket')]
            );
        }

        $payload = [];

        foreach ((new ReflectionClass($event))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $payload[$property->getName()] = $this->formatProperty($property->getValue($event));
        }

        return $payload;
    }

    /**
     * Format the given value for a property.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function formatProperty($value)
    {
        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        return $value;
    }
}
