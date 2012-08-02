<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AnalyticsController extends Controller
{
	public function globalGraphiqueSinceOneMonthAction($day, $month, $year){
		$maxPrevDay = \date('t', \mktime(0, 0, 0, $month-1, 1, $year));
		$prevDay = $maxPrevDay < $day ? $maxPrevDay : $day;
		$maxDay = \date('t', \mktime(0, 0, 0, $month, 1, $year));
		$day = $maxDay < $day ? $maxDay : $day;
		$dFirst = new \DateTime(); $dFirst->setDate($year, $month-1, $prevDay);
		$dLast = new \DateTime(); $dLast->setDate($year, $month, $day);

		$em = $this->getDoctrine()->getEntityManager();
		$dates = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyDateVisit')->globalVisitorBetweenDates($dFirst->format('Y-m-d'), $dLast->format('Y-m-d'));
		return $this->render('MelodyRoadAnalyticsBundle:Graphiques:betweenEvolution.html.twig', array(
		    'date1' => $dFirst,
		    'date2' => $dLast,
		    'datesvisits' => $dates
		));
	}
}
