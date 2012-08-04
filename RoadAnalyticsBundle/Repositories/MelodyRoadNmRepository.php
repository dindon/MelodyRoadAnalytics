<?php
namespace Melody\RoadAnalyticsBundle\Repositories;
use Doctrine\ORM\EntityRepository;

class MelodyRoadNmRepository extends EntityRepository
{	
	public function issetRoadWithGroup($roadname, $url, $group){
		$qb = $this->createQueryBuilder('road');
		$qb->select('road')
		   ->join('road.refgrp', 'grp')
		   ->where('road.roadname = :roadname')
		   ->andWhere('road.url = :url')
		   ->andWhere('grp.libelle = :grp')
		   ->setParameters(array(
		   		'roadname' => $roadname,
		   		'url' => $url,
		   		'grp' => $group
		   ));
		$query = $qb->getQuery();
		$result = $query->getResult();
		if(\count($result) > 0)
			return $result[0];
		return false;
	}

	public function issetRoadWithoutGroup($roadname, $url){
		$qb = $this->createQueryBuilder('road');
		$qb->select('road')
		   ->where('road.roadname = :roadname')
		   ->andWhere('road.url = :url')
		   ->andWhere('road.refgrp IS NULL')
		   ->setParameters(array(
		   		'roadname' => $roadname,
		   		'url' => $url
		   ));
		$query = $qb->getQuery();
		$result = $query->getResult();
		if(\count($result) > 0)
			return $result[0];
		return false;
	}
}