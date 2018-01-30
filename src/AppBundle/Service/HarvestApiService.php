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

class HarvestApiService extends BaseApiService {

	const API_BASE_PATH = '/api/v2/';

    public function __construct(Client $client, EntityManager $em)
    {
    	parent::__construct($client, $em);
    }

    public function update() {
    	$this->clearSeenOnlastSync();
    	$this->updateAllEndpoints();
    	$this->removeDeleted();
    }

    private function updateAllEndpoints() {
    	$endpoints = [
    		'users' => 'AppBundle:Harvest\User',
    		'clients' => 'AppBundle:Harvest\Client',
    		'projects' => 'AppBundle:Harvest\Project',
    		'tasks' => 'AppBundle:Harvest\Task',
	    ];

    	foreach ($endpoints as $endpoint => $entityName) {
    		$this->updateEndpoint(self::API_BASE_PATH.$endpoint, $endpoint, $entityName);
	    }

	    $projects = $this->em->getRepository('AppBundle:Harvest\Project')->findAll();
	    foreach ($projects as $project) {
		    $this->updateEndpoint(self::API_BASE_PATH.'projects/'.$project->getId().'/task_assignments', 'task_assignments', 'AppBundle:Harvest\TaskAssignment');
		    $this->updateEndpoint(self::API_BASE_PATH.'projects/'.$project->getId().'/user_assignments', 'user_assignments', 'AppBundle:Harvest\UserAssignment');
	    }

	    $users = $this->em->getRepository('AppBundle:Harvest\User')->findAll();
	    foreach ($users as $user) {
		    $this->updateEndpoint(self::API_BASE_PATH.'users/'.$user->getId().'/project_assignments', 'project_assignments', 'AppBundle:Harvest\ProjectAssignment');
	    }

	    $endpoints = [
		    'invoices' => 'AppBundle:Harvest\Invoice',
		    'time_entries' => 'AppBundle:Harvest\TimeEntry',
	    ];

	    foreach ($endpoints as $endpoint => $entityName) {
		    $this->updateEndpoint(self::API_BASE_PATH.$endpoint, $endpoint, $entityName);
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
		}
    }

}