<?php

require_once dirname(__FILE__).'/../set/BaeLog.class.php';
/**
 * Created by PhpStorm.
 * User: zhangls
 * Date: 16/9/20
 * Time: 23:29
 */
class CommonUtils {
	// 字节转Emoji表情
	public static function bytes_to_emoji($cp) {
		if ($cp > 0x10000) { // 4 bytes
			return chr ( 0xF0 | (($cp & 0x1C0000) >> 18) ) . chr ( 0x80 | (($cp & 0x3F000) >> 12) ) . chr ( 0x80 | (($cp & 0xFC0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else if ($cp > 0x800) { // 3 bytes
			return chr ( 0xE0 | (($cp & 0xF000) >> 12) ) . chr ( 0x80 | (($cp & 0xFC0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else if ($cp > 0x80) { // 2 bytes
			return chr ( 0xC0 | (($cp & 0x7C0) >> 6) ) . chr ( 0x80 | ($cp & 0x3F) );
		} else { // 1 byte
			return chr ( $cp );
		}
	}
	
	/**
	 * 处理URL
	 * 
	 * @param unknown $url        	
	 * @return string mixed
	 */
	public static function https_request($url) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$data = curl_exec ( $curl );
		if (curl_errno ( $curl )) {
			return 'ERROR ' . curl_error ( $curl );
		}
		curl_close ( $curl );
		return $data;
	}
	
	/**
	 * 根据url-API接口获取对象
	 * @param unknown $url
	 */
	public static function getObjByUrl($url){
		if($url==NULL || $url==""){
			return NULL;
		}
		$output = $this->https_request($url);
		return json_decode($output,true);
	}
	
	
	/**
	 * 获取$access_token
	 */
	public static function getAccess_token(){
		$appid = "wx9567756ece4456c9";
		$appsecret = "d4ffefc5f3ec9a452838bde679d8f090";
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		$jsoninfo = json_decode($output, true);
		$access_token = $jsoninfo["access_token"];
		
		
		
		return $access_token;
	}
	
	public static function logDebug($logmsg) {
		$secret = array("user"=>"b933d97d22464dceb2b0d5f54a18170d","passwd"=>"510ede6dcdb545bcb61abbc4f9a06a5e" );
		$log = BaeLog::getInstance($secret);
		$log->Debug($logmsg);
	}
	
}