<?php
/**
 * Created by PhpStorm.
 * User: turegjorup
 * Date: 21/03/2018
 * Time: 12.35
 */

namespace AppBundle\Service;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Concat\Http\Middleware\RateLimitProvider;
use Symfony\Component\Cache\Adapter\TraceableAdapter;


class HarvestRateLimitProvider implements RateLimitProvider {
	private $cache;

	public function __construct( TraceableAdapter $cache_adapter ) {
		$this->cache = $cache_adapter;
	}

	/**
	 * Returns when the last request was made.
	 *
	 * @return float|null When the last request was made.
	 */
	public function getLastRequestTime() {
		$lastRequestTimeCache = $this->cache->getItem('harvest.last_request_time');
		$lastRequestTime = $lastRequestTimeCache->isHit() ? $lastRequestTimeCache->get() : null;

		return $lastRequestTime;
	}

	/**
	 * Used to set the current time as the last request time to be queried when
	 * the next request is attempted.
	 */
	public function setLastRequestTime() {
		$lastRequestTimeCache = $this->cache->getItem('harvest.last_request_time');
		$lastRequestTimeCache->set(microtime( true ));

		return $this->cache->save($lastRequestTimeCache);
	}

	/**
	 * Returns what is considered the time when a given request is being made.
	 *
	 * @param RequestInterface $request The request being made.
	 *
	 * @return float Time when the given request is being made.
	 */
	public function getRequestTime( RequestInterface $request ) {
		return microtime( true );
	}

	/**
	 * Returns the minimum amount of time that is required to have passed since
	 * the last request was made. This value is used to determine if the current
	 * request should be delayed, based on when the last request was made.
	 *
	 * Returns the allowed time between the last request and the next, which
	 * is used to determine if a request should be delayed and by how much.
	 *
	 * @param RequestInterface $request The pending request.
	 *
	 * @return float The minimum amount of time that is required to have passed
	 *               since the last request was made (in microseconds).
	 */
	public function getRequestAllowance( RequestInterface $request ) {

		// Harvest have an API throttle that blocks accounts emitting more than 100 requests per 15 seconds.
		// https://help.getharvest.com/api-v2/introduction/overview/general/#rate-limiting

		// The doc says to return in microseconds, the code says seconds :-/
		return 0.15;
		//return (float) 150000;
	}

	/**
	 * Used to set the minimum amount of time that is required to pass between
	 * this request and the next request.
	 *
	 * @param ResponseInterface $response The resolved response.
	 */
	public function setRequestAllowance( ResponseInterface $response ) {
	}
}