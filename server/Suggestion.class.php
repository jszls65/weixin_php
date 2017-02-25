<?php
/**
 * 意见反馈类
 * @author zhangls 
 * @date 2016-10-31 21:45:34
 */

class Suggestion{
	
	//无参构造函数
	function __construct() {
		
		
	}
	
	/**
	 * 打开
	 * @param unknown $openid
	 */
	function open($openid){
		
		#先判断是否开启
		$isOpen = $this->isOpenSuggesion($openid);
		if($isOpen == 1){
			return "系统已经开启意见反馈功能，请提交意见内容，我们将会认真记录您随后输入的内容并在后期给予反馈。";
		}else{
			$result = $this->insert($openid);
			if($result != false){
				return "意见反馈功能已成功开启，请提交意见内容。";
			}
		}
		return "额。。。。非常抱歉！意见反馈功能异常，工作人员正在紧急排查问题，请耐心等待。。。";
	}
	
	
	/**
	 * 更新状态
	 */
	function update($openid,$content){
		$res = "";
		$con = mysql_connect("sqld.duapp.com:4050","80Zp2K738SsjCO4eLTx7rsn8","eC5al1iv0fEG7pQ6ENmVGx8FW6p6ciCx");
		if (!con)
		{
			echo 'Could not get mysql connect !!';
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("hbvjLNkbBAvsNjqTXsVC", $con);
		$sql = "update suggestion set updatedate = now(),status=2,content='"
			.$content."' where id =(select a.id from (select max(b.id) id from suggestion b  where b.openid = '".$openid."' ) a) ";
		CommonUtils::logDebug('function update $sql:'.$sql);
		$result = mysql_query($sql);
		if(!$result){
			$res = '系统在记录您的意见内容时发生错误。';
		}else{
			$res = "您的意见内容已成功提交，我们将会认真记录并在后期给予反馈。\n\n<a href=\"http://www.baidu.com/\">点击链接查看历史提交记录</a>";
		}
		mysql_close($con);
		return $res;
	}
	
	/**
	 * 插入
	 * @param unknown $openid
	 * @return resource
	 */
	function  insert($openid){
		$res = "";
		$con = mysql_connect("sqld.duapp.com:4050","80Zp2K738SsjCO4eLTx7rsn8","eC5al1iv0fEG7pQ6ENmVGx8FW6p6ciCx");
		if (!con)
		{
			echo 'Could not get mysql connect !!';
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("hbvjLNkbBAvsNjqTXsVC", $con);
		$sql = "insert into suggestion (openid,createdate,status) values ('".$openid."',now(),1)";
		$result = mysql_query($sql);
		if(!$result){
			$res = '系统在记录您的意见内容时发生错误。';
		}else{
			$res = "您的意见内容已成功提交，我们将会认真记录并在后期给予反馈。\n\n<a href=\"http://www.baidu.com/\">点击链接查看历史提交记录</a>";
		}
		mysql_close($con);
		return $res;
	}
	
	
	
	/**
	 * 判断某个人的意见反馈是否开启
	 * @param unknown $openid
	 * @return int $status 0-无记录  1-未完成  2-完成
	 */
	function isOpenSuggesion($openid){
		$con = mysql_connect("sqld.duapp.com:4050","80Zp2K738SsjCO4eLTx7rsn8","eC5al1iv0fEG7pQ6ENmVGx8FW6p6ciCx");
		if (!con)
		{
			echo 'Could not get mysql connect !!';
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("hbvjLNkbBAvsNjqTXsVC", $con);
		
		$sql = "select * from suggestion where id =(select max(id) from suggestion b where openid = '".$openid."' ) ";
		
		$result = mysql_query($sql,$con);
		
		$status = 0;
		CommonUtils::logDebug('function isOpenSuggesion $sql:'.$sql);
		CommonUtils::logDebug('function isOpenSuggesion $result:'.$result);
		while($row = mysql_fetch_array($result))
		{
			$status = $row['status'];
			break;
		}
		CommonUtils::logDebug('function isOpenSuggesion $status:'.$status);
		mysql_close($con);
		
		return  $status;
		
	}
	
	
}
