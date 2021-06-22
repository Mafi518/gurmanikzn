<?php

session_start();

$link = mysqli_connect("localhost", "kornilov1297", "Kornilov12", "kornilov1297");

$token_poster = '741029:89174511381b0a0f01b06e4293737bff';


$hash = rand(100000,999999);


// FUNCTIONS

function setSql($p){
	$sets = '';
	foreach($p as $key => $value){
		if($value!=''){
			if($sets!='') $sets .= ', ';
			$sets .= $key."='".mysqli_real_escape_string($GLOBALS['link'],$value)."'";
		}
	}
	return $sets;
}

function setSqlCols($p,$cols){
	$sets = '';
	foreach($p as $key => $value){
		$check = false;
		foreach($cols as $col){
			if($col==$key) $check = true;
		}
		if($value!='' AND $check){
			if($sets!='') $sets .= ', ';
			$sets .= $key."='".mysqli_real_escape_string($GLOBALS['link'],$value)."'";
		}
	}
	return $sets;
}

function sendRequest($url, $type = 'get', $params = [], $json = false)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    if ($type == 'post' || $type == 'put') {
        curl_setopt($ch, CURLOPT_POST, true);

        if ($json) {
            $params = json_encode($params);

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params)
            ]);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
    }

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Poster (http://joinposter.com)');

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function getPhone($phone){
    $phone = trim($phone);
    if($phone){
        $phone = ''.preg_replace('/^[\+78]+/','',$phone);
        // $phone = preg_replace('/[\(\)\- ]/i','',$phone);
        $phone = preg_replace('/[^0-9]/','',$phone);
        // $phone = '+'.$phone;
    }
    return $phone;
};

?>