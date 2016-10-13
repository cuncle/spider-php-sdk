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
    'tasks' =>array(    //处理参数可以参考[文档](http://docs.upyun.com/cloud/unzip/#_6)
       array(
         "sources" => ["/path/1.jpg"],         //需要压缩的文件路径
         "save_as" => "/result/abc.zip"        //保存路径
        )
    )
);
``` 
