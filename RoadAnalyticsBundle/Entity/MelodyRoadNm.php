<?php
namespace Melody\RoadAnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var string $roadname
     *
     * @ORM\Column(name="roadname", type="string", length=100, nullable=false)
     */
    private $roadname;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=300, nullable=false)
     */
    private $url;

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
    * @ORM\OneToMany(targetEntity="MelodyVisitor", mappedBy="refroadnm", cascade={"persist", "remove"})
    */
    private $visitors;
    
    public function __construct(){
        $this->visitors = new ArrayCollection();
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
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set refgrp
     *
     * @param Melody\RoadAnalyticsBundle\Entity\MelodyRoadGrp $refgrp
     */
    public function setRefgrp(\Melody\RoadAnalyticsBundle\Entity\MelodyRoadGrp $refgrp)
    {
        $this->refgrp = $refgrp;
    }

    /**
     * Get refgrp
     *
     * @return Melody\RoadAnalyticsBundle\Entity\MelodyRoadGrp 
     */
    public function getRefgrp()
    {
        return $this->refgrp;
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