<?php
namespace Melody\RoadAnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Melody\RoadAnalyticsBundle\Entity\MelodyDateVisit
 *
 * @ORM\Table(name="MELODY_DATE_VISIT")
 * @ORM\Entity(repositoryClass="Melody\RoadAnalyticsBundle\Repositories\MelodyDateVisitRepository")
 */
class MelodyDateVisit
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var date $datevisit
     *
     * @ORM\Column(name="datevisit", type="date", nullable=false)
     */
    private $datevisit;

    /**
    * @ORM\OneToMany(targetEntity="MelodyVisitor", mappedBy="refdatevisit", cascade={"persist", "remove"})
    * @ORM\OrderBy({ "datevisit" = "ASC" })
    */
    private $visitors;

    public function __construct(){
        $this->visitors = new ArrayCollection();
        $this->datevisit = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datevisit
     *
     * @param date $datevisit
     */
    public function setDatevisit($datevisit)
    {
        $this->datevisit = $datevisit;
    }

    /**
     * Get datevisit
     *
     * @return date 
     */
    public function getDatevisit()
    {
        return $this->datevisit;
    }

    /**
     * Add visitors
     *
     * @param Melody\RoadAnalyticsBundle\Entity\MelodyVisitor $visitors
     */
    public function addMelodyVisitor(\Melody\RoadAnalyticsBundle\Entity\MelodyVisitor $visitors)
    {
        $this->visitors[] = $visitors;
    }

    /**
     * Get visitors
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVisitors()
    {
        return $this->visitors;
    }
}