<?php

/**
 * Ping for Laravel.
 *
 * This class makes Ping request to a host.
 *
 * Ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway.
 *
 * @author  Angel Campos <angel.campos.m@outlook.com>
 * @requires PHP 8.0
 *
 * @version  2.1.2
 */

namespace Acamposm\Ping;

use Acamposm\Ping\Exceptions\TimerNotStartedException;
use DateTime;

/**
 * Utility Class to control time elapsed in commands.
 */
class Timer
{
    /**
     * Format for the timestamps.
     */
    public const FORMAT = 'd-m-Y H:i:s.u';

    /**
     * Timer START.
     *
     * @var float
     */
    protected float $start;

    /**
     * Timer END.
     *
     * @var float
     */
    protected float $stop;

    /**
     * Timer constructor.
     */
    public function __construct(protected string $format = self::FORMAT)
    {
        return $this;
    }

    /**
     * Start the Timer.
     *
     * @return float
     */
    public function Start(): float
    {
        return $this->start = microtime(true);
    }

    /**
     * Stop the Timer.
     *
     * @throws TimerNotStartedException
     * @retun  float
     */
    public function Stop(): float
    {
        if (!isset($this->start)) {
            throw new TimerNotStartedException();
        }

        return $this->stop = microtime(true);
    }

    /**
     * Returns an object with the Timer details.
     *
     * @return object
     */
    public function GetResults(): object
    {
        if (!isset($this->stop)) {
            $this->stop = microtime(true);
        }

        return (object) [
            'start' => $this->getTimeObject($this->start),
            'stop'  => $this->getTimeObject($this->stop),
            'time'  => $this->getTimeElapsed(),
        ];
    }

    /**
     * Returns a DateTime instance from timestamp.
     *
     * @param float $timestamp
     *
     * @return DateTime
     */
    private static function getDateTimeObjectFromTimeStamp(float $timestamp): DateTime
    {
        return DateTime::createFromFormat('U.u', $timestamp);
    }

    /**
     * Returns an object with the timestamp as a float and as a human-readable.
     *
     * @param float $timestamp
     *
     * @return object
     */
    private function getTimeObject(float $timestamp): object
    {
        $date_time = self::getDateTimeObjectFromTimeStamp($timestamp);

        return (object) [
            'as_float'       => $timestamp,
            'human_readable' => $date_time->format($this->format),
        ];
    }

    /**
     * Returns the elapsed time between start and stop.
     *
     * @return float
     */
    private function getTimeElapsed(): float
    {
        $time_elapsed = $this->stop - $this->start;

        return round($time_elapsed, 3, PHP_ROUND_HALF_DOWN);
    }
}
