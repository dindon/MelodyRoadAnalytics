<?php
namespace Melody\RoadAnalyticsBundle\Services;

class DateInterval
{
	private $req;
	private $em;

	public function __construct($request, $em){
		$this->req = $request;
		$this->em = $em;
	}

	public function getDates(){
		if($this->req->isXmlHttpRequest()){
			//Si requête ajax c'est que l'intervale a été modifié
			$post = $this->req->request;
			list($d1,$m1,$y1) = \explode('/', $post->get('d1'));
			list($d2,$m2,$y2) = \explode('/', $post->get('d2'));
			$date1 = new \DateTime(); $date2 = new \DateTime();
			$date1->setDate($y1, $m1, $d1);
			$date2->setDate($y2, $m2, $d2);
		}
		else {
			// Sinon on récupère la date de la toute première visite
			$firstvisitor = $this->em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->returnFirstVisitor();
			$date1 = $firstvisitor ? $firstvisitor->getDatevisit() : new \DateTime();
			$date2 = new \DateTime();
		}
		return array($date1, $date2);
	}
}