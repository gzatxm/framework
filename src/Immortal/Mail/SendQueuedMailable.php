<?php

namespace Immortal\Mail;

use Immortal\Contracts\Mail\Mailer as MailerContract;
use Immortal\Contracts\Mail\Mailable as MailableContract;

class SendQueuedMailable
{
    /**
     * The mailable message instance.
     *
     * @var Mailable
     */
    protected $mailable;

    /**
     * Create a new job instance.
     *
     * @param  \Immortal\Contracts\Mail\Mailable  $mailable
     * @return void
     */
    public function __construct(MailableContract $mailable)
    {
        $this->mailable = $mailable;
    }

    /**
     * Handle the queued job.
     *
     * @param  \Immortal\Contracts\Mail\Mailer  $mailer
     * @return void
     */
    public function handle(MailerContract $mailer)
    {
        $mailer->send($this->mailable);
    }
}
