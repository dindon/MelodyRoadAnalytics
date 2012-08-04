<?php
namespace Melody\RoadAnalyticsBundle\Twig\Extension;
 
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;
 
class TwigExtension extends \Twig_Extension 
{
    public function getName(){
        return 'melodyroadtwigext';
    }
 
 
    public function getFilters(){
        return array(
            'stripslashes' => new \Twig_Filter_Method($this, 'twigStripslashes'),
        	'round' => new \Twig_Filter_Method($this, 'twigRound'),
            'txtmonth' => new \Twig_Filter_Method($this, 'twigTxtMonth'),
            'pourcent' => new \Twig_Filter_Method($this, 'twigPourcent'),
            'datediff' => new \Twig_Filter_Method($this, 'twigDateDiff'),
            'addday' => new \Twig_Filter_Method($this, 'twigAddDay'),
            'int' => new \Twig_Filter_Method($this, 'twigInt'),
        );
    }
 	
    public function twigInt($str){
        return (int)$str;
    }

    public function twigAddDay($date, $nday){
        return $date->add(new \DateInterval('P'.$nday.'D'));
    }

    public function twigDateDiff($d1, $d2){
        $dateInterval = $d1->diff($d2);
        return $dateInterval->days;
    }

    public function twigPourcent($val, $total){
        $pourcent = ($val*100)/$total;
        return \round($pourcent*100)/100;
    }

    public function twigTxtMonth($month){
       $arrMonth = array(
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre'
        );
        return $arrMonth[$month];
    }
    
    public function twigRound($number){
    	$number = \round($number*100)/100;
        return \number_format($number,2,'.',' ');
    }
    
    public function twigStripslashes($str) {
        return \stripslashes($str);
    }
}