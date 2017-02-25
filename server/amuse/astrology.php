<?php

function getAstrologyInfo($entity,$capitals)
{
	
	/*
	$capitals = array(
			'白羊座' => '1',
			'金牛座' => '2',
			'双子座' => '3',
			'巨蟹座' => '4',
			'狮子座' => '5',
			'处女座' => '6',
			'天秤座' => '7',
			'天蝎座' => '8',
			'射手座' => '9',
			'摩羯座' => '10',
			'水瓶座' => '11',
			'双鱼座' => '12'
	);*/
	
	$astrologyArray = array();
    $astrologyArray[] = array(
    "Title" =>$entity."运势", 
    "Description" =>"", 
    "PicUrl" =>"http://pic14.nipic.com/20110519/2457331_223610757000_2.jpg", 
    "Url" =>"http://dp.sina.cn/dpool/astro/starent/starent.php?type=day&ast=".$capitals[$entity]."&vt=4");

    return $astrologyArray;
}

?>