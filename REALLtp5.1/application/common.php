<?php
// 应用公共文件
//中文不转为unicode
//JSON_UNESCAPED_UNICODE = 256
//不转义反斜杠
//JSON_UNESCAPED_SLASHES = 64
//下面使用整数来代替。
//JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES = 320
/**
 * @param $title
 * @param int $code
 * @param string $message
 * @return false|string
 * @auther 杜韦凡 <875147715@qq.com>
 * @time:2019/9/19 下午6:45
 */
function msg($title,$code=500,$message=''){
    $msg = [
      'title' => $title,
        'code' => $code,
        'message'=>$message
    ];
//    return json_encode($msg,320);
    return $msg;
}
if(!function_exists('get_client_ip')){
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     * @auther 杜韦凡 <875147715@qq.com>
     * @time:2019/9/19 下午6:54
     */
    function get_client_ip($type = 0,$adv = false){
        $type      = $type ? 1 : 0;
        static $ip = NULL;
        if($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);//去除字符串的头尾空格
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

if (!function_exists('data_auth_sign')) {
    /**
     * 数据签名认证
     * @param array $data 被认证的数据
     * @author 蔡伟明 <314013107@qq.com>
     * @return string
     */
    function data_auth_sign($data = [])
    {
        // 数据类型检测
        if(!is_array($data)){
            $data = (array)$data;
        }

        // 排序
        ksort($data);
        // url编码并生成query字符串
        $code = http_build_query($data);
        // 生成签名
        $sign = sha1($code);
        return $sign;
    }
}


