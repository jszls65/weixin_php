<?php

/**
 * 响应信息逻辑处理类
 * @author zhangls
 *
 */
class RespMsg{
	
	
	//回复文本消息
	public static function transmitText($object, $content)
	{
		if (!isset($content) || empty($content)){
			return "";
		}
	
		$xmlTpl = "<xml>
    		<ToUserName><![CDATA[%s]]></ToUserName>
    		<FromUserName><![CDATA[%s]]></FromUserName>
    		<CreateTime>%s</CreateTime>
    		<MsgType><![CDATA[text]]></MsgType>
    		<Content><![CDATA[%s]]></Content>
			</xml>";
		$result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
	
		return $result;
	}
	
	
	


	//回复图文消息
	public static function transmitNews($object, $newsArray)
	{
		if(!is_array($newsArray)){
			return "";
		}
		$itemTpl = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        	</item>";
		$item_str = "";
		foreach ($newsArray as $item){
			$item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
		}
		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[news]]></MsgType>
			<ArticleCount>%s</ArticleCount>
			<Articles>$item_str</Articles>
			</xml>";
	
		$result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
		return $result;
	}
	


	//回复音乐消息
	public static function transmitMusic($object, $musicArray)
	{
		if(!is_array($musicArray)){
			return "";
		}
		$itemTpl = "<Music>
	        <Title><![CDATA[%s]]></Title>
	        <Description><![CDATA[%s]]></Description>
	        <MusicUrl><![CDATA[%s]]></MusicUrl>
	        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
	    	</Music>";
	
		$item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);
	
		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[music]]></MsgType>
			$item_str
			</xml>";
	
		$result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
		return $result;
	}
	
	
	


	//回复图片消息
	public static function transmitImage($object, $imageArray)
	{
		$itemTpl = "<Image>
        <MediaId><![CDATA[%s]]></MediaId>
    </Image>";
	
		$item_str = sprintf($itemTpl, $imageArray['MediaId']);
	
		$xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>$item_str</xml>";
	
		$result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
		return $result;
	}
	
	//回复语音消息
	public static function transmitVoice($object, $voiceArray)
	{
		$itemTpl = "<Voice>
			<MediaId><![CDATA[%s]]></MediaId>
    		</Voice>";
	
        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);
	        $xmlTpl = "<xml>
	        		<ToUserName><![CDATA[%s]]></ToUserName>
	        		<FromUserName><![CDATA[%s]]></FromUserName>
	        		<CreateTime>%s</CreateTime>
	        		<MsgType><![CDATA[voice]]></MsgType>
	        		$item_str
	        		</xml>";
	
		$result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
		return $result;
	}
	
	//回复视频消息
		public static function transmitVideo($object, $videoArray)
		{
		$itemTpl = "<Video>
		<MediaId><![CDATA[%s]]></MediaId>
        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
    </Video>";
	
        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);
	
	        $xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
	    <FromUserName><![CDATA[%s]]></FromUserName>
	    <CreateTime>%s</CreateTime>
	    <MsgType><![CDATA[video]]></MsgType>
	    $item_str
	    </xml>";
	
	    $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
	    return $result;
		}
	
		//回复多客服消息
		public static function transmitService($object)
		{
		$xmlTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
	        return $result;
		}
	
		//回复第三方接口消息
		public static function relayPart3($url, $rawData)
		{
		$headers = array("Content-Type: text/xml; charset=utf-8");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
	        $output = curl_exec($ch);
	        curl_close($ch);
	        return $output;
		}
		 
}