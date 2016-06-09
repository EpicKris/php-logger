<?php

namespace EpicKris\Loggers;

use Psr\Log\AbstractLogger;

/**
 * Amazon CloudWatch logger.
 *
 * @package EpicKris\Loggers
 */
class AmazonCloudWatchLogger extends AbstractLogger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param string $level   Level.
     * @param string $message Message.
     * @param array  $context Context.
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}
