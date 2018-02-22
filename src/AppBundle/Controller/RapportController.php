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
		             ->add( 'name', TextType::class, [ 'required' => false, 'label' => 'Navn' ] )
		             ->add( 'ownedBy', ChoiceType::class, [ 'choices' => $choices, 'expanded' => true, 'multiple' => true, 'label' => 'Kilde' ] )
		             ->add( 'isActive', ChoiceType::class, [ 'choices' => ['Ja' => true], 'expanded' => true, 'multiple' => true, 'label' => 'Aktive' ] )
		             ->add( 'type', ChoiceType::class, [ 'choices' => ['Fixed Fee' => 'fixed', 'Time & Materials' => 'time', 'Non-Billable' => 'non_billable'], 'expanded' => true, 'multiple' => true, 'label' => 'Type' ] )
		             ->add( 'save', SubmitType::class, [ 'label' => 'Søg' ] )
		             ->getForm();

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$data     = $form->getData();
			$projects = $repository->findBySearchData( $data );
		} else {
			$projects = $repository->findBySearchData();
		}


		return [
			'ownedByValues' => $ownedByValues,
			'projects'      => $projects,
			'searchForm'    => $form->createView(),
		];

	}

}