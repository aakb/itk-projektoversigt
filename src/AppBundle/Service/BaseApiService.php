<?php
/**
 * Created by PhpStorm.
 * User: turegjorup
 * Date: 24/01/2018
 * Time: 16.16
 */

namespace AppBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Handler\CurlHandler;
use Concat\Http\Middleware\RateLimiter;
use Psr\Http\Message\ResponseInterface;

use JsonPath\JsonObject;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;

abstract class BaseApiService
{
	protected $em;
	protected $client;
	protected $handlerStack;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;

		$this->handlerStack = HandlerStack::create(new CurlHandler());
		$this->handlerStack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));
	}

	protected function updateEndpoint(string $accountName, string $apiPath, string $jsonPath, string $nextUrlPath, string $pageNumberPath, string $totalPageNumberPath, string $entityName, ProgressBar $progressBar = null) {
		$res = $this->getPagedData($this->client, $apiPath, $jsonPath, $nextUrlPath, $pageNumberPath, $totalPageNumberPath);
		$this->updateEntities($entityName, $res['records'], $accountName);

		if($res['totalPageNumber'] > 1) {
			$client = $this->client;
			$pageUrls = [];

			for($page = 2; $page <= $res['totalPageNumber']; $page++ ) {
				$pageUrls[] = $apiPath.'?'.$pageNumberPath.'='.$page;
			}

			$requests = function($pageUrls) use ($client) {
				foreach ($pageUrls as $url) {
					yield $client->getAsync($url);
				}
			};

			$total = $res['totalPageNumber'];
			$page = 2;

			/** @var PromiseInterface $p */
			$p = \GuzzleHttp\Promise\each_limit(
				$requests($pageUrls),
				20,
				function(ResponseInterface $response, $index) use (&$page, $total, $jsonPath, $entityName, $progressBar, $accountName) {
					// https://github.com/8p/GuzzleBundle/issues/48
					$response->getBody()->rewind();

					$content = new JsonObject($response->getBody()->getContents());
					$records = $content->get( '$.' . $jsonPath . '[*]');

					$this->updateEntities($entityName, $records, $accountName);

					if($progressBar) {
						$progressBar->advance();
						$progressBar->setMessage($accountName . ': ' . $jsonPath . ': ' . $page . '/' . $total . ' pages fetched.' );
					}

					$page++;
				},
				function($reason, $index) use (&$page, $total, $jsonPath, $entityName, $progressBar, $accountName) {
					$page++;

					$progressBar->setMessage( $accountName . ': ' . $jsonPath . ': ' . $page . '/' . $total . ' pages failed.' );
				}
			);
			$p->wait();
		}

	}

    protected function getPagedData($client, $nextUrl, $recordsPath, $nextUrlPath, $pageNumberPath, $totalPageNumberPath)
    {
        if ( ! empty($nextUrl)) {
            try {
                $response = $client->get($nextUrl);
            } catch (RequestException $e) {
                echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
                throw new \Exception( 'Network Error retrieving: ' . $nextUrl);
            }

            // https://github.com/8p/GuzzleBundle/issues/48
            $response->getBody()->rewind();

            $content = new JsonObject($response->getBody()->getContents());
            $res['records'] = $content->get( '$.' . $recordsPath . '[*]');
            $res['nextUrl'] = $content->get( '$.' . $nextUrlPath)[0];
            $res['pageNumber'] = $content->get( '$.' . $pageNumberPath)[0];
            $res['totalPageNumber'] = $content->get( '$.' . $totalPageNumberPath)[0];

            return $res;
        }

        throw new \Exception('$next_url cannot be empty');
    }

    protected function updateEntities($entityName, $records, $accountName) {
	    $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

		if(is_array($records)) {
			$ids    = array_column( $records, 'id' );
			$result = $this->em->getRepository( $entityName )->findBy( [ 'id' => $ids, 'ownedBy' => $accountName ] );

			$entities = [];
			foreach ( $result as $item ) {
				$entities[ $item->getId() ] = $item;
			}

			foreach ( $records as $record ) {
				$entity = array_key_exists( $record['id'], $entities ) ? $entities[ $record['id'] ] : null;

				if ( ! $entity ) {
					$entityInfo = $this->em->getClassMetadata( $entityName );
					$entity     = $entityInfo->newInstance();
				}

				$this->updateEntity( $entity, $record, $accountName );
				$this->em->persist( $entity );
			}

			$this->em->flush();
			$this->em->clear();
		}
    }

    protected function updateEntity($entity, $data, $accountName)
    {
        $accessor  = PropertyAccess::createPropertyAccessor();
        $reflect   = new \ReflectionClass($entity);
        $docReader = new AnnotationReader();

        foreach ($data as $prop => $value) {
            $prop = $this->convertToCamelCase($prop);

            if ($value !== null && $reflect->hasProperty($prop) && $accessor->isWritable($entity, $prop)) {
                $docInfos = $docReader->getPropertyAnnotations($reflect->getProperty($prop));

                if(property_exists($docInfos[0], 'type')) {
	                switch ( $docInfos[0]->type ) {
		                case 'datetime':
		                case 'date':
		                case 'time':
			                $value = new \DateTime( $value );
			                break;

	                }
                } elseif (property_exists($docInfos[0], 'targetEntity')) {
                	if(property_exists($docInfos[0], 'mappedBy')) {
		                $col = new ArrayCollection();
		                foreach ($value as $v) {
		                	$relation = $this->em->getRepository($docInfos[0]->targetEntity)->find($v['id']);
		                	if($relation) {
                			    $col->add($relation);
			                }
		                }
		                $value = empty($col) ? null : $col;
	                } elseif(property_exists($docInfos[0], 'inversedBy')) {
                	    $value = $this->em->getRepository($docInfos[0]->targetEntity)->find($value['id']);
	                } else {
                		throw new \Exception("Unknown relation type. Mapping failed");
	                }
                }

                if($value !== null) {
	                $accessor->setValue($entity, $prop, $value);
                }
            }
        }

	    if($accessor->isWritable($entity, 'seenOnLastSync')) {
		    $accessor->setValue($entity, 'seenOnLastSync', true);
	    }

	    if($accessor->isWritable($entity, 'ownedBy')) {
		    $accessor->setValue($entity, 'ownedBy', $accountName);
	    }
    }

    private function convertToCamelCase($input, $separator = '_', $capitalizeFirstCharacter = false)
    {
        $str = str_replace($separator, '', ucwords($input, $separator));

        if ( ! $capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

	private function retryDecider()
	{
		return function (
			$retries,
			Request $request,
			Response $response = null,
			RequestException $exception = null
		) {
			// Limit the number of retries to 5
			if ($retries >= 5) {
				return false;
			}

			// Retry connection exceptions
			if ($exception instanceof ConnectException) {
				return true;
			}

			if ($response) {
				// Retry for throttled response
				if ($response->getStatusCode() === 429 ) {
					return true;
				}
			}

			return false;
		};
	}

	/**
	 * Retry strategy
	 *
	 * @return Closure
	 */
	private function retryDelay()
	{
		return function (
			$retries,
			Response $response = null,
			RequestException $exception = null
		) {

			if($response->getHeader('Retry-After')) {
				$wait = $response->getHeader('Retry-After')[0];
				$wait = (int) $wait;

				if($wait) {
					return $wait * 1000;
				}
			}

			return $retries * 1000;
		};
	}

}