<?php
namespace Melody\RoadAnalyticsBundle\Counter;

use Melody\RoadAnalyticsBundle\Entity\MelodyDateVisit;
use Melody\RoadAnalyticsBundle\Entity\MelodyVisitor;
use Melody\RoadAnalyticsBundle\Entity\MelodyRoadGrp;
use Melody\RoadAnalyticsBundle\Entity\MelodyRoadNm;
use Melody\RoadAnalyticsBundle\Counter\UA;

class Counter
{
	private $router;
	private $request;
	private $em;

	private $optRoute;
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
	}

	public function persistVisitor(){
		// On récupère l'objet DateVisit
		// Si l'objet n'est pas trouvé en BDD, on le créé
		if(!$dateVisit = $this->em->getRepository('MelodyRoadAnalyticsBundle:MelodyDateVisit')->findOneBy(array('datevisit' => \date('Y-m-d')))){
			$dateVisit = new MelodyDateVisit();
			$this->em->persist($dateVisit);
		}
		// Si la route a été configurée comme apartenant à un groupe de page
		// On va effectuer une recherche si l'objet MelodyRoadNm existe
		if(isset($this->optRoute['analytics_group']) && $this->optRoute['analytics_group'] != ""){
			if(!$road = $this->em->getRepository('MelodyRoadAnalyticsBundle:MelodyRoadNm')->issetRoadWithGroup($this->request->get('_route'), $this->url, $this->optRoute['analytics_group'])){
				// Si la route n'existe pas en BDD nous allons tester si le group existe
				if(!$group = $this->em->getRepository('MelodyRoadAnalyticsBundle:MelodyRoadGrp')->findOneBy(array('libelle' => $this->optRoute['analytics_group']))){
					//Si le group n'existe pas nous allons le créer
					$group = new MelodyRoadGrp();
					$group->setLibelle($this->optRoute['analytics_group']);
					$this->em->persist($group);
				}
				// Maintenant nous allons créer la route
				$road = new MelodyRoadNm();
				$road->setRoadName($this->request->get('_route'));
				$road->setUrl($this->url);
				$road->setRefgrp($group);
				$this->em->persist($road);
			}
		}
		else {
			// Si aucun paramêtre de group n'est inscrit
			// On recherche si la route sans group existe
			if(!$road = $this->em->getRepository('MelodyRoadAnalyticsBundle:MelodyRoadNm')->issetRoadWithoutGroup($this->request->get('_route'), $this->url)){
				// Si la route n'existe pas, on la créer
				$road = new MelodyRoadNm();
				$road->setRoadName($this->request->get('_route'));
				$road->setUrl($this->url);
				$this->em->persist($road);
			}
		}
		// On créé une instance configurée de MelodyVisitor
		$visitor = $this->getNewVisitorInstance();
		// Et on ajoute les liaisons
		$visitor->setRefdatevisit($dateVisit);
		$visitor->setRefroadnm($road);
		//Pour finir on persist / flush
		$this->em->persist($visitor);
		$this->em->flush();
	}

	public function getNewVisitorInstance(){
		// On récupère toutes les informations lié au naviguateur du visiteur
		// via la lib ua-parser-php créée par Dave Olsen -> http://dmolsen.com
		$visitorInfos = UA::parse();
		// On instanci un nouvelle objet MelodyVisitor
		// Et on le configure
		$visitor = new MelodyVisitor();
		$visitor->setIp($this->ip);
		if($visitorInfos->browser != "") $visitor->setBrowser($visitorInfos->browser);
		if($visitorInfos->version != "") $visitor->setBrowserversion($visitorInfos->version);
		if($visitorInfos->os != "") $visitor->setOs($visitorInfos->os);
		if($visitorInfos->isMobile) $visitor->setMobile(1);
		if($visitorInfos->isTablet) $visitor->setTablet(1);
		if($visitorInfos->isComputer) $visitor->setComputer(1);
		return $visitor;
	}

}


















