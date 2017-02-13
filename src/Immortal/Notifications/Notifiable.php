<?php

namespace Immortal\Notifications;

trait Notifiable
{
    use HasDatabaseNotifications, RoutesNotifications;
}
