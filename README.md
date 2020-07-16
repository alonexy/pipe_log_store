## pipe_log_store

基于Monlog 把log通过管道输出

- 实现demo[https://github.com/alonexy/logStorageService]

### 调用方式
```
require_once __DIR__."/../vendor/autoload.php";

$PlogStore = new Alonexy\Pls\PlogStore();

$PlogStore->logStore("PlogStoreServce","logMessage",["user"=>'张三',time()],['id'=>111]);

```