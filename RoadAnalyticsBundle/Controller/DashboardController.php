<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
	public function showAction(){
		$em = $this->getDoctrine()->getEntityManager();
		$nb_unique_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countGlobalUniqueVisitorSinceEver();
		
		$nb_unique_mobile_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueMobileVisitorSinceEver();
		$nb_unique_tablet_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueTabletVisitorSinceEver();
		$nb_unique_computer_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueComputerVisitorSinceEver();

		$visitor_per_broswers = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueVisitorPerBroswerSinceEver();

		$visitor_per_os = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueVisitorPerOSSinceEver();

		return $this->render('MelodyRoadAnalyticsBundle:Dashboard:show.html.twig', array(
		    'nb_unique_visitor' => $nb_unique_visitor,
		    'nb_unique_mobile_visitor' => $nb_unique_mobile_visitor,
		    'nb_unique_tablet_visitor' => $nb_unique_tablet_visitor,
		    'nb_unique_computer_visitor' => $nb_unique_computer_visitor,
		    'visitor_per_broswers' => $visitor_per_broswers,
		    'visitor_per_os' => $visitor_per_os
		));
	}
}
