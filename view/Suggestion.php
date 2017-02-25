<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>意见反馈</title>
<style type="text/css">
	.btnsub{
		width:90%;
		height: 30px;
		background-color: green;
		margin: 0 auto;
	}
	
</style>
</head>
<body>
<?php
/**
页面：意见反馈，表单提交
 */

?>
	
	<div style="border:1px red solid;" >
		<form action="../server/Suggestion.class.php" method="post">
			<textarea name="content" rows="20" cols="120"></textarea>
			<br/>
			<input type="submit" name="ci"  class="btnsub"/>
		</form>
	</div>
	

</body>
</html>
