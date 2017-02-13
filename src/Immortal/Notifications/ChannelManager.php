<?php

namespace Immortal\Notifications;

use Ramsey\Uuid\Uuid;
use InvalidArgumentException;
use Immortal\Support\Manager;
use Nexmo\Client as NexmoClient;
use Immortal\Support\Collection;
use GuzzleHttp\Client as HttpClient;
use Immortal\Database\Eloquent\Model;
use Immortal\Contracts\Queue\ShouldQueue;
use Immortal\Contracts\Bus\Dispatcher as Bus;
use Nexmo\Client\Credentials\Basic as NexmoCredentials;
use Immortal\Database\Eloquent\Collection as ModelCollection;
use Immortal\Contracts\Notifications\Factory as FactoryContract;
use Immortal\Contracts\Notifications\Dispatcher as DispatcherContract;

class ChannelManager extends Manager implements DispatcherContract, FactoryContract
{
    /**
     * The default channel used to deliver messages.
     *
     * @var string
     */
    protected $defaultChannel = 'mail';

    /**
     * Send the given notification to the given notifiable entities.
     *
     * @param  \Immortal\Support\Collection|array|mixed  $notifiables
     * @param  mixed  $notification
     * @return void
     */
    public function send($notifiables, $notification)
    {
        $notifiables = $this->formatNotifiables($notifiables);

        if ($notification instanceof ShouldQueue) {
            return $this->queueNotification($notifiables, $notification);
        }

        return $this->sendNow($notifiables, $notification);
    }

    /**
     * Send the given notification immediately.
     *
     * @param  \Immortal\Support\Collection|array|mixed  $notifiables
     * @param  mixed  $notification
     * @return void
     */
    public function sendNow($notifiables, $notification, array $channels = null)
    {
        $notifiables = $this->formatNotifiables($notifiables);

        $original = clone $notification;

        foreach ($notifiables as $notifiable) {
            $notificationId = Uuid::uuid4()->toString();

            $viaChannels = $channels ?: $notification->via($notifiable);

            if (empty($viaChannels)) {
                continue;
            }

            foreach ($viaChannels as $channel) {
                $notification = clone $original;

                if (! $notification->id) {
                    $notification->id = $notificationId;
                }

                if (! $this->shouldSendNotification($notifiable, $notification, $channel)) {
                    continue;
                }

                $response = $this->driver($channel)->send($notifiable, $notification);

                $this->app->make('events')->fire(
                    new Events\NotificationSent($notifiable, $notification, $channel, $response)
                );
            }
        }
    }

    /**
     * Determines if the notification can be sent.
     *
     * @param  mixed  $notifiable
     * @param  mixed  $notification
     * @param  string  $channel
     * @return bool
     */
    protected function shouldSendNotification($notifiable, $notification, $channel)
    {
        return $this->app->make('events')->until(
            new Events\NotificationSending($notifiable, $notification, $channel)
        ) !== false;
    }

    /**
     * Queue the given notification instances.
     *
     * @param  mixed  $notifiables
     * @param  array[\Immortal\Notifications\Channels\Notification]  $notification
     * @return void
     */
    protected function queueNotification($notifiables, $notification)
    {
        $notifiables = $this->formatNotifiables($notifiables);

        $bus = $this->app->make(Bus::class);

        $original = clone $notification;

        foreach ($notifiables as $notifiable) {
            $notificationId = Uuid::uuid4()->toString();

            foreach ($notification->via($notifiable) as $channel) {
                $notification = clone $original;

                $notification->id = $notificationId;

                $bus->dispatch(
                    (new SendQueuedNotifications($this->formatNotifiables($notifiable), $notification, [$channel]))
                            ->onConnection($notification->connection)
                            ->onQueue($notification->queue)
                            ->delay($notification->delay)
                );
            }
        }
    }

    /**
     * Format the notifiables into a Collection / array if necessary.
     *
     * @param  mixed  $notifiables
     * @return ModelCollection|array
     */
    protected function formatNotifiables($notifiables)
    {
        if (! $notifiables instanceof Collection && ! is_array($notifiables)) {
            return $notifiables instanceof Model
                            ? new ModelCollection([$notifiables]) : [$notifiables];
        }

        return $notifiables;
    }

    /**
     * Get a channel instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create an instance of the database driver.
     *
     * @return \Immortal\Notifications\Channels\DatabaseChannel
     */
    protected function createDatabaseDriver()
    {
        return $this->app->make(Channels\DatabaseChannel::class);
    }

    /**
     * Create an instance of the broadcast driver.
     *
     * @return \Immortal\Notifications\Channels\BroadcastChannel
     */
    protected function createBroadcastDriver()
    {
        return $this->app->make(Channels\BroadcastChannel::class);
    }

    /**
     * Create an instance of the mail driver.
     *
     * @return \Immortal\Notifications\Channels\MailChannel
     */
    protected function createMailDriver()
    {
        return $this->app->make(Channels\MailChannel::class);
    }

    /**
     * Create an instance of the Nexmo driver.
     *
     * @return \Immortal\Notifications\Channels\NexmoSmsChannel
     */
    protected function createNexmoDriver()
    {
        return new Channels\NexmoSmsChannel(
            new NexmoClient(new NexmoCredentials(
                $this->app['config']['services.nexmo.key'],
                $this->app['config']['services.nexmo.secret']
            )),
            $this->app['config']['services.nexmo.sms_from']
        );
    }

    /**
     * Create an instance of the Slack driver.
     *
     * @return \Immortal\Notifications\Channels\SlackWebhookChannel
     */
    protected function createSlackDriver()
    {
        return new Channels\SlackWebhookChannel(new HttpClient);
    }

    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function createDriver($driver)
    {
        try {
            return parent::createDriver($driver);
        } catch (InvalidArgumentException $e) {
            if (class_exists($driver)) {
                return $this->app->make($driver);
            }

            throw $e;
        }
    }

    /**
     * Get the default channel driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->defaultChannel;
    }

    /**
     * Get the default channel driver name.
     *
     * @return string
     */
    public function deliversVia()
    {
        return $this->getDefaultDriver();
    }

    /**
     * Set the default channel driver name.
     *
     * @param  string  $channel
     * @return void
     */
    public function deliverVia($channel)
    {
        $this->defaultChannel = $channel;
    }
}
