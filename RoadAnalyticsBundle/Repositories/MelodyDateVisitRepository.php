<?php
namespace Melody\RoadAnalyticsBundle\Repositories;
use Doctrine\ORM\EntityRepository;

class MelodyDateVisitRepository extends EntityRepository
{	
	public function globalVisitorBetweenDates($firstDate, $lastDate)
	{
		$qb = $this->createQueryBuilder('date');
		$qb->select('date', 'visitor')
		   ->join('date.visitors', 'visitor')
		   ->where($qb->expr()->between('date.datevisit', ':date1', ':date2'))
		   ->setParameters(array(
		   		'date1' => $firstDate,
		   		'date2' => $lastDate
		   ))
		   ->groupBy('visitor.refdatevisit')
		   ->addGroupBy('visitor.ip');
		$query = $qb->getQuery();
		return $query->getResult();
	}
}