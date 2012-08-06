<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
	public function showAction(){
		$em = $this->getDoctrine()->getEntityManager();
		$req = $this->getRequest();
		if($req->isXmlHttpRequest()){
			//Si requête ajax c'est que l'intervale a été modifié
			$post = $this->getRequest()->request;
			list($d1,$m1,$y1) = \explode('/', $post->get('d1'));
			list($d2,$m2,$y2) = \explode('/', $post->get('d2'));
			$date1 = new \DateTime(); $date2 = new \DateTime();
			$date1->setDate($y1, $m1, $d1);
			$date2->setDate($y2, $m2, $d2);
			$template = "MelodyRoadAnalyticsBundle:Dashboard:body.html.twig";
		}
		else {
			// Sinon on récupère la date de la toute première visite
			$firstvisitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->returnFirstVisitor();
			$date1 = $firstvisitor ? $firstvisitor->getDatevisit() : new \DateTime();
			$date2 = new \DateTime();
			$template = "MelodyRoadAnalyticsBundle:Dashboard:show.html.twig";
		}

		//On récupère les visitors uniques entre l'interval date1 et date2
		$nb_unique_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countGlobalUniqueVisitor($date1, $date2);

		$nb_unique_mobile_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueMobileVisitorSinceEver();
		$nb_unique_tablet_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueTabletVisitorSinceEver();
		$nb_unique_computer_visitor = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueComputerVisitorSinceEver();
		$visitor_per_broswers = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueVisitorPerBroswerSinceEver();

		$visitor_per_os = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countUniqueVisitorPerOSSinceEver();

		return $this->render($template, array(
		    'nb_unique_visitor' => $nb_unique_visitor,
		    'nb_unique_mobile_visitor' => $nb_unique_mobile_visitor,
		    'nb_unique_tablet_visitor' => $nb_unique_tablet_visitor,
		    'nb_unique_computer_visitor' => $nb_unique_computer_visitor,
		    'visitor_per_broswers' => $visitor_per_broswers,
		    'visitor_per_os' => $visitor_per_os,
		    'd1' => $date1,
		    'd2' => $date2
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
