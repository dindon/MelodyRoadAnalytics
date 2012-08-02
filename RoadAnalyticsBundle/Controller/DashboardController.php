<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
	public function showAction(){
		//TODO AFFICHAGE DU DASHBOARD
		return new Response('dashboard');
	}
}
