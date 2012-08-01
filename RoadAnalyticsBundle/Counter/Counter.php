<?php
namespace Melody\RoadAnalyticsBundle\Counter;

class Counter
{
	private $router;
	private $request;
	private $em;

	private $routeOptions;
	private $url;
	private $ip;

	public function __construct($router, $request, $em){
		$this->router = $router;
		$this->request = $request;
		$this->em = $em;
	}

	public function visitorRequest(){
		// On récupère la route appelée via le service Request
		$routeName = $this->request->get('_route');
		// On récupère l'objet matérialisant la route via le service Router
		$route = $this->router->getRouteCollection()->get($routeName);
		// Si la route est trouvée
		if($route){
			// On récupère les options saisie dans le fichier routing
			$this->optRoute = $route->getOptions();
			// Si la route est prise en compte pour les statistiques
			// On appel la méthode pour tester si le visiteur la pas
			// déjà visite cette page aujourd'hui
			if(isset($this->optRoute['analytics']) && $this->optRoute['analytics'])
				$this->isVisitorUnique();
		}
	}

	public function isVisitorUnique(){
		// On recupère l'url située aprés le nom de domaine
		$request_uri = \strtolower($this->request->server->get('REQUEST_URI'));
		// Regex pour supprimé les variables GET (robot google, ...) pour eviter de fausser les stats
		$this->url = \preg_replace('#[?].{0,}#i', '', $request_uri);
		// Récupération de l'ip du visiteur
		$this->ip = $this->request->server->get('REMOTE_ADDR');
		// On test si le visiteur est déjà venu sur cette page aujourd'hui ...
		// Si la méthode renvoie true, on est sur que le visite est unique pour cette page aujourd'hui
		if($this->em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->isNewVisitor($this->ip, $this->request->get('_route'), $this->url)){
			// Visiteur unique on va pouvoir le persister en base de données
			// On fait appel à la méthode qui persistera dans la BDD le visiteur pour cette url
			$this->persistVisitor();
		}
		// Sinon on fait rien :)
	}

	public function persistVisitor(){
		//TODO PERSISTANCE
		echo "on persiste ...";
	}
}