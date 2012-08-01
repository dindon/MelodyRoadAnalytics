<?php
namespace Melody\RoadAnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Melody\RoadAnalyticsBundle\Entity\MelodyRoadNm
 *
 * @ORM\Table(name="MELODY_ROAD_NM")
 * @ORM\Entity
 */
class MelodyRoadNm
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
    * @var MelodyVisitor
    * @ORM\OneToOne(targetEntity="MelodyVisitor", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="refvisitor", referencedColumnName="id")
    */
    private $refvisitor;

    /**
     * @var string $roadname
     *
     * @ORM\Column(name="roadname", type="string", length=100, nullable=false)
     */
    private $roadname;

    /**
    * @var MelodyRoadGrp
    *
    * @ORM\ManyToOne(targetEntity="MelodyRoadGrp")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="refgrp", referencedColumnName="id")
    * })
    */
    private $refgrp;

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
     * Set roadname
     *
     * @param string $roadname
     */
    public function setRoadname($roadname)
    {
        $this->roadname = $roadname;
    }

    /**
     * Get roadname
     *
     * @return string 
     */
    public function getRoadname()
    {
        return $this->roadname;
    }

    /**
     * Set refvisitor
     *
     * @param Melody\RoadAnalyticsBundle\Entity\MelodyVisitor $refvisitor
     */
    public function setRefvisitor(\Melody\RoadAnalyticsBundle\Entity\MelodyVisitor $refvisitor)
    {
        $this->refvisitor = $refvisitor;
    }

    /**
     * Get refvisitor
     *
     * @return Melody\RoadAnalyticsBundle\Entity\MelodyVisitor 
     */
    public function getRefvisitor()
    {
        return $this->refvisitor;
    }
}