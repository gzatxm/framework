<?php

namespace Immortal\Console;

use Immortal\Container\Container;

trait AppNamespaceDetectorTrait
{
    /**
     * Get the application namespace.
     *
     * @return string
     */
    protected function getAppNamespace()
    {
        return Container::getInstance()->getNamespace();
    }
}
