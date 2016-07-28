<?php
require_once('upyun.class.php');
$upyun = new UpYun ('username', 'password');//操作员的帐号密码
$data = array(
    'bucket_name' => 'bucketname',        // 服务名称
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
try {
    //返回对应的任务ids
    $ids = $upyun->request($data);
    print $ids;

} catch(Exception $e) {
    echo $e->getCode();     // 错误代码
    echo $e->getMessage();  // 具体错误信息
}
