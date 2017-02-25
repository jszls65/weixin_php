<?php
 function getTrafficInfo($object)
{
	$content[] = array("Title" =>"交通信息","Description" =>"", "PicUrl" =>"", "Url" =>"http://m.8684.cn/bus");
	$content[] = array("Title" =>"【公交线路】\n全车公交查询", "Description" =>"", "PicUrl" =>"http://photo.candou.com/ai/114/09caed4a27c56000bb870c68ab028850", "Url" =>"http://m.8684.cn/shenzhen_bus");
	$content[] = array("Title" =>"【汽车班次】\n长途汽车班车", "Description" =>"", "PicUrl" =>"http://photo.candou.com/i/175/4951bd2a2f368cafc5ad09ff95ce591d", "Url" =>"http://touch.trip8080.com/");
	$content[] = array("Title" =>"【火车时刻】\n火车时刻查询", "Description" =>"", "PicUrl" =>"http://photo.candou.com/ai/114/26a9407dcedda5f4a30b195f78ec3680", "Url" =>"http://m.ctrip.com/html5/Trains/");
	$content[] = array("Title" =>"【飞 机 票】\n机票查询", "Description" =>"", "PicUrl" =>"http://photo.candou.com/i/175/a1bd6303a8bde7da50166aa8dafb7568", "Url" =>"http://touch.qunar.com/h5/flight/");
	$content[] = array("Title" =>"【城市路况】\n重点城市实时路况", "Description" =>"", "PicUrl" =>"http://photo.candou.com/i/175/0d8488edf94574651d048025596a6190", "Url" =>"http://dp.sina.cn/dpool/tools/citytraffic/city.php");
	$content[] = array("Title" =>"【违章查询】\n全国违章查询", "Description" =>"", "PicUrl" =>"http://g.hiphotos.bdimg.com/wisegame/pic/item/9e1f4134970a304eab30503cd0c8a786c8175ce2.jpg", "Url" =>"http://app.eclicks.cn/violation2/webapp/index?appid=10");

	return $content;
}

