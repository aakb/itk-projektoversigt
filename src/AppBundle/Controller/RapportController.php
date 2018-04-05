<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Harvest\Project;
use AppBundle\Entity\Harvest\TimeEntry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RapportController extends Controller {

	private $cache;

	public function __construct( $cache_adapter ) {
		$this->cache = $cache_adapter;
	}

	/**
	 * @Route("/rapports", name="rapport_list")
	 *
	 * @Template()
	 */
	public function indexAction( Request $request ) {
		$repository = $this->getDoctrine()->getRepository( Project::class );

		$ownedByValues = $repository->findAllOwnedByValues();
		$choices       = [];
		foreach ( $ownedByValues as $value ) {
			$choices[ $value['ownedBy'] . ' (' . $value['count'] . ')' ] = $value['ownedBy'];
		}

		$form = $this->createFormBuilder()
		             ->add( 'name', TextType::class, [ 'required' => false, 'label' => 'Projekt Navn' ] )
		             ->add( 'client', TextType::class, [ 'required' => false, 'label' => 'Finansiering' ] )
		             ->add( 'ownedBy', ChoiceType::class, [ 'required' => false, 'choices' => $choices, 'expanded' => true, 'multiple' => true, 'label' => 'Kilde' ] )
		             ->add( 'isActive',
			             ChoiceType::class,
			             [
				             'required' => false,
				             'choices'  => [ 'Aktivt' => true ],
				             'data'     => [ true ],
				             'expanded' => true,
				             'multiple' => true,
				             'label'    => 'Status',
			             ] )
		             ->add( 'type',
			             ChoiceType::class,
			             [
				             'required'    => false,
				             'choices'     => [
					             'Fixed Fee'        => 'fixed',
					             'Time & Materials' => 'time',
					             'Non-Billable'     => 'non_billable',
				             ],
				             'placeholder' => 'Alle',
				             'expanded'    => true,
				             'multiple'    => false,
				             'label'       => 'Type',
			             ] )
		             ->add( 'save', SubmitType::class, [ 'label' => 'Søg' ] )
		             ->getForm();

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$data     = $form->getData();
			$projects = $repository->findBySearchData( $data );
		} else {
			$projects = $repository->findBySearchData( [ 'isActive' => true ] );
		}

		$lastRequestTimeCache = $this->cache->getItem('harvest.last_request_time');

		return [
			'lastsync'      => $lastRequestTimeCache->isHit() ? (int) $lastRequestTimeCache->get() : null,
			'ownedByValues' => $ownedByValues,
			'projects'      => $projects,
			'searchForm'    => $form->createView(),
		];

	}

}