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
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use JsonPath\JsonObject;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationReader;

abstract class BaseApiService
{
	protected $em;
	private $client;

	public function __construct(Client $client, EntityManager $em)
	{
		$this->client = $client;
		$this->em = $em;
	}

	protected function updateEndpoint(string $apiPath, string $jsonPath, string $entityName) {
		$res = $this->getPagedData($this->client, $apiPath, $jsonPath, 'links.next');
		$this->updateEntities($entityName, $res['records']);

		if(!empty($res['nextUrl'])) {
			$this->updateEndpoint($res['nextUrl'], $jsonPath, $entityName);
		}
	}

    protected function getPagedData($client, $next_url, $records_path, $next_url_path)
    {
        if ( ! empty($next_url)) {
            try {
                $response = $client->get($next_url);
            } catch (RequestException $e) {
                echo Psr7\str($e->getRequest());
                if ($e->hasResponse()) {
                    echo Psr7\str($e->getResponse());
                }
                throw new \Exception('Network Error retrieving: '.$next_url);
            }

            // https://github.com/8p/GuzzleBundle/issues/48
            $response->getBody()->rewind();

            $content = new JsonObject($response->getBody()->getContents());
            $res['records'] = $content->get('$.'.$records_path.'[*]');
            $res['nextUrl'] = $content->get('$.'.$next_url_path)[0];

            return $res;
        }

        throw new \Exception('$next_url cannot be empty');
    }

    protected function updateEntities($entityName, $records) {
		$ids = array_column($records, 'id');
		$result = $this->em->getRepository( $entityName )->findBy( ['id' => $ids] );

		$entities = [];
		foreach ($result as $item) {
			$entities[$item->getId()] = $item;
		}

	    foreach ( $records as $record ) {
		    $entity = array_key_exists($record['id'], $entities) ? $entities[$record['id']] : null;

		    if ( ! $entity ) {
			    $entityInfo = $this->em->getClassMetadata( $entityName );
			    $entity     = $entityInfo->newInstance();
		    }

		    $this->updateEntity( $entity, $record );
		    $this->em->persist( $entity );
	    }

	    $this->em->flush();
    }

    protected function updateEntity($entity, $data)
    {
        $accessor  = PropertyAccess::createPropertyAccessor();
        $reflect   = new \ReflectionClass($entity);
        $docReader = new AnnotationReader();

        foreach ($data as $prop => $value) {
            $prop = $this->convertToCamelCase($prop);

            if ($value && $reflect->hasProperty($prop) && $accessor->isWritable($entity, $prop)) {
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
                			$col->add($this->em->getRepository($docInfos[0]->targetEntity)->find($v['id']));
		                }
		                $value = $col;
	                } elseif(property_exists($docInfos[0], 'inversedBy')) {
                	    $value = $this->em->getRepository($docInfos[0]->targetEntity)->find($value['id']);
	                } else {
                		throw new \Exception("Unknown relation type. Mapping failed");
	                }
                }

                $accessor->setValue($entity, $prop, $value);
            }
        }

	    if($accessor->isWritable($entity, 'seenOnLastSync')) {
		    $accessor->setValue($entity, 'seenOnLastSync', true);
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

}