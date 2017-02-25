<?php
class DBUtils{
	 
	/**
	 * 获取数据库连接
	 */
	function getConn(){
		$con = mysql_connect("sqld.duapp.com:4050","80Zp2K738SsjCO4eLTx7rsn8","eC5al1iv0fEG7pQ6ENmVGx8FW6p6ciCx");
		mysql_select_db("hbvjLNkbBAvsNjqTXsVC", $con);
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		echo "getConn success!!<br/>";
		
		return $con;
	}
	
	/**
	 * 关闭数据库连接
	 * @param unknown $con
	 */
	function closeConn($con){
		if ($con)
		{
			mysql_close($con);
		}
	}
	
	/**
	 * 执行查询sql语句
	 * @param string $sql sql语句
	 */
	function exeQuery($sql,$con){
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		
		
		$result = mysql_query($sql,$con);
		
		return $result;
	}
	/**
	 * 释放结果集
	 * @param unknown $result
	 */
	function closeResultList($result){
		if($result){
			mysql_free_result($result);
		}
	}
	
}