<?php
require_once('upyun.class.php');
$upyun = new UpYun ('username', 'password');//操作员的帐号密码
$data = array(
    'bucket_name' => 'bucketname',        // 服务名称
    'notify_url' => 'http://callback.com',      //回调通知地址
    'app_name'	=> 'compress',      //任务所使用的云处理程序，文件拉取为 spiderman
    'tasks' =>array(
       array(
         "sources" => ["/path/1.jpg"],         //需要压缩的文件路径
         "save_as" => "/result/abc.zip"        //保存路径
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
