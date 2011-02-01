<?php
include("functions.php");
header ("content-type: text/xml");

$url = "http://www.rbcroyalbank.com/rates/cashrates.html";
$data = "download=1";
$code_master = highlight_string(do_post_request($url,$data),true); 

$code = strstr($code_master,"Cash&nbsp;rates&nbsp;for");
$code = substr($code,0,strrpos($code,"NOTES"));

$code_arr = explode("&lt;/tr&gt;",$code);
echo "<?xml version=\"1.0\"?>";
echo "<rate_info>";
$eur_val = 0;
for($i=1;$i<sizeof($code_arr)-1;$i++){
	
	$code = $code_arr[$i];
	$code = str_replace("&lt;td&nbsp;class=\"regulartext\"&gt;","",$code);
	$code = str_replace("&lt;/td&gt;","",$code);
	$code = str_replace("Refer&nbsp;to&nbsp;Euro","0",$code);
	$code = str_replace("&lt;td&nbsp;align=\"center\"&nbsp;class=\"regulartext\"&gt;","|",$code);
	$code = str_replace("&nbsp;","",$code);
	$code = str_replace("&lt;trbgcolor=\"#f1f5f9\"&gt;","",$code);
	$code = str_replace("&lt;trbgcolor=\"#f1f5f9\"style=\"background:white;\"&gt;","",$code);
	$code = str_replace("<br />","",$code);
	
	
	$elements = explode("|",$code);
	if (strpos($code,"AUD") >0 ||strpos($code,"EUR") >0 ||strpos($code,"GBP") >0 ||strpos($code,"INR") >0 ||strpos($code,"SGD") >0 ||strpos($code,"CHF") >0 ||strpos($code,"USD") >0||strpos($code,"AED") >0|| strpos($code,"MYR") >0|| strpos($code,"NOK") >0){
	$j = 0;
	foreach($elements as $value){
		$country_code = strrchr($elements[0],"(");
		$country_code = str_replace("(","",$country_code);
		$country_code = str_replace(")","",$country_code);
		
		if ($country_code == "EUR")
			$eur_val = $eur_val +1;
		
		if ($eur_val == 4 ||$eur_val == 5){
		
		}
		else{
          		if($j==1)
          			echo "<".$country_code . "_b>" . $value . "</".$country_code . "_b>";
          		else if($j==2)
          			echo "<".$country_code . "_s>" . $value . "</".$country_code . "_s>";
          		$j++;
		}
	}
	}
}

echo "</rate_info>";


?>