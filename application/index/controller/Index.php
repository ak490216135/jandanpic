<?php
namespace app\index\controller;
use \think\Controller;

// 后台首页
class Index extends Collection
{	

	private $url = 'http://jandan.net/pic';
	
    public function index()
    {

    	$all_info = $this->getAllInfo($this->url);
    	$this->assign('ALL_INFO', $all_info);
        return $this->fetch();
    }

}
