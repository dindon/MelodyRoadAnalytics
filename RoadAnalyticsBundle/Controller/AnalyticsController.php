<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AnalyticsController extends Controller
{
	public function globalGraphiqueSinceOneMonthAction($day, $month, $year){
		$maxDay = \date('t', \mktime(0, 0, 0, $month, 1, $year));
		$day = $maxDay < $day ? $maxDay : $day;
		
		$dFirst = new \DateTime(); $dFirst->setDate($year, $month, $day-30);
		$dLast = new \DateTime(); $dLast->setDate($year, $month, $day);

		$em = $this->getDoctrine()->getEntityManager();
		$datesvisit = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyDateVisit')->globalVisitorBetweenDates($dFirst->format('Y-m-d'), $dLast->format('Y-m-d'));

		$key = 0;
		$arrGraph = array();
		$arrGraph[] = array('Dates', 'Visiteur(s)');
		$ddif = $dFirst->diff($dLast);
		for($i = 0; $i < $ddif->days+1; $i++) { 
			$date = new \DateTime($dFirst->format('Y-m-d'));
			$date->add(new \DateInterval('P'.$i.'D'));
			if(isset($datesvisit[$key]) && $datesvisit[$key]['datevisit'] == $date->format('Y-m-d')){
				$arrGraph[] = array($date->format('d/m/Y'), (int)$datesvisit[$key][1]);
				$key++;
			}
			else
				$arrGraph[] = array($date->format('d/m/Y'), 0);
				
			//valeur 264%($i+1) => 0 en prod :p
		}

		return $this->render('MelodyRoadAnalyticsBundle:Graphiques:betweenEvolution.html.twig', array(
		    'date1' => $dFirst,
		    'date2' => $dLast,
		    'arrGraphJson' => \json_encode($arrGraph)
		));
	}
}
