<?php
/**
 * 接收实现逻辑处理类
 * @author zhangls
 *
 */
require_once(dirname(__FILE__)."/../util/CommonUtils.php");
require_once(dirname(__FILE__)."/../server/UserCenter.php");
require_once dirname(__FILE__).'/../server/Suggestion.class.php';
class ReqEvent{
	//接收事件消息
	public static function receiveEvent($object)
	{
		CommonUtils::logDebug('接收事件方法开始执行。。。。');
		 
		$content = "";
		switch ($object->Event)
		{
			case "subscribe":
				$content = "欢迎关注生活服务公众号 , 么么哒~~";
				/*
				 * try {
					$userCenter = new UserCenter();
					$access_token = CommonUtils::getAccess_token();
					$userCenter->saveUser($object->FromUserName, $access_token);
				} catch (Exception $e) {
					//$log->Debug($e);
				}
				 * */
				break;
			case "unsubscribe":
				$content = "取消关注";
				break;
			case "CLICK":
				CommonUtils::logDebug('触发自定义菜单事件。');
				switch ($object->EventKey)
				{
					//快递查询
					case "MENU01_WEATHERFORECAST":
						$content = array();
						$content[] = array("Title"=>"jszls65@qq.com", "Description"=>"", "PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", "Url" =>"http://m.cnblogs.com/?u=txw1958");
						break;
						//46级查询
					case "MENU01_CET46":
						$content = "请回复：姓名+15位准考证号。\n格式如：\n张三\n324401903244019";
						break;
						//交通信息
					case "MENU01_TRAFFICINFO":
						include dirname(__FILE__).'/../server/live/traffic.php';
						$content = array();
						$content = getTrafficInfo($object);
						break;
						//笑话
					case "MENU02_JOKE":
						include dirname(__FILE__).'/../server/amuse/joke.php';
						$content = getJokeInfo();
						break;
						//星座运势
					case "MENU02_CONSTELLATION":
						$content = "请输入星座名称。如：巨蟹座";
						break;
					//意见反馈
					case "MENU03_SUGGESTION":
						$suggestion = new Suggestion();
						$content = $suggestion->open($object->FromUserName);
						break;
					case "MENU02_GAME":
						$content = "请输入以下内容开始进入游戏：\n答题";
						break;
					case "MENU02_SMARTCHART":
						$content = "阁下，智能聊天机器人已经恭候多时了，尽情的调戏我吧。。。。。。";
						break;
					case "MENU03_ABOUTUS":
						include(dirname(__FILE__)."/../server/Template.class.php");
						CommonUtils::logDebug('调用模板方法');
						$template = new Template();
						$content = $template->getTemplate_aboutus($object);
						break;
					case "MENU02_CHECKFACE":
						$content = "请发送一张带有笑脸的图片";
						break;
					default:
						$content = "点击菜单：".$object->EventKey;
						break;
				}
				break;
			case "VIEW":
				$content = "跳转链接 ".$object->EventKey;
				break;
			case "SCAN":
				$content = "扫描场景 ".$object->EventKey;
				break;
			case "LOCATION":
				$content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
				break;
			case "scancode_waitmsg":
				if ($object->ScanCodeInfo->ScanType == "qrcode"){
					$content = "扫码带提示：类型 二维码 结果：".$object->ScanCodeInfo->ScanResult;
				}else if ($object->ScanCodeInfo->ScanType == "barcode"){
					$codeinfo = explode(",",strval($object->ScanCodeInfo->ScanResult));
					$codeValue = $codeinfo[1];
					$content = "扫码带提示：类型 条形码 结果：".$codeValue;
				}else{
					$content = "扫码带提示：类型 ".$object->ScanCodeInfo->ScanType." 结果：".$object->ScanCodeInfo->ScanResult;
				}
				break;
			case "scancode_push":
				$content = "扫码推事件";
				break;
			case "pic_sysphoto":
				$content = "系统拍照";
				break;
			case "pic_weixin":
				$content = "相册发图：数量 ".$object->SendPicsInfo->Count;
				break;
			case "pic_photo_or_album":
				$content = "拍照或者相册：数量 ".$object->SendPicsInfo->Count;
				break;
			case "location_select":
				$content = "发送位置：标签 ".$object->SendLocationInfo->Label;
				break;
			default:
				$content = "receive a new event: ".$object->Event;
				break;
		}
	
		if(is_array($content)){
			if (isset($content[0]['PicUrl'])){
				$result = RespMsg::transmitNews($object, $content);
			}else if (isset($content['MusicUrl'])){
				$result = RespMsg::transmitMusic($object, $content);
			}
		}else{
			$result = RespMsg::transmitText($object, $content);
		}
		return $result;
	}
	
}
