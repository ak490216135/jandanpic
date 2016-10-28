<?php
namespace app\index\controller;
use \think\Controller;

// 后台首页
class Index extends Collection
{	
	
	// 后台首页
    public function index()
    {
        return $this->fetch();
    }

    // 展示最新页
    public function indexpic()
    {
    	$all_info = $this->getAllInfo('http://jandan.net/pic');
    	$this->assign('ALL_INFO', $all_info);
        return $this->fetch();
    }

	// 最新页码
    public function newpage()
    {
    	$new_page = $this->getPageNum('http://jandan.net/pic');
    	$this->assign('NEW_PAGE', $new_page);
        return $this->fetch();
    }

}
