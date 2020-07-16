<?php

require_once __DIR__."/../vendor/autoload.php";

$PlogStore = new Alonexy\Pls\PlogStore();

$PlogStore->logStore("PlogStoreServce","PlogStore",["user"=>'测试111',time()],['sdadafafxxx'=>111]);
try{
    throw new \Psr\Log\InvalidArgumentException("".str_pad("XXXXXXXX",20000,"x"));
}catch (\Exception $e){
    for($i=0;$i<10;$i++){
        $PlogStore->logStore("PlogStoreServce","PlogStore",["user"=>'测试222',time(),"{$e->getMessage()}"],['sdadafafxxx'=>111]);
    }
}
$PlogStore->logStore("PlogStoreServce","PlogStore",["user"=>'测试3333',time()],['xxdadadadadx'=>111]);