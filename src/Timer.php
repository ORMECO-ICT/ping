<?php

namespace Acamposm\Ping;

/**
 * Utility Class to control time elapsed in commands
 */
class Timer
{
	/**
	 * Format for the timestamps
	 *
	 * @var  string
	 */
	protected $format = 'd-m-Y H:i:s.u';

	/**
	 * Timer START
	 *
	 * @var  float
	 */
	protected $start;

	/**
	 * Timer END
	 *
	 * @var  float
	 */
	protected $end;

	function __construct()
	{
		$this->start = microtime(true);
	}

	/**
	 * Start the Timer
	 */
	public function Start()
	{
    	$this->start = microtime(true);
	}

	/**
	 * Stop the Timer
	 */
	public function Stop()
	{
		$this->stop = microtime(true);
	}

	/**
	 * Returns an array with the Timer details
	 *
	 * @return  array
	 */
	public function Results(): array
	{      
    	if (!isset($this->stop)) {
			$this->stop = microtime(true);
    	}

        $start = DateTime::createFromFormat('U.u', $this->start);
      
		$stop = DateTime::createFromFormat('U.u', $this->stop);

        $time_elapsed = $this->stop - $this->start;

    	return [
    		'start' => $start->format($this->format),
    		'stop' => $stop->format($this->format),
    		'time' => $time_elapsed
    	];
	}
}