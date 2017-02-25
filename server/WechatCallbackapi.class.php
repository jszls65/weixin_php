<?php
require_once dirname(__FILE__).'/../req/ReqMsg.php';
require_once dirname(__FILE__).'/../req/ReqEvent.php';

/**
 * 微信API
 * @author zhangls
 *
 */
class WechatCallbackapi
{
	//验证签名
	public function valid()
	{
		$echoStr = $_GET["echostr"];
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
		if($tmpStr == $signature){
			echo $echoStr;
			exit;
		}
	}

	//响应消息
	public function responseMsg()
	{
		CommonUtils::logDebug('响应消息方法开始执行。。。。');
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){
			CommonUtils::logDebug("R \r\n".$postStr);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$RX_TYPE = trim($postObj->MsgType);

			if (($postObj->MsgType == "event") && ($postObj->Event == "subscribe" || $postObj->Event == "unsubscribe")){
				//过滤关注和取消关注事件
			}else{

			}

			//消息类型分离
			switch ($RX_TYPE)
			{
				case "event":
					try {
						$result = ReqEvent::receiveEvent($postObj);
					} catch (Exception $e) {
						CommonUtils::logDebug($e->getMessage());
					}
					break;
				case "text":
					 
					$result = ReqMsg::receiveText($postObj);
					break;
				case "image":
					$result = ReqMsg::receiveImage($postObj);
					break;
				case "location":
					$result = ReqMsg::receiveLocation($postObj);
					break;
				case "voice":
					$result = ReqMsg::receiveVoice($postObj);
					break;
				case "video":
					$result = ReqMsg::receiveVideo($postObj);
					break;
				case "link":
					$result = ReqMsg::receiveLink($postObj);
					break;
				default:
					$result = "unknown msg type: ".$RX_TYPE;
					break;
			}
			CommonUtils::logDebug("T \r\n".$result);
			echo $result;
		}else {
			echo "";
			exit;
		}
	}
}
			
			
