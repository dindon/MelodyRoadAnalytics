<?php
namespace Melody\RoadAnalyticsBundle\Counter;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class Counter
{
	private $router;
	private $request;

	public function __construct($router, $request){
		$this->router = $router;
		$this->request = $request;
	}

	public function visitorRequest(GetResponseEvent $response){
		// On récupère la route appelée via le service Request
		$routeName = $this->request->get('_route');
		// On récupère l'objet matérialisant la route via le service Router
		$route = $this->router->getRouteCollection()->get($routeName);
		// Si la route est trouvée
		if($route){
			// On récupère les options saisie dans le fichier routing
			$options = $route->getOptions();
			// Si la route est prise en compte pour les statistiques
			// On appel la méthode pour tester si le visiteur la pas
			// déjà visite cette page aujourd'hui
			if(isset($options['stats']) && $options['stats'])
				$this->isVisitorUnique();
		}
	}

	public function isVisitorUnique(){
		// TODO CHECK USER
	}
}