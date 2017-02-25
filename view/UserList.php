<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" href="http://demo.open.weixin.qq.com/jssdk/css/style.css?ts=1420774989">
<title>用户列表</title>
<style type="text/css">
	.listtab .desc{
		width:100%;
	}
	
	td{
		text-align:center;
	}
	
</style>
</head>
<body>
<?php
/**
页面：展示用户列表
 */

$con = mysql_connect("sqld.duapp.com:4050","80Zp2K738SsjCO4eLTx7rsn8","eC5al1iv0fEG7pQ6ENmVGx8FW6p6ciCx");
mysql_select_db("hbvjLNkbBAvsNjqTXsVC", $con);
if (!$con)
{
	echo 'Could not get mysql connect !!';
	die('Could not connect: ' . mysql_error());
}



$sql = "select id, nickname,sex,concat(country,'-',province,'-',city) location,issubscribe from usersinfo";

$result = mysql_query($sql,$con);

echo '<table class="listtab">';
echo '<tr>';
	echo '<th>ID</th>';
	echo '<th>昵称</th>';
	echo '<th>性别</th>';
	echo '<th>地区</th>';
	echo '<th>是否关注</th>';
	echo '</tr>';
 while($row = mysql_fetch_array($result))
{
	echo '<tr>';
	echo '<td>'.$row['id'].'</td>';
	echo '<td>'.$row['nickname'].'</td>';
	echo '<td>'.($row['sex']==1?'男':'女').'</td>';
	echo '<td>'.$row['location'].'</td>';  
	echo '<td>'.$row['issubscribe'].'</td>';
	echo '</tr>';
}


echo '</table>';

mysql_close($con);


?>


<span class="desc">判断当前客户端是否支持指定JS接口</span>
      <button class="btn btn_primary" id="checkJsApi">checkJsApi</button>
	
<span class="desc">获取“分享到朋友圈”按钮点击状态及自定义分享内容接口</span>
      <button class="btn btn_primary" id="onMenuShareTimeline">分享到朋友圈</button>


</body>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
<script>
  wx.config({
      debug: false,
      appId: 'wxf8b4f85f3a794e77',
      timestamp: 1420774989,
      nonceStr: '2nDgiWM7gCxhL8v0',
      signature: '1f8a6552c1c99991fc8bb4e2a818fe54b2ce7687',
      jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
      ]
  });


wx.ready(function () {

	// 1 判断当前版本是否支持指定 JS 接口，支持批量判断
	  document.querySelector('#checkJsApi').onclick = function () {
	    wx.checkJsApi({
	      jsApiList: [
	        'getNetworkType',
	        'previewImage'
	      ],
	      success: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
	  };

	  
	document.querySelector('#onMenuShareTimeline').onclick = function () {
	    wx.onMenuShareTimeline({
	      title: '互联网之子 方倍工作室',
	      link: 'http://movie.douban.com/subject/25785114/',
	      imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg',
	      trigger: function (res) {
	        alert('用户点击分享到朋友圈');
	      },
	      success: function (res) {
	        alert('已分享');
	      },
	      cancel: function (res) {
	        alert('已取消');
	      },
	      fail: function (res) {
	        alert(JSON.stringify(res));
	      }
	    });
	    alert('已注册获取“分享到朋友圈”状态事件');
	  };
});

  

	  
</script>
<script src="http://demo.open.weixin.qq.com/jssdk/js/api-6.1.js?ts=1420774989"> </script>



</html>
