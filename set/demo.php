<?php  

require_once dirname(__FILE__).'/BaeLog.class.php';

$secret = array("user"=>"b933d97d22464dceb2b0d5f54a18170d","passwd"=>"510ede6dcdb545bcb61abbc4f9a06a5e" );
$log = BaeLog::getInstance($secret);

header("Content-type: text/html; charset=utf-8");
echo "123<br/>";
if(NULL !=  $log)
{
   $log->setLogLevel(16);
   for($i=0;$i<3;$i++)
   {
       $ret = $log->Fatal("lelllllllllllllll12");
        if(false === $ret)
        {
            $code = $log->getResultCode();
            echo "$code<br/>";
        }else{
            echo "Success<br/>";
        }
   }
}


