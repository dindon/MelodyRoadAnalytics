<?php
namespace Melody\RoadAnalyticsBundle\Repositories;
use Doctrine\ORM\EntityRepository;

class MelodyDateVisitRepository extends EntityRepository
{	
	public function globalVisitorBetweenDates($d1, $d2){
		$em = $this->getEntityManager();

		$qb = $this->createQueryBuilder('date');
		$qb->select('date.datevisit', 'COUNT(visitor)')
		   ->join('date.visitors', 'visitor')
		   ->where($qb->expr()->between('date.datevisit', ':date1', ':date2'))
		   ->andWhere($qb->expr()->in('visitor', $em->getRepository('MelodyRoadAnalyticsBundle:MelodyVisitor')->countGlobalUniqueVisitorSinceEver()))
		   ->setParameters(array(
		   		'date1' => $d1->format('Y-m-d'),
		   		'date2' => $d2->format('Y-m-d')
		   ))
		   ->groupBy('date.datevisit')
		   ->orderBy('date.datevisit', 'ASC');
		$query = $qb->getQuery();
		return $query->getResult();
	}
}