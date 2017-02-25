<?php
echo 'Now upload file ing....'."<br/>";
require_once(dirname(__FILE__)."/../util/CommonUtils.php");

//$access_token = CommonUtils::getAccess_token();
$access_token = "ODhBG6UrWWSMn7xGNbCHRXrqbEvnke9ZQyiVO7JXkJhHD57zjxy0SRd4xseqPsSXbXqik5ooadm84YSFeocxcNID19XEiMxwR7s5K1OqCtaCe_oqQc0qPf4VVtsbg9AWQGLiAGAMCH";


echo '$access_token='.$access_token."<br/>";
#上传图片
$type = "voice";
$filepath = dirname(__FILE__)."/../files/music/zgr_daycws.mp3";
$filedata = array("media" => "@".$filepath);
$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=$type";
$result = https_request($url,$filedata);
var_dump($result);




function https_request($url,$data = null){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	if (!empty($data)){
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($curl);
	curl_close($curl);
	return $output;
}