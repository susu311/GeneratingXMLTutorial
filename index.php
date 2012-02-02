<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
<?php 
     
class XML_generator
{
    /*
     * XML_generator class is to generate two xml files
     * first xml file is producing timestamps for every 30th of June since the Unix Epoch, at 1pm GMT
     * second xml file is producing timestamps in descending order, excluding years that are prime numbers
     * developed by Su Su Thant
     */


 function generateXML($current)
 {
   //first xml file is producing time stamps for every 30th of June since the Unix Epoch, at 1pm GMT
    $xml = new SimpleXMLElement('<xml/>');
    $stamps=$xml->addChild('timestamps');
    
    $stamp=mktime(13,0,0,6,30,1970);//set the timestamp
  
    for ($stamp ; $stamp< $current; $stamp = strtotime('+1 year', $stamp))
    {
        $timestamp= $stamps->addChild('timestamp');
        $time= $timestamp->addAttribute('time', $stamp);
        $text= $timestamp->addAttribute('text',date('Y-m-d H:i:s', $stamp));
                 
        
    }
     print($xml->asXML());  
     
     //Generating xml file
     $this->file_create("first.xml", $xml);
    
        
    

}
function generateXMLdecending($timeset)
{
   //second xml file is producing timestamps in descending order, excluding years that are prime numbers
   $xml = new SimpleXMLElement('<xml/>');
   $stamps=$xml->addChild('timestamps');
   $stamp= mktime(0,0,0,0,0,1970); //set the timestamp
  
    for ($timeset; $timeset >$stamp; $timeset = strtotime('-1 year', $timeset)){
        
        $year = date('Y', $timeset);
        if ($this->isPrime($year)==0)
        {
       
            $timestamp= $stamps->addChild('timestamp');
            $time= $timestamp->addAttribute('time', $timeset);
            $text= $timestamp->addAttribute('text',date('Y-m-d H:i:s', $timeset));
        }
               
    }
    print($xml->asXML());
     //Generating xml file
    $this->file_create("second.xml", $xml);
    
       
    
}
public function file_create($filename, $xml)
{
    $file = @fopen($filename,'w');
    if(!$file) 
    {
        die('Cannot create XML file');
    }
    fwrite($file,$xml->saveXML());
    fclose($file);
}

public function isPrime($year)
{
    //return 1 if it is prime number year
    //return 0 if it is not prime number year
    $prime = 1;
    if ($year % 2 == 0 && $year != 2)
    {
        return 0;
    } 
    if ($year == 2 || $year == 3) 
    {        
        return 1;
    }
    for ($num = 3; $num < $year; $num++)
    {
        if (($year % $num) == 0)
        {
            $prime = 0;
        }
    }
    return $prime;
}
    
}

      
$xml_file= new XML_generator();
$xml_file->generateXML(time()); //current time
$xml_file->generateXMLdecending(mktime(13,0,0,6,30,2011)); 

?>
</body>
</html>
