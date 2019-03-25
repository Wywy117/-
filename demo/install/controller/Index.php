<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/21
 * Time: 23:00
 */
namespace app\install\controller;

use think\Controller;

class index extends Controller
{
    public function index(){
        init_system();
        echo 'over';
    }
}