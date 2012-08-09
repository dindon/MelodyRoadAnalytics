<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
	public function showAction(){
		$em = $this->getDoctrine()->getEntityManager();
		$dates = $this->get('melody_road_analytics.dategetters')->getDates();
		$template = $this->getRequest()->isXmlHttpRequest() ? "MelodyRoadAnalyticsBundle:Dashboard:body.html.twig" : "MelodyRoadAnalyticsBundle:Dashboard:show.html.twig";

		//On récupère les visiteurs entre l'interval date1 et date2
		$nb_unique_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countGlobalUniqueVisitor($dates[0], $dates[1]);
		//On récupère les visiteurs mobile entre l'interval date1 et date2
		$nb_unique_mobile_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueMobileVisitor($dates[0], $dates[1]);
		//On récupère les visiteurs tablettes entre l'interval date1 et date2
		$nb_unique_tablet_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueTabletVisitor($dates[0], $dates[1]);
		//On récupère les visiteurs ordinateurs entre l'interval date1 et date2
		$nb_unique_computer_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueComputerVisitor($dates[0], $dates[1]);

		//On récupère les visitors groupés par navigateurs entre l'interval date1 et date2
		$visitor_per_broswers = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueVisitorPerBroswer($dates[0], $dates[1]);

		//On récupère les visitors groupés par os entre l'interval date1 et date2
		$visitor_per_os = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueVisitorPerOS($dates[0], $dates[1]);

		return $this->render($template, array(
		    'nb_unique_visitor' => $nb_unique_visitor,
		    'nb_unique_mobile_visitor' => $nb_unique_mobile_visitor,
		    'nb_unique_tablet_visitor' => $nb_unique_tablet_visitor,
		    'nb_unique_computer_visitor' => $nb_unique_computer_visitor,
		    'visitor_per_broswers' => $visitor_per_broswers,
		    'visitor_per_os' => $visitor_per_os,
		    'd1' => $dates[0],
		    'd2' => $dates[1]
		));
	}

	public function loadTotalUniqueVisitorAction(){
		$em = $this->getDoctrine()->getEntityManager();
		$nb_unique_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countGlobalUniqueVisitorSinceEver();

		return $this->render('MelodyRoadAnalyticsBundle:Layout:globalVisitorIcon.html.twig', array(
		    'global_unique_visitor' => \count($nb_unique_visitor)
		));
	}
}
