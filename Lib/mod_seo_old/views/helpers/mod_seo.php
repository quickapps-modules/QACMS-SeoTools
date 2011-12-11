<?php

ini_set("max_execution_time",99999);
define("WORD_LIMIT",5); //word limit of words with which be spin or translate 

class ModSeoHelper extends Helper {

	private $oldContent="";
    private $suggestContent="";
    
    /**
     * Function to generate spinContent by using online thesaurus
     *
     *@author Rochak Chauhan <rochak@dmwtechnologies.com>
     *@access Public   
     *@param string $content   
     *@return string         
     */          
    public function spinContent($content){
        $this->oldContent=$content;
        $tmp=explode(" ",$this->oldContent);
        $c=count($tmp);
        for($i=0;$i<$c;$i++){
            $word=trim($tmp[$i]);
            $suggestions="";
            if(strlen($word)>WORD_LIMIT){
                $url="http://freethesaurus.net/suggest.php?q=$word";            
                $suggestions=$this->getHtmlCodeViaFopen($url);
                $suggestions=str_replace("\r",", ",$suggestions);
                $suggestions=str_replace("\n",", ",$suggestions);
                $suggestions=str_replace("\r\n",", ",$suggestions);
            }
            $this->suggestContent[]=array($word,$suggestions);
        }        
        $c=count($this->suggestContent);
        for($i=0;$i<$c;$i++){
            $word=$this->suggestContent[$i][0];
            $temp=trim($this->suggestContent[$i][1]);            
            if(strlen($temp)>0){
                $code="{";
                $tmp=explode(",",$temp);
                $c=count($tmp);
                for($j=0;$j<$c;$j++){
                    $opt=trim($tmp[$j]);
                    if(!empty($opt)){
                        $code.="$opt|";
                    }
                }
                $opt=substr($opt,0,strlen($opt)-1);
                $code.="}";
                $this->oldContent=str_replace($word,$code,$this->oldContent);
            }
        }
        return $this->oldContent;
    }
    
    /**
     * Function to generate random text by spinning some keywords (Single Level / No Nesting)
     *
     *@author Rochak Chauhan <rochak@dmwtechnologies.com>
     *@access Public   
     *@param string $content        
     *@return string    
     */ 
    function runTextSpinnerSingle($content){
        $returnArray=array();
        $pattern="/{(.*)}/Uis";
        preg_match_all($pattern, $content, $returnArray, PREG_SET_ORDER);
        foreach($returnArray as $return){
            $code=$return[0];
            $str=$return[1];
            $str=substr($str,0,strlen($str)-1);
            $tmp=explode("|",$str);
            $c=count($tmp);
            $rand=rand(0,($c-1));            
            $word=$tmp[$rand];
            $content=str_replace($code,$word,$content);
        }
        return $content;
    }
    
    /**
     * Function to generate random text by spinning some keywords (Multi Level / Nesting upto n Levels)
     *
     *@author Rochak Chauhan <rochak@dmwtechnologies.com>
     *@access Public   
     *@param string $content        
     *@return string    
     */ 
    function runTextSpinner($content){
        $returnArray=array();
        $pattern="/\{[^\{]+?\}/ixsm";
        preg_match_all($pattern, $content, $returnArray, PREG_SET_ORDER);
        foreach($returnArray as $return){
            $code=$return[0];  
            $str=str_replace("{","",$code);
            $str=str_replace("}","",$str);   
            $tmp=explode("|",$str);
            $c=count($tmp);
            $rand=rand(0,($c-1));   
            $word=$tmp[$rand];
            $content=str_replace($code,$word,$content);
        }  
        $pos=strpos($content,"{");
        if($pos===false){
            return $content;
        } 
        else{
            return $this->runTextSpinner($content);
        } 
    }
    
    /**
     *Function to download remote content of an URL via fopen
     *
     *@author Rochak Chauhan   <rochak@dmwtechnologies.com>
     *@param string $url
     *@access private
     *@return string
     */
    private function getHtmlCodeViaFopen($url){
        $returnStr="";
        $fp=fopen($url, "r") or die("ERROR: Failed to open $url for reading via this script.");
        while (!feof($fp)) {
            $returnStr.=fgetc($fp);
        }
        fclose($fp);
        return $returnStr;
    } 	

}
?>