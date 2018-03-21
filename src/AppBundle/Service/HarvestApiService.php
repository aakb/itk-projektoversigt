<?php
/**
 * Created by PhpStorm.
 * User: turegjorup
 * Date: 24/01/2018
 * Time: 16.16
 */

namespace AppBundle\Service;

use Concat\Http\Middleware\RateLimiter;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class HarvestApiService extends BaseApiService {

	const API_BASE_PATH = '/api/v2/';

	private $progressBar;
	private $output;
	private $accounts;
	private $baseUrl;
	private $userAgentHeader;
	private $rateLimitProvider;

    public function __construct(HarvestRateLimitProvider $rateLimitProvider, EntityManager $em, array $accounts, string $baseUrl, string $userAgentHeader)
    {
    	parent::__construct($em);
    	$this->accounts = $accounts;
    	$this->userAgentHeader = $userAgentHeader;
		$this->baseUrl = $baseUrl;
		$this->rateLimitProvider = $rateLimitProvider;
    }

    public function update(OutputInterface $output = null) {
    	$this->output = $output;

    	if($output) {
		    $this->progressBar = new ProgressBar($output);
		    $this->progressBar->setFormat('%bar% %elapsed% (%memory%) - %message%');
		    $this->setMessage('Starting');
		    $this->progressBar->start();
	    }

	    $this->setMessage('Starting...');
		$this->clearSeenOnlastSync();
	    $this->advance();

	    $this->updateAllAccounts();

	    $this->setMessage('Remove all deleted entries');
    	$this->removeDeleted();
	    $this->finish();
    }

    private function updateAllAccounts() {
		foreach ($this->accounts as $name => $account) {
			$headers = [
				'Authorization' => $account['token'],
				'Harvest-Account-Id' => $account['id'],
				'Accept' => 'application/json',
				'User-Agent' => $this->userAgentHeader
			];

			$this->handlerStack->push(new RateLimiter($this->rateLimitProvider));

			$this->client = new Client(array('base_uri' => $this->baseUrl, 'headers' => $headers, 'handler' => $this->handlerStack));
			$this->updateAllEndpoints($name);
		}
    }

    private function updateAllEndpoints(string $accountName) {
    	$endpoints = [
    		'users' => 'AppBundle:Harvest\User',
    		'clients' => 'AppBundle:Harvest\Client',
    		'projects' => 'AppBundle:Harvest\Project',
    		'tasks' => 'AppBundle:Harvest\Task',
	    ];

    	foreach ($endpoints as $endpoint => $entityName) {
    		$this->updateEndpoint($accountName, self::API_BASE_PATH . $endpoint, $endpoint, 'links.next', 'page', 'total_pages', $entityName, $this->progressBar);

    		$this->advance();
	    }

	    $projects = $this->em->getRepository('AppBundle:Harvest\Project')->findBy( ['ownedBy' => $accountName ] );
    	$total = count($projects);
    	$count = 1;
	    foreach ($projects as $project) {
		    $this->setMessage($accountName.': Updating assignments for: '.$count.'/'.$total.' projects.');
		    $this->updateEndpoint($accountName, self::API_BASE_PATH.'projects/'.$project->getId().'/task_assignments', 'task_assignments', 'links.next', 'page',
			    'total_pages','AppBundle:Harvest\TaskAssignment');
		    $this->updateEndpoint($accountName, self::API_BASE_PATH.'projects/'.$project->getId().'/user_assignments', 'user_assignments', 'links.next', 'page',
			    'total_pages', 'AppBundle:Harvest\UserAssignment');

		    $this->advance();
		    $count++;
	    }

	    $users = $this->em->getRepository('AppBundle:Harvest\User')->findBy( ['ownedBy' => $accountName ] );
	    $total = count($users);
	    $count = 1;
	    foreach ($users as $user) {
		    $this->setMessage($accountName.': Updating assignments for: '.$count.'/'.$total.' users.');
		    $this->updateEndpoint($accountName, self::API_BASE_PATH . 'users/' . $user->getId() . '/project_assignments', 'project_assignments','links.next', 'page',
			    'total_pages', 'AppBundle:Harvest\ProjectAssignment', $this->progressBar);

		    $this->advance();
		    $count++;
	    }

	    $endpoints = [
		    'invoices' => 'AppBundle:Harvest\Invoice',
		    'time_entries' => 'AppBundle:Harvest\TimeEntry',
	    ];

	    foreach ($endpoints as $endpoint => $entityName) {
		    $this->updateEndpoint($accountName, self::API_BASE_PATH . $endpoint, $endpoint, 'links.next', 'page', 'total_pages', $entityName, $this->progressBar);

		    $this->advance();
	    }
    }

    private function clearSeenOnlastSync() {
	    $entityNames = [
		    'AppBundle:Harvest\TimeEntry',
		    'AppBundle:Harvest\Invoice',
		    'AppBundle:Harvest\ProjectAssignment',
		    'AppBundle:Harvest\UserAssignment',
		    'AppBundle:Harvest\TaskAssignment',
		    'AppBundle:Harvest\Task',
		    'AppBundle:Harvest\Project',
		    'AppBundle:Harvest\Client',
		    'AppBundle:Harvest\User',
	    ];

	    foreach ($entityNames as $entityName) {
	        $this->em->getRepository( $entityName )->clearSeenOnLastSync();

		    $this->advance();
	    }
    }

    private function removeDeleted() {
		$entityNames = [
			'AppBundle:Harvest\TimeEntry',
			'AppBundle:Harvest\Invoice',
			'AppBundle:Harvest\ProjectAssignment',
			'AppBundle:Harvest\UserAssignment',
			'AppBundle:Harvest\TaskAssignment',
			'AppBundle:Harvest\Task',
			'AppBundle:Harvest\Project',
			'AppBundle:Harvest\Client',
			'AppBundle:Harvest\User',
		];

		foreach ($entityNames as $entityName) {
	        $this->em->getRepository( $entityName )->deleteAllNotSeenOnLastSync();

			$this->advance();
		}
    }


	private function setMessage(string $message) {
		if($this->progressBar) {
			$this->progressBar->setMessage($message);
		}
	}

    private function advance() {
    	if($this->progressBar) {
    		$this->progressBar->advance();
	    }
    }

	private function finish() {
		if($this->progressBar) {
			$this->progressBar->finish();
		}
	}

}