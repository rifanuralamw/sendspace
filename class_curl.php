<?php

/*   ___    __                         __   
   /   |  / /___ ___  _________  ____/ /__ 
  / /| | / / __ `__ \/ ___/ __ \/ __  / _ \
 / ___ |/ / / / / / / /__/ /_/ / /_/ /  __/
/_/  |_/_/_/ /_/ /_/\___/\____/\__,_/\___/ 

   this class to make code simple
   indonesian coder::almcode/rifanuralamw
   2017
*/
//error_reporting(0);
class curlx{


    public function curl($url, $custom = null){
        global $config;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
     if ($custom['header']) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $custom['header']);
        }
        if ($custom['nobody']){
        curl_setopt($curl, CURLOPT_NOBODY, $custom['nobody']);
    }
        if($custom['timeout']){
        curl_setopt($curl, CURLOPT_TIMEOUT, $custom['timeout']);
      }else{
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
      }

      if($custom['cpost']){
      	curl_setopt($curl, CURLOPT_POST, true);
      }

if($custom['post']){
        if(is_array($custom['post'])){
          $query = http_build_query($custom['post']);
          }else{
          $query = $custom['post'];
        }
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
      } 

        $dir    = dirname(__FILE__);
        $config = $dir . '/cookies/' .rand(1,999999999). '.txt';
        if (!file_exists($config)){
        $fp = @fopen($config, 'w');
        @fclose($fp);
        }
            

        if($custom['proxy']){
        curl_setopt($curl, CURLOPT_PROXY, $custom['proxy']);
        curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        //curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $config);
        curl_setopt($curl, CURLOPT_COOKIEJAR, $config);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl);
        curl_close($curl);
    return array(
        'data'      => $result,
        'status'  => $httpcode['http_code'],
      );
    }

/* curl_getinfo
    "url"
    "content_type"
    "http_code"
    "header_size"
    "request_size"
    "filetime"
    "ssl_verify_result"
    "redirect_count"
    "total_time"
    "namelookup_time"
    "connect_time"
    "pretransfer_time"
    "size_upload"
    "size_download"
    "speed_download"
    "speed_upload"
    "download_content_length"
    "upload_content_length"
    "starttransfer_time"
    "redirect_time"
    "certinfo"
    "primary_ip"
    "primary_port"
    "local_ip"
    "local_port"
    "redirect_url"
    "request_header" (This is only set if the CURLINFO_HEADER_OUT is set by a previous call to curl_setopt())
*/

public function requestMe($path, $json='')
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    $result = json_decode($result);
    curl_close($curl);

    return $result;
	}
}

       function getStr($string,$start,$end){
        $str = explode($start,$string,2);
        $str = explode($end,$str[1],2);
        return $str[0];
    }

function save($almz, $thor ){
    $save = fopen($thor, 'a+');
    fwrite($save,$almz."\r\n");
    fclose($save);
    }

  function delete_cookies()
    {
    global $config;
    $fp = @fopen($config, 'w');
    @fclose($fp);
    }

 function getcookie1($result){
        // get cookie, all cos sometime set-cookie could be more then one
            preg_match_all('/^Set-Cookie:\s*([^\r\n]*)/mi', $result, $ms);
            // print_r($result);
            $cookies = array();
            //if(is_array($ms)){
            foreach ($ms[1] as $m) {
                list($name, $value) = explode('=', $m, 2);
                $cookies[$name] = $value;
            }
         // }
            return $cookies;
    }

  function getcookie2($result)
    {
    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
    
    $cookies = array();
    if(is_array($matches)){
    foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}
    }
    return $cookies;
 }   

function proses($total, $number)
	{
		if ( $total > 0 ) {
			return round($number / ($total / 100),2);
		} else {
			return 0;
		}
	}

function Nomor($i, $total)
	{
		if(strlen($i) < $total){
			return str_pad($i,strlen($total),'0',STR_PAD_LEFT);
		}else{
			return $i;
		}
	}
?>
