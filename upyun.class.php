<?php
class UpYun {
    //API请求地址
    private $apiUrls;

    // 服务名称
    private $_bucketname;

    //操作员
    private $_username;

    //操作员密码
    private $_password;

    public function __construct($_username, $_password)
    {
        $this->_username= $_username;
        $this->_password= $_password;
        $this->_apiUrls = 'http://p0.api.upyun.com/pretreatment/' ; //api 请求地址
    }

    /**
     * 生成请求接口需要的签名
     * @param $data
     * @return bool|string
     */
    public function createSign($data)
    {
        if(is_array($data)) {
            ksort($data);
            $string = '';
            foreach($data as $k => $v) {
                if(is_array($v)) {
                    $v = implode('', $v);
                }
                $string .= "$k$v";
            }
            $sign = $this->_username.$string.md5($this->_password);
            $sign = md5($sign);
            return $sign;
        }
        return false;
    }
    /**
     * 辅助函数， 请求接口的任务数组需要转化为字符串
     * @param $tasks
     * @return bool|string
     */
    protected function processTasksData($tasks)
    {
        if(is_array($tasks)) {
            return base64_encode(json_encode($tasks));
        }
        return false;
    }
    /**
     * 请求 sipder接口
     * @param array $data
     * <code>
     * $data = array(
     *      'bucket_name' => '$bucket_name',  //空间名
     *      'notify_url' => 'http://callback/', //回调地址
     *      'app_name'  => 'spiderman',   // 任务所使用的云处理程序，文件拉取为 spiderman
     *      'tasks' => $tasks //任务
     * )
     * </code>
     */
     public function request($data)
     {
       $data['tasks'] = $this->processTasksData($data['tasks']);
       $this->curl($data, $this->_apiUrls, 'POST');
     }
    protected function curl($data, $url, $method = 'GET')
    {
        $sign = $this->createSign($data);
        $data = http_build_query($data);
        $headers[] = "Authorization: UPYUN ".$this->_username.":".$sign;
        $headers[] = "Date: ".gmdate("D, d M Y H:i:s \G\M\T");
        $ch = curl_init();
        $options = array();
               switch(strtoupper($method)) {
                   case 'GET':
                       $url .= '?' . $data;
                       $options = array(
                           CURLOPT_URL => $url,
                           CURLOPT_HTTPHEADER => $headers,
                           CURLOPT_RETURNTRANSFER => true,
                           CURLOPT_HEADER => true,
                       );
                       break;
                   case 'POST':
                       $options = array(
                           CURLOPT_URL => $url,
                           CURLOPT_POST => true,
                           CURLOPT_POSTFIELDS => $data,
                           CURLOPT_HTTPHEADER => $headers,
                           CURLOPT_RETURNTRANSFER => false,
                           CURLOPT_HEADER => true,
                       );
                       break;
                     }
                      curl_setopt_array($ch, $options);
                      $result = curl_exec($ch);
                      curl_close($ch);
       }
   }
 ?>
