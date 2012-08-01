<?php
namespace Melody\RoadAnalyticsBundle\ParametersManager;

class ParametersManager
{
	public function parseIniFile($file){
		$array = array();
		if(\file_exists($file) && $fileOpen = \file($file)){
			foreach($fileOpen as $ln){
		     	if(preg_match("#^\[(.*)\]\s+$#",$ln,$matches)){
		        	$groupe = \trim($matches[1]);
		        	$array[$groupe] = array();
		     	}
		     	elseif($ln[0]!=';'){
		     		if(\trim($ln) != ""){
			        	list($item,$valeur) = \explode("=",$ln,2);
			        	if(!isset($valeur)) $valeur='';
			        	$array[$groupe][\trim($item)]=\trim($valeur);
		     		}
		     	}
			}
		}
		return $array;
	}

	public function rewriteIniFile($url, $parameters){
		$file = fopen($url,"w");
		\ftruncate($file,0); 
		$i = 0;
		foreach($parameters as $k => $v){
        	if($i == 0) \fputs($file, "[".$k."]"); else \fputs($file, "\n[".$k."]");
            foreach($v as $key => $val){
                \fputs($file, "\n    ".$key."=".$val);
            }
            $i++;
        }
        \fclose ($file);
	}
}