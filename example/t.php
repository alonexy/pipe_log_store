<?php

require_once __DIR__."/../vendor/autoload.php";

date_default_timezone_set('Asia/Shanghai');

$PlogStore = new Alonexy\Pls\PlogStore();
function testfun (){
    $PlogStore = new Alonexy\Pls\PlogStore();
    $PlogStore->debugTrace(true)->isEnabledInfo(true)->logStore("PlogStoreServce","错误信息2222",["user"=>'测试3333',time()],['xxdadadadadx'=>111],\Monolog\Logger::EMERGENCY);
}
//$PlogStore->setTimeout(3)->logStore("PlogStoreServce","错误信息提示1",["user"=>'测试111',time()],['sdadafafxxx'=>111]);
//try{
//    throw new \Psr\Log\InvalidArgumentException("".str_pad("XXXXXXXX",20,"x"));
//}catch (\Exception $e){
//    for($i=0;$i<10;$i++){
//        $PlogStore->logStore("PlogStoreServce","PlogStore",["user"=>'测试222',time(),"{$e->getMessage()}"],['sdadafafxxx'=>111]);
//    }
//}
//$PlogStore->isEnabledInfo(true)->logStore("PlogStoreServce","错误信息2222",["user"=>'测试3333',time()],['xxdadadadadx'=>111]);

testfun();
$PlogStore->debugTrace(true)->isEnabledInfo(true)->logStore("PlogStoreServce","错误信息2222",["user"=>'测试3333',time()],['xxdadadadadx'=>111],\Monolog\Logger::EMERGENCY);


