<?php

namespace PagamentiOnline\PagOnline;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

trait Logging
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    protected function log($message, $level = LogLevel::DEBUG)
    {
        if ($this->logger) {
            $this->logger->log($level, '[lib unicreditimprese] '.$message);
        }
    }
}
