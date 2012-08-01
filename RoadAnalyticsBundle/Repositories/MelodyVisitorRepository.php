<?php
namespace Melody\RoadAnalyticsBundle\Repositories;
use Doctrine\ORM\EntityRepository;

class MelodyVisitorRepository extends EntityRepository
{	
	public function isNewVisitor($ip, $roadname, $url)
	{
		$qb = $this->createQueryBuilder('visitor');
		$qb->select('COUNT(visitor)')
		   ->join('visitor.roadnames', 'road')
		   ->join('visitor.refdatevisite', 'date')
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
}