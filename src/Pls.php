<?php
namespace Alonexy\Pls;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class PlogStore
{
    protected $levelMap = [
        Logger::DEBUG => 'debug',
        Logger::INFO => 'info',
        Logger::NOTICE => 'notice',
        Logger::WARNING => 'warning',
        Logger::ERROR => 'error',
        Logger::CRITICAL => 'critical',
        Logger::ALERT => 'alert',
        Logger::EMERGENCY => 'emergency',
    ];
    protected $timeOut = 10;

    public function __construct()
    {

    }

    /**
     * @param int $seconds
     * @return $this
     */
    public function setTimeout(int $seconds)
    {
        $this->timeOut = $seconds;
        return $this;
    }

    public function logStore($serviceName, $Message, array $Contexts, array $extra = [], $LogLevel = Logger::INFO)
    {
        try {
            if (!isset($this->levelMap[$LogLevel])) {
                throw new \Exception("LogLevel Not Found.");
            }
            $pipe       = "/tmp/phplog_pipe";
            $pipeActive = "/tmp/phplog_active_time";
            if (!file_exists($pipeActive)) {
                throw new \Exception("PipeActiveTimeFile Not Exists.");
            }
            if (!file_exists($pipe)) {
                throw new \Exception("Pipe Not Exists.");
            }
            $ActiveTime = @file_get_contents($pipeActive);
            //大于5s
            if (bcsub(time(), $ActiveTime) > $this->timeOut) {
                throw new \Exception("pipe 激活时间超过{$this->timeOut}");
            }
            else {
                pcntl_signal(
                    SIGALRM, function ($sign) {
                    throw new \Exception("fopen : pcntl_signal[{$sign}] open  pipe Timeout 1.");
                }, false);
                pcntl_alarm(1);
                $handle = @fopen($pipe, "w");
                if ($handle === false) {
                    throw new \Exception("fopen : open  pipe Failed 2.");
                }
                if ($handle) {
                    pcntl_alarm(0);
                    $logger     = new Logger("{$serviceName}", []);
                    $LogHandler = new PipeStreamHandler($handle, Logger::DEBUG);
                    $logger->pushHandler($LogHandler);
                    $logger->pushProcessor(
                        function ($record) use ($extra) {
                            $record['extra'] = $extra;
                            return $record;
                        });
                    $func = $this->levelMap[$LogLevel];
                    $logger->$func($Message, $Contexts);
//                    var_dump("SUCC=>  ".$Message.PHP_EOL);
                    fclose($handle);
                }
            }
        }
        catch (\Exception $e) {
            $localLogger     = new Logger("{$serviceName}", []);
            $localHandle     = fopen("/tmp/php_local_logs/{$serviceName}", "a+");
            $localLogHandler = new StreamHandler($localHandle, Logger::DEBUG);
            $localLogger->pushHandler($localLogHandler);
            $func = $this->levelMap[$LogLevel];
            $localLogger->$func($Message, $Contexts);
            fclose($localHandle);
        }

    }
}