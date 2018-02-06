<?php
/**
 * Created by PhpStorm.
 * User: turegjorup
 * Date: 24/01/2018
 * Time: 16.16
 */

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class HarvestApiService extends BaseApiService {

	const API_BASE_PATH = '/api/v2/';

	private $progressBar;
	private $output;

    public function __construct(Client $client, EntityManager $em)
    {
    	parent::__construct($client, $em);
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

    	$this->updateAllEndpoints();

	    $this->setMessage('Remove all delete entries');
    	$this->removeDeleted();
	    $this->advance();
    }

    private function updateAllEndpoints() {
    	$endpoints = [
    		'users' => 'AppBundle:Harvest\User',
    		'clients' => 'AppBundle:Harvest\Client',
    		'projects' => 'AppBundle:Harvest\Project',
    		'tasks' => 'AppBundle:Harvest\Task',
	    ];

    	foreach ($endpoints as $endpoint => $entityName) {
    		$this->updateEndpoint(self::API_BASE_PATH.$endpoint, $endpoint, 'links.next', 'page', 'total_pages', $entityName, $this->progressBar);

    		$this->advance();
	    }

	    $projects = $this->em->getRepository('AppBundle:Harvest\Project')->findAll();
    	$total = count($projects);
    	$count = 1;
	    foreach ($projects as $project) {
		    $this->setMessage('Updating assignments for: '.$count.'/'.$total.' projects.');
		    $this->updateEndpoint(self::API_BASE_PATH.'projects/'.$project->getId().'/task_assignments', 'task_assignments', 'links.next', 'page',
			    'total_pages','AppBundle:Harvest\TaskAssignment');
		    $this->updateEndpoint(self::API_BASE_PATH.'projects/'.$project->getId().'/user_assignments', 'user_assignments', 'links.next', 'page',
			    'total_pages', 'AppBundle:Harvest\UserAssignment');

		    $this->advance();
		    $count++;
	    }

	    $users = $this->em->getRepository('AppBundle:Harvest\User')->findAll();
	    $total = count($users);
	    $count = 1;
	    foreach ($users as $user) {
		    $this->setMessage('Updating assignments for: '.$count.'/'.$total.' users.');
		    $this->updateEndpoint(self::API_BASE_PATH.'users/'.$user->getId().'/project_assignments', 'project_assignments', 'task_assignments', 'links.next', 'page',
			    'total_pages','AppBundle:Harvest\ProjectAssignment');

		    $this->advance();
		    $count++;
	    }

	    $endpoints = [
		    'invoices' => 'AppBundle:Harvest\Invoice',
		    'time_entries' => 'AppBundle:Harvest\TimeEntry',
	    ];

	    foreach ($endpoints as $endpoint => $entityName) {
		    $this->updateEndpoint(self::API_BASE_PATH.$endpoint, $endpoint, $entityName);

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

//		    $this->advance();
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

//			$this->advance();
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

	private function finnish() {
		if($this->progressBar) {
			$this->progressBar->finnish();
		}
	}

}