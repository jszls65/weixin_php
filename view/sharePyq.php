<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" href="http://demo.open.weixin.qq.com/jssdk/css/style.css?ts=1420774989">
<title>测试分享朋友圈</title>
<style type="text/css">
	
	
</style>
</head>
<body>
<?php
	/**
	页面：分享朋友圈
	 */
	
	require_once(dirname(__FILE__)."/../util/JSSDK.php");
	
	$appid = "wx9567756ece4456c9";
	$appsecret = "d4ffefc5f3ec9a452838bde679d8f090";
	
	$jssdk = new JSSDK($appid, $appsecret);
	$signPackage = $jssdk->GetSignPackage();
	
	//定义数组，设置分享内容
	$news = array("Title" =>"微信公众平台开发实践", "Description"=>"本书共分10章，案例程序采用广泛流行的PHP、MySQL、XML、CSS、JavaScript、HTML5等程序语言及数据库实现。", "PicUrl" =>'http://images.cnitblog.com/i/340216/201404/301756448922305.jpg', "Url" =>'http://www.cnblogs.com/txw1958/p/weixin-development-best-practice.html');


?>

		
	<span class="desc">判断当前客户端是否支持指定JS接口</span>
	      <button class="btn btn_primary" id="checkJsApi">checkJsApi</button>
		
	<span class="desc">获取“分享到朋友圈”按钮点击状态及自定义分享内容接口</span>
	      <button class="btn btn_primary" id="onMenuShareTimeline">分享到朋友圈</button>

	
	<span class="desc">获取“发送给朋友”按钮点击状态及自定义分享内容接口</span>
	      <button class="btn btn_primary" id="onMenuShareAppMessage">发送给朋友</button>
	      
</body>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
<script>
  wx.config({
      debug: false,
      appId: '<?php echo $signPackage["appId"];?>',
      timestamp: <?php echo $signPackage["timestamp"];?>,
      nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      signature: '<?php echo $signPackage["signature"];?>',
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
	          title: '<?php echo $news['Title'];?>',
	          link: '<?php echo $news['Url'];?>',
	          imgUrl: '<?php echo $news['PicUrl'];?>',
	          trigger: function (res) {
	            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
	            // alert('用户点击分享到朋友圈');
	          },
	          success: function (res) {
	            // alert('已分享');
	          },
	          cancel: function (res) {
	            // alert('已取消');
	          },
	          fail: function (res) {
	            // alert(JSON.stringify(res));
	          }
	   });
	   
	  	alert('已注册获取“分享到朋友圈”状态事件');
	  };



	document.querySelector('#onMenuShareAppMessage').onclick = function(){
		//发送给朋友
		wx.onMenuShareAppMessage({
	          title: '<?php echo $news['Title'];?>',
	          desc: '<?php echo $news['Description'];?>',
	          link: '<?php echo $news['Url'];?>',
	          imgUrl: '<?php echo $news['PicUrl'];?>',
	          trigger: function (res) {
	            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
	            // alert('用户点击发送给朋友');
	          },
	          success: function (res) {
	            // alert('已分享');
	          },
	          cancel: function (res) {
	            // alert('已取消');
	          },
	          fail: function (res) {
	            // alert(JSON.stringify(res));
	          }
		});
	};
});

  

	  
</script>
<script src="http://demo.open.weixin.qq.com/jssdk/js/api-6.1.js?ts=1420774989"> </script>



</html>
