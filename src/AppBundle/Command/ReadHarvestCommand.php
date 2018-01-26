<?php

namespace AppBundle\Command;

use AppBundle\Entity\Harvest\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
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

class ReadHarvestCommand extends ContainerAwareCommand
{

    private $harvestApiService;

    public function __construct(HarvestApiService $harvestApiService)
    {
        parent::__construct();
        $this->harvestApiService = $harvestApiService;
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:harvest:update')
            // the short description shown while running "php bin/console list"
            ->setDescription('Update All Harvest Data')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command updates all data from Harvest via the Harvest v2 API");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->harvestApiService->update();

//        $em = $this->getContainer()->get('doctrine')->getManager();
//
//        // get Guzzle Client
//        $this->client = $this->getContainer()->get('eight_points_guzzle.client.harvest_api');
//
//        $userData = $this->getPagedData('/api/v2/users/');
//
//        foreach ($userData as $userDatum) {
//            $user = $this->getContainer()->get('doctrine')
//                         ->getRepository(User::class)
//                         ->find($userDatum->id);
//
//            if(!$user) {
//                $user = new User();
//            }
//
//            $this->updateEntity($user, $userDatum);
//            $em->persist($user);
//        }
//
//        $em->flush();

        //$output->writeln('<info>'.count($userData).' entities updated</info>');
    }


}