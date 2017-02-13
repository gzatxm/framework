<?php

namespace Immortal\Contracts\Support;

interface MessageProvider
{
    /**
     * Get the messages for the instance.
     *
     * @return \Immortal\Contracts\Support\MessageBag
     */
    public function getMessageBag();
}
