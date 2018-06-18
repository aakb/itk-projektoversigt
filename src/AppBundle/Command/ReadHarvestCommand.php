<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Lock\Factory;
use Symfony\Component\Lock\Store\SemaphoreStore;
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
			->setHelp( 'This command updates all data from Harvest via the Harvest v2 API' );
	}

	protected function execute( InputInterface $input, OutputInterface $output ) {
        $store = new SemaphoreStore();
        $factory = new Factory($store);

        $lock = $factory->createLock('app-harvest-update');

        if ($lock->acquire()) {
            $this->harvestApiService->update( $output );

            $lock->release();
        } else {
            $output->writeln('This command is already running in another process.');

            return 0;
        }
	}


}