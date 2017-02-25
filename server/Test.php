<?php
require_once(dirname(__FILE__)."/../util/CommonUtils.php");

$url = 'http://apicn.faceplusplus.com/v2/detection/detect?api_key=997d56c04d12f85149bf2ee73d981ea6&api_secret=Xz3bMNvIHfDZioMZEQE-tBcEg3U80R5v&url=http://mmbiz.qpic.cn/mmbiz_jpg/3Iktdic3jFqJiajfoBsu9p2tkqhcPVQTroHWChIdTWc7amLvazFlMXDYFcvH35kaKT2HibrV3rfvZVyTsYufic1Z9w/0&attribute=glass,pose,gender,age,race,smiling';
//$pictureJsonInfo = file_get_contents($url);
$pictureJsonInfo = file_get_contents($url);
$pictureInfo = json_decode($pictureJsonInfo, true);
echo '------------------------------------------------------------<br/><br/>';
echo $pictureInfo['face'][0]['attribute']['age']['value'].'<br/>';

echo '------------------------------------------------------------<br/><br/>';

try {
	$facesize = count($pictureInfo['face']);
	if($facesize && $facesize>0){
		$faces = $pictureInfo['face'];
		foreach ($faces as $face){
			echo 'age:'.$face['attribute']['age']['value'];
		}
	}
	echo 'facesize:'.$facesize;	
} catch (Exception $e) {
	echo $e->getMessage();
}