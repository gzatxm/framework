<?php

namespace Immortal\Notifications\Channels;

use Immortal\Support\Str;
use Immortal\Contracts\Mail\Mailer;
use Immortal\Contracts\Mail\Mailable;
use Immortal\Notifications\Notification;

class MailChannel
{
    /**
     * The mailer implementation.
     *
     * @var \Immortal\Contracts\Mail\Mailer
     */
    protected $mailer;

    /**
     * Create a new mail channel instance.
     *
     * @param  \Immortal\Contracts\Mail\Mailer  $mailer
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Immortal\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $notifiable->routeNotificationFor('mail')) {
            return;
        }

        $message = $notification->toMail($notifiable);

        if ($message instanceof Mailable) {
            return $message->send($this->mailer);
        }

        $this->mailer->send($message->view, $message->data(), function ($m) use ($notifiable, $notification, $message) {
            $recipients = empty($message->to) ? $notifiable->routeNotificationFor('mail') : $message->to;

            if (! empty($message->from)) {
                $m->from($message->from[0], isset($message->from[1]) ? $message->from[1] : null);
            }

            if (is_array($recipients)) {
                $m->bcc($recipients);
            } else {
                $m->to($recipients);
            }

            if ($message->cc) {
                $m->cc($message->cc);
            }

            if (! empty($message->replyTo)) {
                $m->replyTo($message->replyTo[0], isset($message->replyTo[1]) ? $message->replyTo[1] : null);
            }

            $m->subject($message->subject ?: Str::title(
                Str::snake(class_basename($notification), ' ')
            ));

            foreach ($message->attachments as $attachment) {
                $m->attach($attachment['file'], $attachment['options']);
            }

            foreach ($message->rawAttachments as $attachment) {
                $m->attachData($attachment['data'], $attachment['name'], $attachment['options']);
            }

            if (! is_null($message->priority)) {
                $m->setPriority($message->priority);
            }
        });
    }
}
