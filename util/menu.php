<?php

$appid = "wx9567756ece4456c9";
$appsecret = "d4ffefc5f3ec9a452838bde679d8f090";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);

$access_token = $jsoninfo["access_token"];


$jsonmenu = '{
      "button":[
      {
            "name":"生活类",
           "sub_button":[
            {
               "type":"view",
               "name":"天气预报",
               "url":"http://m.hao123.com/a/tianqi"
            },
            {
               "type":"view",
               "name":"快递查询",
               "url":"http://www.kuaidi100.com/?from=openv"
            },
            {
               "type":"view",
               "name":"中英翻译",
               "url":"http://fanyi.baidu.com/?aldtype=16047#auto/zh"
            },
            {
               "type":"click",
               "name":"英语四六级",
               "key":"MENU01_CET46"
            },
            {
                "type":"click",
                "name":"交通信息",
                "key":"MENU01_TRAFFICINFO"
            }]
      

       },
       {
           "name":"娱乐类",
           "sub_button":[
            {
               "type":"click",
               "name":"笑话",
               "key":"MENU02_JOKE"
            },
            {
               "type":"click",
               "name":"星座运势",
               "key":"MENU02_CONSTELLATION"
            },
            {
                "type":"click",
                "name":"图片设别",
                "key":"MENU02_CHECKFACE"
            },
            {
                "type":"click",
                "name":"一站到底",
                "key":"MENU02_GAME"
            },
            {
                "type":"click",
                "name":"智能聊天机器人",
                "key":"MENU02_SMARTCHART"
            }]
       

       },
       {
           "name":"关于",
           "sub_button":[
            {
               "type":"view",
               "name":"用户中心",
               "url":"http://jszlswx.duapp.com/view/UserList.php"
            },
            {
               "type":"click",
               "name":"意见反馈",
               "key":"MENU03_SUGGESTION"
            },
            {
               "type":"click",
               "name":"关于我们",
               "key":"MENU03_ABOUTUS"
            }]

       }]
 }';


$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

?>