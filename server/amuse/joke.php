<?php

function getJokeInfo()
{
    
       
   
	
	$mysql_table = "joke";
	$id = rand(1, 1000);
	$mysql_state = "SELECT * FROM `".$mysql_table."` WHERE `id` = '".$id."'";
    
	$con = mysql_connect("sqld.duapp.com:4050","80Zp2K738SsjCO4eLTx7rsn8","eC5al1iv0fEG7pQ6ENmVGx8FW6p6ciCx");
	mysql_select_db("hbvjLNkbBAvsNjqTXsVC", $con);
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	
// 	mysql_query("SET NAMES 'UTF8'");
	$result = mysql_query($mysql_state);

	$joke = "";
    while($row = mysql_fetch_array($result))
    {
		$joke = $row["content"];
		break;
    }
    mysql_close($con);
	return $joke;
}
?>