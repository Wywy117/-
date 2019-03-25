<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (!function_exists('systeminfo')) {
    function systeminfo($data=array()) {
        if(empty($data)){
            $data = array();
            $data['网站名称'] = '';
            $data['联系方式'] = '';
            $data['QQ'] = '';
            $data['软件版本'] = 'V0.1';
        }
        $code = <<<CODE
<?php
return [
    '网站名称'=>'{$data['网站名称']}',
    '联系方式'=>'{$data['联系方式']}',
    'QQ'=>'{$data['QQ']}',
    '软件版本'=>'{$data['软件版本']}',
];
CODE;
        file_put_contents(APP_PATH.'extra/system.php',$code);
        return '';
    }
}

if (!function_exists('getclientip')) {
    function getclientip( ) {
        //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
        return $res;
    }
}

if (!function_exists('JsonObj')) {
    function JsonObj($code, $msg, $url = '')
    {
        $data = array();
        $data['code'] = $code;
        $data['msg'] = $msg;
        $data['url'] = $url;
        return json($data);
    }
}