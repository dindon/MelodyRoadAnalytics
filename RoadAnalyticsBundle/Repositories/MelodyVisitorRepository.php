<?php
namespace Melody\RoadAnalyticsBundle\Repositories;
use Doctrine\ORM\EntityRepository;

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

	public function countGlobalUniqueVisitorSinceEver(){
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor')
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

	public function countUniqueVisitorPerBroswerSinceEver()
	{
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor.browser', 'COUNT(visitor)')
		   ->where($qb->expr()->in('visitor', $this->countGlobalUniqueVisitorSinceEver()))
		   ->groupBy('visitor.browser');
		$query = $qb->getQuery();
		return $query->getResult();
	}

	public function countUniqueVisitorPerOSSinceEver()
	{
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('visitor.os', 'COUNT(visitor)')
		   ->where($qb->expr()->in('visitor', $this->countGlobalUniqueVisitorSinceEver()))
		   ->groupBy('visitor.os');
		$query = $qb->getQuery();
		return $query->getResult();
	}



}









