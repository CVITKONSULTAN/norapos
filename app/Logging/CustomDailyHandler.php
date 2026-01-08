<?php

namespace App\Logging;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class CustomDailyHandler extends StreamHandler
{
    /**
     * {@inheritdoc}
     */
    protected function write(array $record): void
    {
        parent::write($record);
        
        // Set permission setelah file dibuat
        if ($this->url && file_exists($this->url)) {
            // Set permission ke 664 (rw-rw-r--)
            @chmod($this->url, 0664);
            
            // Set ownership ke www-data:www-data
            @chown($this->url, 'www-data');
            @chgrp($this->url, 'www-data');
        }
    }
}
