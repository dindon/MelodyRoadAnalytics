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


	public function returnRoadsWithVisitorBetweenDate($d1, $d2)
	{
		$qb = $this->createQueryBuilder('road');
		$qb->select('road', 'visitor', 'grp')
		   ->join('road.visitors', 'visitor')
		   ->leftJoin('road.refgrp', 'grp')
		   ->join('visitor.refdatevisit', 'date')
		   ->where($qb->expr()->between('date.datevisit', ':d1', ':d2'))
		   ->setParameters(array(
		   		'd1' => $d1->format('Y-m-d'),
		   		'd2' => $d2->format('Y-m-d')
		   ));
		$query = $qb->getQuery();
		return $query->getResult();
	}


	//BULLSHIT
	public function entryRoad(){
		$qb = $this->createQueryBuilder('road');
		$em = $this->_em;
		$qb->select('road', $qb->expr()->length('road.visitors'))
		   ->join('road.visitors', 'visitor')
		   ->where($qb->expr()->in('visitor', $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->arrFirstLoadVisitor()));
		$query = $qb->getQuery();
		return $query->getResult();
	}
}