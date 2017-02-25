<?php
#模板信息处理类
#creator zls
#date 2016年10月29日
require_once(dirname(__FILE__)."/../util/CommonUtils.php");
class Template{
	/**
	 * 交易提醒
	 * @param unknown $obj
	 * @return mixed
	 */
	public function getTemplate_jytx($obj){
		CommonUtils::logDebug('执行getTemplate方法');
		$touser = $obj->FromUserName;
		$tem = array(
					'touser'=>$touser."",
					"template_id"=>"bbFhuP-eqmPb1uRZmuVk58Guszik9K9Sg7sHhWsOmhU",
					"url"=>"http://www.baidu.com",
					'data' => array(
							'first' => array(
									'value' => "尊敬的张先生：\n\n您尾号8888的信用卡最新交易信息"
							),
							'keyword1' => array(
									'value' => "28日23:23"
							),
							'keyword2' => array(
									'value' => "微信支付(Tenpay):百度云"
							),
							'keyword3' => array(
									'value' => "消费"
							),
							'keyword4' => array(
									'value' => "人民币 2222222222.00元",
									'color' => '#3A5FCD'
							),
							'remark' => array(
									'value' => "\n\n若您交易未成功，建议您财付通/手Q钱包请拨打0755-86013860后转人工，微信请拨打96017核实\n\n★10元风暴FUN开刷★连续10天刷卡满额，WMF锅勺套装、康宁轻质餐盘6件套等轻奢礼10元成双成“兑”，速戳兑换！"
							)
							
					)
			);
		$access_token = CommonUtils::getAccess_token();
// 		$access_token = 'GEVAPI2nO-DBRBg9qkGY15uvc6YF_fMH8tmN-joSHoXgH2HTM90CHgiKSVXYfznvyKCSdVbh4PCgGVP8z4uwUr_OMA0F9Njco-CVTGebsQtzv80eLq5lANsjKaMEcr0qFBObABAYUH';
		
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
		
		$curl = curl_init($url);
		$header = array();
		$header[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		// 不输出header头信息
		curl_setopt($curl, CURLOPT_HEADER, 0);
		// 伪装浏览器
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
		// 保存到字符串而不是输出
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($curl, CURLOPT_POST, 1);
		// 请求数据
		curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($tem));
		
		
		$content = curl_exec($curl);
		curl_close($curl);
		
		CommonUtils::logDebug('执行getTemplate方法,$content:'.$content);
		
		return $content;
          
	}



	//about us
	public function getTemplate_aboutus($obj){
		CommonUtils::logDebug('执行getTemplate方法,Function:about us');
		$touser = $obj->FromUserName;
		$tem = array(
					'touser'=>$touser."",
					"template_id"=>"n6rU7L9ghe1yUQsUEPg-d6de4QpGr8m8vC54l4_IjSM",
					"url"=>"http://www.baidu.com",
					'data' => array(
							'first' => array(
									'value' => "尊敬的用户：\n"
							),
							'keyword1' => array(
									'value' => "辛月小栈--生活服务公众号"
							),
							'keyword2' => array(
									'value' => "生活服务、用户管理、信息获取、资源共享",
									'color' => '#3A5FCD'
							),
							'keyword3' => array(
									'value' => "个人--张连胜"
							),
							'keyword4' => array(
									'value' => "jszls65@qq.com",
									'color' => '#3A5FCD'
							),
							'remark' => array(
									'value' => "\n\n您可以通过E-mail与我们取得联系，也可以通过【意见反馈】菜单向我们提出您的诉求，我们会在第一时间给予反馈。\n\n感谢您的关注，祝您生活愉快~~"
							)
							
					)
			);
		$access_token = CommonUtils::getAccess_token();
// 		$access_token = 'GEVAPI2nO-DBRBg9qkGY15uvc6YF_fMH8tmN-joSHoXgH2HTM90CHgiKSVXYfznvyKCSdVbh4PCgGVP8z4uwUr_OMA0F9Njco-CVTGebsQtzv80eLq5lANsjKaMEcr0qFBObABAYUH';
		
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
		
		$curl = curl_init($url);
		$header = array();
		$header[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		// 不输出header头信息
		curl_setopt($curl, CURLOPT_HEADER, 0);
		// 伪装浏览器
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
		// 保存到字符串而不是输出
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($curl, CURLOPT_POST, 1);
		// 请求数据
		curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($tem));
		
		
		$content = curl_exec($curl);
		curl_close($curl);
		
		CommonUtils::logDebug('执行getTemplate方法,$content:'.$content);
		
		return $content;
          
	}





	
}
