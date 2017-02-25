<?php

require_once("util/CommonUtils.php");
require_once("server/UserCenter.php");
require_once dirname(__FILE__).'/set/BaeLog.class.php';
require_once 'server/WechatCallbackapi.class.php';


define("TOKEN", "zls");

$wechatObj = new WechatCallbackapi();
if (!isset($_GET['echostr'])) {
	CommonUtils::logDebug('微信响应消息。');
    $wechatObj->responseMsg();
}else{
	CommonUtils::logDebug('微信入口校验');
    $wechatObj->valid();
}

?>