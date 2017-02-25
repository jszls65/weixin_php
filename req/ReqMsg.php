<?php
/**
 * 接收信息逻辑处理类
 * @author zhangls
 *
 */

require_once(dirname(__FILE__)."/../util/CommonUtils.php");
require_once(dirname(__FILE__)."/../server/UserCenter.php");
require_once dirname(__FILE__).'/../resp/RespMsg.php';
require_once dirname(__FILE__).'/../server/Suggestion.class.php';
class ReqMsg{
	
	
	//接收图片消息
	/*public static function receiveImage($object)
	{
		$content = array("MediaId"=>$object->MediaId);
		$result = RespMsg::transmitImage($object, $content);
		return $result;
	}*/
	
	//接收图片消息--人脸设别
	public static function receiveImage($object)
	{	CommonUtils::logDebug('触发人脸设别方法。');//log
		$faceAPI_KEY = '997d56c04d12f85149bf2ee73d981ea6';
		$faceSECRET = 'Xz3bMNvIHfDZioMZEQE-tBcEg3U80R5v';
		$picUrl = $object->PicUrl;
		$apicallurl = "http://apicn.faceplusplus.com/v2/detection/detect?api_key=$faceAPI_KEY&api_secret=$faceSECRET&url=$picUrl&attribute=glass,pose,gender,age,race,smiling";
				
// 		CommonUtils::logDebug('$apicallurl:'.$apicallurl);//log
		$pictureJsonInfo = file_get_contents($apicallurl);
		CommonUtils::logDebug('$pictureJsonInfo:'.$pictureJsonInfo);
		
		
		$contentStr = '';
		$pictureInfo = json_decode($pictureJsonInfo, true);
		try {
			$facesize = count($pictureInfo['face']);
			if($facesize && $facesize>0){
				$contentStr = "检测到".$facesize."张面孔".($facesize > 1? "，从左到右依次为" : "")."：\n";
				$faces = $pictureInfo['face'];
				$i = 0;
				foreach ($faces as $face){
					$i++;
					$age = $face['attribute']['age']['value'];
					$sex = $face['attribute']['gender']['value'];
					$sexStr = "未知";
					$ta = "它";
					if($sex == 'Male'){
						$sexStr = '男性';
						$ta = "他";
					}else if($sex == 'Female'){
						$sexStr = '女性';
						$ta = "她";
					}
					$race = $face['attribute']['race']['value'];
					$raceDu = $face['attribute']['race']['confidence'];
					$raceStr = '肤色正常';
					switch ($race){
						case $race == 'White' && $raceDu<80:
							$raceStr = '皮肤黝黑';
							break;
						case $race == 'White' && ($raceDu>=80 && $raceDu<90) :
							$raceStr = '肤色正常';
							break;
						case $race == 'White' && $raceDu>=90 :
							$raceStr = '皮肤白皙';
							break;
						case 'Black':
							$raceStr = '皮肤黝黑';
							break;
						case 'Asian':
							$raceStr = '肤色正常';
							break;
						default:
							$raceStr = '肤色难设别';
							break;
								
							
					}
					
					
					$smiling = $face['attribute']['smiling']['value'];
					$smilingStr = '面无表情';
					switch ($smiling){
						case $smiling>20 && $smiling<=40 :
							$smilingStr = '面带笑容';
							break;
						case $smiling>40 && $smiling<=60 :
							$smilingStr = '笑靥如花';
							break;
						case $smiling>60 && $smiling<=80 :
							$smilingStr = '开怀大笑';
							break;
						case $smiling>80 && $smiling<=100 :
							$smilingStr = '哈哈大笑';
							break;
					}
					if($facesize>1){
						$contentStr .= $i.'：'.$ta.'是';
					}else{
						$contentStr .= $ta.'是';
					}
					$contentStr .= $raceStr.'，'.$smilingStr.'，年龄'.$age.'岁的'.$sexStr."\n";
					
					
				}
			}else{
				$contentStr = '未检测到人脸！！！！！！';
			}
			CommonUtils::logDebug('facesize:'.$facesize) ;
		} catch (Exception $e) {
			CommonUtils::logDebug($e->getMessage());
		}
		
		
		
		
		$resultStr = RespMsg::transmitText($object,$contentStr);
		
		return $resultStr;
	}
	
	
	
	
	//接收文本消息
	public static function receiveText($object)
	{
		$keyword = trim($object->Content);
		CommonUtils::logDebug('用户输入:'.$keyword);
		//多客服人工回复模式
		if (strstr($keyword, "请问在吗") || strstr($keyword, "在线客服")){
			$result = RespMsg::transmitService($object);
			return $result;
		}
		
		//首先处理意见反馈问题
		$suggestion = new Suggestion();
		$status = $suggestion->isOpenSuggesion($object->FromUserName);
		CommonUtils::logDebug("意见反馈状态：".$status);
		if($status == 1){
			$content = $suggestion->update($object->FromUserName, $keyword);
			$result = RespMsg::transmitText($object, $content);
			return $result;
			
		}
	
		//4 6级成绩查询  server/live/cet46.php
		include dirname(__FILE__).'/../server/live/cet46.php';
		if(preg_match_all("/^([\x{4e00}-\x{9fa5}]{2,4})(\d{15})/u",$keyword,$cet46info)){
			$cet46Name = substr($cet46info[1][0], 0,6);
			//$cet46Name_gb2312 = urlencode(mb_convert_encoding($cet46Name, 'gb2312','utf-8'));
			$cet46Number = $cet46info[2][0];
			$result = getCET46Info($cet46Name, $cet46Number);
			return $result;
		}
	
		//星座
		$capitals = array('白羊座' => '1','金牛座' => '2','双子座' => '3','巨蟹座' => '4','狮子座' => '5','处女座' => '6','天秤座' => '7',
				'天蝎座' => '8','射手座' => '9','摩羯座' => '10','水瓶座' => '11','双鱼座' => '12');
		//自动回复模式
		if ($keyword == "答题" || preg_match("/^[A-Fa-f]$/", $keyword)){
			include(dirname(__FILE__)."/../server/amuse/question.php");
			$content = getQuestionInfo($object->FromUserName, (($keyword == "答题")?$keyword:strtoupper(trim($object->Content))));
		}else
		//星座运势
		if (array_key_exists($keyword, $capitals))
		{
			include(dirname(__FILE__)."/../server/amuse/astrology.php");
			$content = getAstrologyInfo($keyword,$capitals);
		}else
		if (strstr($keyword, "1")){
			$content = "1111111111111";
		}else if (strstr($keyword, "文本")){
			$content = "这是个文本消息";
		}else if (strstr($keyword, "表情")){
			try{
	
				$content = "中国：".CommonUtils::bytes_to_emoji(0x1F1E8)
				.CommonUtils::bytes_to_emoji(0x1F1F3)."\n仙人掌："
						.CommonUtils::bytes_to_emoji(0x1F335);
			}catch(Exception $e){
				echo 'Message: ' .$e->getMessage();
			}
	
		}else if (strstr($keyword, "单图文")){
			$content = array();
			$content[] = array("Title"=>"单图文标题",  "Description"=>"单图文内容", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
		}else if (strstr($keyword, "图文") || strstr($keyword, "多图文")){
			$content = array();
			$content[] = array("Title"=>"多图文1标题", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
			$content[] = array("Title"=>"多图文2标题", "Description"=>"", "PicUrl"=>"http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
			$content[] = array("Title"=>"多图文3标题", "Description"=>"", "PicUrl"=>"http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
		}else if (strstr($keyword, "音乐")){
			$content = array();
			$content = array("Title"=>"当爱已成往事", "Description"=>"歌手：张国荣", "MusicUrl"=>"http://jszlswx.duapp.com/files/music/zgr_daycws.mp3", "HQMusicUrl"=>"http://jszlswx.duapp.com/files/music/zgr_daycws.mp3");
		}else if (strstr($keyword, "模板")){
			include(dirname(__FILE__)."/../server/Template.class.php");
			CommonUtils::logDebug('调用模板方法');
			$template = new Template();
			$content = $template->getTemplate_jytx($object);
			
		}else {
			//进入智能聊天机器人
			include(dirname(__FILE__)."/../server/amuse/XiaoiBot.php");
			$url = 'http://sandbox.api.simsimi.com/request.p?key=df3c679b-f20a-4bdc-9592-c8730169fa32&ft=0.0&lc=ch&text='.$keyword;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
			$content = curl_exec($ch);
			curl_close($ch);
			
		}
	
		if(is_array($content)){
			if (isset($content[0])){
				$result = RespMsg::transmitNews($object, $content);
			}else if (isset($content['MusicUrl'])){
				$result = RespMsg::transmitMusic($object, $content);
			}
		}else{
			$result = RespMsg::transmitText($object, $content);
		}
		return $result;
	}
	
	
	
	//接收位置消息
	public static function receiveLocation($object)
	{
		$content = "你发送的是位置，经度为：".$object->Location_Y."；纬度为：".$object->Location_X."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
		$result = RespMsg::transmitText($object, $content);
		return $result;
	}
	
	
	
	
	//接收语音消息
	public static function receiveVoice($object)
	{
		if (isset($object->Recognition) && !empty($object->Recognition)){
			$content = "你刚才说的是：".$object->Recognition;
			$result = RespMsg::transmitText($object, $content);
		}else{
			$content = array("MediaId"=>$object->MediaId);
			$result = RespMsg::transmitVoice($object, $content);
		}
		return $result;
	}
	
	

	//接收链接消息
	public static function receiveLink($object)
	{
		$content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
		$result = RespMsg::transmitText($object, $content);
		return $result;
	}
	
	
	
	//接收视频消息
	public static function receiveVideo($object)
	{
		$content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
		$result = RespMsg::transmitVideo($object, $content);
		return $result;
	}
}