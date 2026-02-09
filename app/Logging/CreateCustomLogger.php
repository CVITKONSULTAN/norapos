<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

class CreateCustomLogger
{
    /**
     * Create a custom Monolog instance with proper permissions.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger('daily');
        
        $handler = new RotatingFileHandler(
            $config['path'],
            $config['days'] ?? 7,
            $config['level'] ?? Logger::DEBUG,
            $config['bubble'] ?? true,
            $config['permission'] ?? 0664,
            $config['locking'] ?? false
        );
        
        $logger->pushHandler($handler);
        
        return $logger;
    }
}
