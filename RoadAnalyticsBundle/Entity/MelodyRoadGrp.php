<?php
namespace Melody\RoadAnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Melody\RoadAnalyticsBundle\Entity\MelodyRoadGrp
 *
 * @ORM\Table(name="MELODY_ROAD_GRP")
 * @ORM\Entity
 */
class MelodyRoadGrp
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
     * @var string $libelle
     *
     * @ORM\Column(name="libelle", type="string", length=60, nullable=false)
     */
    private $libelle;
    
    /**
    * @ORM\OneToMany(targetEntity="MelodyRoadNm", mappedBy="refgrp", cascade={"persist", "remove"})
    */
    private $roadnames;


    public function __construct(){
        $this->roadnames;
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
     * Set libelle
     *
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Add roadnames
     *
     * @param Melody\RoadAnalyticsBundle\Entity\MelodyRoadNm $roadnames
     */
    public function addMelodyRoadNm(\Melody\RoadAnalyticsBundle\Entity\MelodyRoadNm $roadnames)
    {
        $this->roadnames[] = $roadnames;
    }

    /**
     * Get roadnames
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRoadnames()
    {
        return $this->roadnames;
    }
}