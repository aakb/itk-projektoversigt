<?php

namespace AppBundle\Command;

use AppBundle\Entity\Harvest\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use Exception;
use ReflectionClass;
use Doctrine\Common\Annotations\AnnotationReader;

use AppBundle\Service\HarvestApiService;

class ReadHarvestCommand extends ContainerAwareCommand {

	private $harvestApiService;

	public function __construct( HarvestApiService $harvestApiService ) {
		parent::__construct();
		$this->harvestApiService = $harvestApiService;
	}

	protected function configure() {
		$this
			// the name of the command (the part after "bin/console")
			->setName( 'app:harvest:update' )
			// the short description shown while running "php bin/console list"
			->setDescription( 'Update All Harvest Data' )
			// the full command description shown when running the command with
			// the "--help" option
			->setHelp( "This command updates all data from Harvest via the Harvest v2 API" );
	}

	protected function execute( InputInterface $input, OutputInterface $output ) {

		$this->harvestApiService->update( $output );

	}


}