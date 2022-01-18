<?php
$access_log = $argv[1];
$handle = fopen($access_log,'r') or die ('Файл access_log не удалось открыть');
$file = file_get_contents('script.json');
$google=0;
$bing=0;
$yandex=0;
$baidu=0;
$score = 0;
$score2 = 0;
$count=array();
$urlcount=1;
$traffic=0;
$views=0;
$url=array();

    /*$dd = fgets($handle); 
    $parts = explode('"', $dd);
    if (hasType($parts[1], 'POST'))
    { 
        $traffic=$traffic+intval(substr($parts[2], 4));
    }
    $score++; */




//while (!feof($handle)) {

for ($i=0;$i<count(file($access_log)); $i++) {

    $dd = fgets($handle);
    $parts = explode('"', $dd);
    $url[$i] = $parts[3]; // URL
    $count=array(intval($parts[0]));
    $views++;


    
    if (hasType($parts[5], 'Google')) $google++;
    if (hasType($parts[5], 'Bing')) $bing++;
    if (hasType($parts[5], 'Yandex')) $yandex++;
    if (hasType($parts[5], 'Baidu')) $baidu++;
    if (hasType($parts[2], '200')) $score++;
    if (hasType($parts[2], '301')) $score2++;
    if (hasType($parts[1], 'POST'))
    {
        $traffic=$traffic+intval(substr($parts[2], 4));
    }

 
    
}

print_r($url);
$urlcount = count($url);



$arr = array (
    'views'=>$views,'urls'=>$urlcount,'traffic'=>$traffic,'crawlers'=>array("Google"=>$google,"Bing"=>$bing,"Baidu"=>$baidu,"Yandex"=>$yandex),'statusCode'=>array("200"=>$score,"301"=>$score2));

echo json_encode($arr,JSON_PRETTY_PRINT);

$taskList = json_decode($file,TRUE);                    
unset($file);
$taskList[] = array ('views'=>$views,'urls'=>$urlcount,'traffic'=>$traffic,'crawlers'=>array("Google"=>$google,"Bing"=>$bing,"Baidu"=>$baidu,"Yandex"=>$yandex),'statusCode'=>array("200"=>$score,"301"=>$score2));       
file_put_contents('script.json',json_encode($taskList,JSON_PRETTY_PRINT));      
unset($taskList);     

fclose($handle);

function hasType($l,$s) {
        return substr_count($l,$s) > 0;
}

?>

