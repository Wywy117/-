<?php
namespace app\admin\controller;

use app\admin\model\NodeModel;
use app\admin\model\UserModel;
use think\Cache;
use think\Config;
use think\Controller;

class index extends Base
{
    public function server()
    {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            'ThinkPHP版本'=>THINK_VERSION,
        );
        $system = Config::get('system');
        $this->assign('system',$system);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function setting(){
        if(request()->isAjax()){
            $data = input();
            systeminfo($data);
            return JsonObj(true,'保存成功');
        }else{
            $system = Config::get('system');
            $this->assign('system',$system);
            return $this->fetch();
        }
    }

    public function nodes(){
        if(request()->isAjax()){
            $nodemodel = new NodeModel();
            $list = $nodemodel->select();
            $list = $nodemodel->getTreeNode(0,$list);
            echo json_encode($list);
        }else
            return $this->fetch();
    }

    public function clearcache(){
        Cache::clear();
        $this->redirect(url('index'));
    }
}
