<?php

namespace Melody\RoadAnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Melody\RoadAnalyticsBundle\Entity\MelodyVisitor
 *
 * @ORM\Table(name="MELODY_VISITOR")
 * @ORM\Entity
 */
class MelodyVisitor
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
    * @var MelodyDateVisit
    *
    * @ORM\ManyToOne(targetEntity="MelodyDateVisit")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="refdatevisit", referencedColumnName="id")
    * })
    */
    private $refdatevisit;

    /**
     * @var string $ip
     *
     * @ORM\Column(name="ip", type="string", length=20, nullable=false)
     */
    private $ip;

    /**
     * @var datetime $datevisit
     *
     * @ORM\Column(name="datevisit", type="datetime", nullable=false)
     */
    private $datevisit;

    /**
     * @var string $browser
     *
     * @ORM\Column(name="browser", type="string", length=50, nullable=false)
     */
    private $browser;



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
     * Set ip
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set datevisit
     *
     * @param datetime $datevisit
     */
    public function setDatevisit($datevisit)
    {
        $this->datevisit = $datevisit;
    }

    /**
     * Get datevisit
     *
     * @return datetime 
     */
    public function getDatevisit()
    {
        return $this->datevisit;
    }

    /**
     * Set browser
     *
     * @param string $browser
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    /**
     * Get browser
     *
     * @return string 
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set refdatevisit
     *
     * @param Melody\RoadAnalyticsBundle\Entity\MelodyDateVisit $refdatevisit
     */
    public function setRefdatevisit(\Melody\RoadAnalyticsBundle\Entity\MelodyDateVisit $refdatevisit)
    {
        $this->refdatevisit = $refdatevisit;
    }

    /**
     * Get refdatevisit
     *
     * @return Melody\RoadAnalyticsBundle\Entity\MelodyDateVisit 
     */
    public function getRefdatevisit()
    {
        return $this->refdatevisit;
    }
}