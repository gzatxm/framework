<?php

namespace Immortal\Queue\Connectors;

use Pheanstalk\Pheanstalk;
use Immortal\Support\Arr;
use Pheanstalk\PheanstalkInterface;
use Immortal\Queue\BeanstalkdQueue;

class BeanstalkdConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Immortal\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $pheanstalk = new Pheanstalk($config['host'], Arr::get($config, 'port', PheanstalkInterface::DEFAULT_PORT));

        return new BeanstalkdQueue(
            $pheanstalk, $config['queue'], Arr::get($config, 'retry_after', Pheanstalk::DEFAULT_TTR)
        );
    }
}
