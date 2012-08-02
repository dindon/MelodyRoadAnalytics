<?php
namespace Melody\RoadAnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
	public function formAction(){
		$session = $this->get('session');
		if($this->container->getParameter('melody_road_analytics_login') == $session->get('melody_road_analytics_login') && $this->container->getParameter('melody_road_analytics_pwd') == $session->get('melody_road_analytics_pwd'))
			return $this->redirect($this->generateUrl('MelodyRoadAnalyticsBundle_dashboard'));

		$token = $this->get('form.csrf_provider')->generateCsrfToken('login_analytics');
		return $this->render('MelodyRoadAnalyticsBundle:Login:form.html.twig', array(
		    'token' => $token,
		    'error' => $session->getFlash('melody_road_analytics_error')
		));
	}

	public function checkAction(){
		$post = $this->getRequest()->request;
		if($post->get('token') && $this->get('form.csrf_provider')->isCsrfTokenValid('login_analytics', $post->get('token'))){
			if($this->container->getParameter('melody_road_analytics_login') == $post->get('login') && $this->container->getParameter('melody_road_analytics_pwd') == \sha1($post->get('pwd'))){
				$session = $this->get('session');
				$session->set('melody_road_analytics_login', $post->get('login'));
				$session->set('melody_road_analytics_pwd', \sha1($post->get('pwd')));
				return $this->redirect($this->generateUrl('MelodyRoadAnalyticsBundle_dashboard'));
			}
			$this->get('session')->setFlash('melody_road_analytics_error', 'Votre identifiant ou votre mot de passe semblent incorrects.');
		}
		return $this->redirect($this->generateUrl('MelodyRoadAnalyticsBundle_login'));
	}

	public function logoutAction(){
		$session = $this->get('session');
		$session->remove('melody_road_analytics_login');
		$session->remove('melody_road_analytics_pwd');
		return $this->redirect($this->generateUrl('MelodyRoadAnalyticsBundle_login'));
	}
}
