# 又拍云 PHP版云处理的简单SDK（异步拉取，解压和压缩）
基于又拍云[异步文件拉取文档](http://docs.upyun.com/cloud/spider/) 实现文件拉取，基于又拍云[压缩解压缩文档](http://docs.upyun.com/cloud/unzip/)实现文件压缩解压缩。    
#异步拉取使用方法   
```
// 初始化 UpYun
$upyun = new UpYun ('username', 'password');//操作员的帐号密码

// 设置请求任务
$data = array(
    'bucket_name' => 'bucketname',        // 服务名称
    'notify_url' => 'http://callback.com',      //回调通知地址
    'app_name'	=> 'spiderman',      //任务所使用的云处理程序，文件拉取为 spiderman
    'tasks' =>array(
       array(
          'url'=> 'http://g.hiphotos.baidu.com/zhidao/pic/item/eac4b74543a98226b1599e898b82b9014b90eb80.jpg',     // 需要拉取文件的 URL
          'random'=> false,       // 是否追加随机数, 默认 false
          'overwrite'=>false,     // 是否覆盖，默认 true
          'save_as'=>'/upyun/demo.png',     // 保存路径
        )
    )
);

// 调用拉取函数
$ids = $upyun->request($data);
``` 
#压缩使用方法 
```
// 初始化 UpYun
$upyun = new UpYun ('username', 'password');//操作员的帐号密码
// 设置请求任务
$data = array(
    'bucket_name' => 'bucketname',        // 服务名称
    'notify_url' => 'http://callback.com',      //回调通知地址
    'app_name'	=> 'compress',      //任务所使用的云处理程序，压缩为 compress，解压缩为 depress
    'tasks' =>array(    //处理参数可以参考文档:http://docs.upyun.com/cloud/unzip/#_6
       array(
         "sources" => ["/path/1.jpg"],         //需要压缩的文件路径 #  需要的注意，在解压的时候sources为string，所以不需要[] #
         "save_as" => "/result/abc.zip"        //保存路径
        )
    )
);
$ids = $upyun->request($data);
print $ids;
``` 
#注意事项 
返回的code:200 只是表示你提交的处理请求已经成功发送到了处理队列里面，具体的处理结果在你的回调信息里面。
```
HTTP/1.1 200 OK
Server: vivi/0.7
Date: Thu, 03 Nov 2016 13:05:31 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Request-Id: 6743decb89adc4902dbca119117ef901
X-Request-Path: poc-hgh-a-15, api-php-083
["61ad3b6911c810881ee87049f09452a4"]
``` 

