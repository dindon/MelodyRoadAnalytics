<?php

namespace Melody\RoadAnalyticsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Melody\RoadAnalyticsBundle\Entity\MelodyVisitor
 *
 * @ORM\Table(name="MELODY_VISITOR")
 * @ORM\Entity(repositoryClass="Melody\RoadAnalyticsBundle\Repositories\MelodyVisitorRepository")
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
    * @var MelodyRoadNm
    *
    * @ORM\ManyToOne(targetEntity="MelodyRoadNm")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="refroadnm", referencedColumnName="id")
    * })
    */
    private $refroadnm;

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
     * @var string $browserversion
     *
     * @ORM\Column(name="browserversion", type="string", length=50, nullable=true)
     */
    private $browserversion;

    /**
     * @var string $mobile
     *
     * @ORM\Column(name="mobile", type="string", length=1, nullable=false)
     */
    private $mobile;

    /**
     * @var string $tablet
     *
     * @ORM\Column(name="tablet", type="string", length=1, nullable=false)
     */
    private $tablet;

    /**
     * @var string $computer
     *
     * @ORM\Column(name="computer", type="string", length=1, nullable=false)
     */
    private $computer;

    /**
     * @var string $os
     *
     * @ORM\Column(name="os", type="string", length=50, nullable=true)
     */
    private $os;

    public function __construct(){
        $this->datevisit = new \DateTime();
        $this->mobile = 0;
        $this->tablet = 0;
        $this->computer = 0;
        $this->browser = 'Unknown';
    }

    public function __toString(){
        return (string) $this->id;
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

    /**
     * Set refroadnm
     *
     * @param Melody\RoadAnalyticsBundle\Entity\MelodyRoadNm $refroadnm
     */
    public function setRefroadnm(\Melody\RoadAnalyticsBundle\Entity\MelodyRoadNm $refroadnm)
    {
        $this->refroadnm = $refroadnm;
    }

    /**
     * Get refroadnm
     *
     * @return Melody\RoadAnalyticsBundle\Entity\MelodyRoadNm 
     */
    public function getRefroadnm()
    {
        return $this->refroadnm;
    }

    /**
     * Set browserversion
     *
     * @param string $browserversion
     */
    public function setBrowserversion($browserversion)
    {
        $this->browserversion = $browserversion;
    }

    /**
     * Get browserversion
     *
     * @return string 
     */
    public function getBrowserversion()
    {
        return $this->browserversion;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set tablet
     *
     * @param string $tablet
     */
    public function setTablet($tablet)
    {
        $this->tablet = $tablet;
    }

    /**
     * Get tablet
     *
     * @return string 
     */
    public function getTablet()
    {
        return $this->tablet;
    }

    /**
     * Set computer
     *
     * @param string $computer
     */
    public function setComputer($computer)
    {
        $this->computer = $computer;
    }

    /**
     * Get computer
     *
     * @return string 
     */
    public function getComputer()
    {
        return $this->computer;
    }

    /**
     * Set os
     *
     * @param string $os
     */
    public function setOs($os)
    {
        $this->os = $os;
    }

    /**
     * Get os
     *
     * @return string 
     */
    public function getOs()
    {
        return $this->os;
    }
}