<?php
namespace app\admin\controller;

use app\admin\model\NodeModel;
use app\admin\model\UserModel;
use think\Controller;

class Base extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();
        $usermodel = new UserModel();
        $loginuser = $usermodel->getLoginUser();
        if( !$loginuser)
        {
            $this->redirect(url('publics/index'));
        }
        $loginuser = $usermodel->where('id',$loginuser['id'])->find();
        $url = strtolower(request()->controller().'/'.request()->action());
        $authednodes = $usermodel->getAuthedNodes($loginuser);

        $isauth = false;
        if($url == 'user/noauth')
            $isauth = true;
        if(!$isauth){
            foreach($authednodes as $k=>$v){
                if($v['url'] == $url)
                {
                    $isauth = true;
                    break;
                }
            }
        }

        if(!$isauth){
            $this->error('无权限',url('user/noauth'));
        }

        $treenodes = NodeModel::getTreeNode(0,$authednodes,false);

        $nodemodel = new NodeModel();
        $btnandactions = $nodemodel->getNodesInPage($url,$authednodes);
        $this->assign('loginuser',$loginuser);
        $this->assign('treenodes',$treenodes);
        $this->assign('btnandactions',$btnandactions);
    }

}
