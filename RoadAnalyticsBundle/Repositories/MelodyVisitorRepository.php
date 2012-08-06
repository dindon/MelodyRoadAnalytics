<?php
namespace Melody\RoadAnalyticsBundle\Repositories;
use Doctrine\ORM\EntityRepository;
use Melody\RoadAnalyticsBundle\Entity\MelodyVisitor;

class MelodyVisitorRepository extends EntityRepository
{	
	public function isNewVisitor($ip, $roadname, $url){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('COUNT(visitor)')
		   ->join('visitor.refroadnm', 'road')
		   ->join('visitor.refdatevisit', 'date')
		   ->where('visitor.ip = :ip')
		   ->andWhere('road.roadname = :roadname')
		   ->andWhere('road.url = :url')
		   ->andWhere('date.datevisit = :now')
		   ->setParameters(array(
		   		'ip' => $ip,
		   		'roadname' => $roadname,
		   		'url' => $url,
		   		'now' => \date('Y-m-d')
		   ));
		$query = $qb->getQuery();
		if($query->getSingleScalarResult() == 0)
			return true;
		return false;
	}

	public function returnFirstVisitor()
	{
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
		   ->orderBy('visitor.datevisit', 'ASC')
		   ->setMaxResults(1);
		$query = $qb->getQuery();
		return $query->getOneOrNullResult();
	}

	public function countGlobalUniqueVisitorSinceEver(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countGlobalUniqueVisitor($d1, $d2){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
		   ->join('visitor.refdatevisit', 'date')
		   ->where($qb->expr()->between('date.datevisit', ':d1', ':d2'))
		   ->setParameters(array(
		   		'd1' => $d1->format('Y-m-d'),
		   		'd2' => $d2->format('Y-m-d')
		   ))
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countUniqueMobileVisitorSinceEver(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
		   ->where('visitor.mobile = 1')
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countUniqueTabletVisitorSinceEver(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
		   ->where('visitor.tablet = 1')
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countUniqueComputerVisitorSinceEver(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
		   ->where('visitor.computer = 1')
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countUniqueVisitorPerBroswerSinceEver(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor.browser', 'COUNT(visitor)')
		   ->where($qb->expr()->in('visitor', $this->countGlobalUniqueVisitorSinceEver()))
		   ->groupBy('visitor.browser');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countUniqueVisitorPerOSSinceEver(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor.os', 'COUNT(visitor)')
		   ->where($qb->expr()->in('visitor', $this->countGlobalUniqueVisitorSinceEver()))
		   ->groupBy('visitor.os');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countUniqueVisitorByMonth($date){
		$maxDay = \date('t', \mktime(0, 0, 0, $date->format('m'), 1, $date->format('Y')));
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
		   ->join('visitor.refdatevisit', 'date')
		   ->where($qb->expr()->between('date.datevisit', ':date1', ':date2'))
		   ->setParameters(array(
		   		'date1' => $date->format('Y-m-d'),
		   		'date2' => $date->format('Y-m-').$maxDay
		   ))
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		return $query->getResult();
	}


	// BULLSHIT
	// QUI RECUPERE TOUT LES ID DES VISITEURS UNIQUE ENTRANT SUR LE SITE
	public function arrFirstLoadVisitor(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select($qb->expr()->min('visitor.id'))
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		$arr = $query->getResult();
		$returnArr = array();
		foreach($arr as $k){
			$returnArr[] = $k[1];
		}
		return $returnArr;
	}
}









