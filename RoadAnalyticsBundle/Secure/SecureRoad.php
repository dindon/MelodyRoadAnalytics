<?php
namespace Melody\RoadAnalyticsBundle\Secure;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class SecureRoad
{
	private $router;
	private $request;
	private $session;
	private $response;

	private $login;
	private $pwd;

	public function __construct($router, $request, $session, $login, $pwd){
		$this->router = $router;
		$this->request = $request;
		$this->session = $session;

		$this->login = $login;
		$this->pwd = $pwd;
	}

	public function isSecuredRoad(GetResponseEvent $response){
		$this->response = $response;
		$roadname = $this->request->get('_route');
		$road = $this->router->getRouteCollection()->get($roadname);
		if($road){
			$options = $road->getOptions();
			if(isset($options['secure_analytics']) && $options['secure_analytics'])
				$this->checkAuthentication();
		}
	}

	public function checkAuthentication(){
		if($this->login == "" || $this->pwd == "")
			$this->redirectAuthentication();
		else {
			if($this->session->get('melody_road_analytics_login') && $this->session->get('melody_road_analytics_pwd')){
				if($this->session->get('melody_road_analytics_login') != $this->login || $this->session->get('melody_road_analytics_pwd') != $this->pwd)
					$this->redirectAuthentication();
			}
			else 
				$this->redirectAuthentication();
		}
	}

	public function redirectAuthentication(){
		$redirect = new RedirectResponse($this->router->generate('MelodyRoadAnalyticsBundle_login'));
		$this->response->setResponse($redirect);
	}
}