<?php
require_once dirname(__FILE__).'/'.'../util/CommonUtils.php';
require_once dirname(__FILE__).'/'.'../util/DBUtils.php';
/**
 * 用户中心
 * 业务逻辑类
 * @author zhangls
 *
 */
class UserCenter{
	
	/**
	 * 对象转换成数组
	 * @param unknown $obj
	 * @return unknown
	 */
	function object_to_array($obj){
		if(is_array($obj)){
			return $obj;
		}
		$_arr = is_object($obj)? get_object_vars($obj) :$obj;
		foreach ($_arr as $key => $val){
			$val=(is_array($val)) || is_object($val) ? $this->object_to_array($val) :$val;
			$arr[$key] = $val;
		}
	
		return $arr;
		 
	}
	
	
	/**
	 * 把对象转化为json
	 */
	function object_to_json($obj){
		$arr2=$this->object_to_array($obj);//先把对象转化为数组
		return json_encode($arr2);
	}

	/**
	 * 保存用户信息
	 * @param unknown $openId
	 * @param unknown $access_token
	 * @return unknown
	 */
	function saveUser($openId, $access_token) {
		if($access_token==""){
			$access_token = CommonUtils::getAccess_token();			
		}
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openId&lang=zh_CN";
		$jsoninfo = CommonUtils::getObjByUrl($url);
	
		
		$nickname =  $jsoninfo["nickname"] ;
		$sex = $jsoninfo["sex"];
		$country = $jsoninfo["country"];
		$province = $jsoninfo["province"];
		$city = $jsoninfo["city"];
		$language = $jsoninfo["language"];
		$subscribe_time = $jsoninfo["subscribe_time"];
		
		
		
		
		//获取连接
		$dbUtils = new DBUtils();
		//$con = mysql_connect("sqld.duapp.com:4050","80Zp2K738SsjCO4eLTx7rsn8","eC5al1iv0fEG7pQ6ENmVGx8FW6p6ciCx");
		$con = $dbUtils->getConn();
		//1查询是否存在
		try {
			$sql_isExsit = "select * from usersinfo where openid = '".$openId."'";
			
			$result_isExsit = $dbUtils->exeQuery($sql_isExsit,$con);
			$result_isExsit_sum = 0;
			while($row = mysql_fetch_array($result_isExsit))
			{
				$result_isExsit_sum = $row['sum'];
				break;
			}
			
			
			
		} catch (Exception $e) {
			echo 'errorMsg:'.$e->getMessage();
		}
		
		
		echo '$result_isExsit_sum:'.$result_isExsit_sum.'<br/>';
		
		
		
		if($result_isExsit_sum > 0){
			$sql_update = 'UPDATE usersinfo SET nickname="'.$nickname.'",sex="'.$sex.'",country="'.$country.'",province="'.$province.'",
					city="'.$city.'",language="'.$language.'",subscribe_time="'.$subscribe_time.'",issubscribe=true where openid = "2"';
			echo '$sql_update:'.$sql_update.'<br/>';
			$result_update = $dbUtils->exeQuery($sql_update,$con);
			if($result_update){
				echo '<br/>update successfully!<br/>';
			}else{
				echo '<br/>update fail<br/>';
			}
				
		}else{
			$sql = 'INSERT INTO usersinfo ( nickname, openid, sex, country, province, city, language,
				subscribe_time)
				VALUES ("'.$nickname.'","'.$openId.'","'.$sex.'","'.$country.'","'.$province.'","'.$city.'","'.$language.'","'.$subscribe_time.'")';
			
			
			echo '\n $sql:'.$sql.'\n';
			//$result = $dbUtils->exeQuery($sql,$con);
			$result = mysql_query($sql);
			
			if($result){
				echo '\ninsert successfully!\n';
			}else{
				echo '\ninsert fail\n';
			}
			
		}
		
		$dbUtils->closeResultList($result_isExsit);
		$dbUtils->closeConn($con);
		//将用户信息存入数据库
		
		
	
	//	$contentStr = $nickname. "\n" . "性别：" . (($sex == 1) ? "男" : (($sex == 2) ? "女" : "未知")) . "\n"
		//		. "地区：" . $country. " " . $province . " " . $city . "\n"
			//			. "语言：" . (($language == "zh_CN") ? "简体中文" : "非简体中文") . "\n"
				//				. "关注：" . date ( 'Y年m月d日', $subscribe_time);
	
	//	return $contentStr;
	}
}