<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RoadController extends Controller
{
	public function showAction(){
		$dates = $this->get('melody_road_analytics.dategetters')->getDates();
		$template = $this->getRequest()->isXmlHttpRequest() ? "MelodyRoadAnalyticsBundle:Road:body.html.twig" : "MelodyRoadAnalyticsBundle:Road:show.html.twig";
		
		$em = $this->getDoctrine()->getEntityManager();
		$roads = $em->getRepository('MelodyRoadAnalyticsBundle:MelodyRoadNm')->returnRoadsWithVisitorBetweenDate($dates[0], $dates[1]);

		$baseurl = $this->getRequest()->server->get('SERVER_NAME');
		$baseurl = $this->getRequest()->server->get('SERVER_PORT') == 443 ? 'https://'.$baseurl : 'http://'.$baseurl;

		return $this->render($template, array(
			'd1' => $dates[0],
			'd2' => $dates[1],
			'roads' => $roads,
			'baseurl' => $baseurl
		));
	}
}
