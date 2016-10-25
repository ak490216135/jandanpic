<?php
namespace app\index\controller;
use \think\Controller;

class Index extends Controller
{
    public function index()
    {

    	// 获取首页信息
    	// $all_info = $this->getAllInfo('http://jandan.net/pic');
    	$page = $this->getPage('http://jandan.net/pic');
    	var_dump($page);

    }

    // 获取一个页面的所有图片信息
    private function getAllInfo($url){

        $a = file_get_contents($url);
        $b = explode('<!-- begin comments -->', $a);
        $c = explode('<!-- end comments -->', $b[1]);
        $d = explode('<li id="commen', $c[0]);
        $fullstr = preg_replace("/[\t\n\r]+/","",$d);
        array_shift($fullstr);

        $res = [];

        foreach ($fullstr as $key => $value) {

	        $e = explode('" target="_blank" class="view_img_link">', $value);
	        $f = explode('</a></span><p>', $e[0]);
	        $g = explode('<a href="', $f[1]);
	        // 原图地址
	        $res[$key]['jd_source'] = $g[1];

	        $f2 = explode('<span class="righttext"><a href="', $value);
	        $f2 = explode('">', $f2[1], 2);
	        // 煎蛋url地址
	        $res[$key]['jd_url'] = $f2[0];

	        $f3 = explode('</a></span><p>', $f2[1]);
	        // 煎蛋评论号
	       	$res[$key]['jd_comment_num'] = $f3[0];

	        $f4 = explode('[查看原图]</a><br /><img src="', $e[1]);
	        $f4 = explode('" ', $f4[1], 2);
	        // 缩略图
	        $res[$key]['jd_thumb'] = $f4[0];

	        $f5 = explode('</strong>', $value);
	        $f5 = explode('" >', $f5[0]);
	        $res[$key]['jd_author'] = $f5[1];

	        $f6 = explode('/pic/page-', $res[$key]['jd_url']);
	        $f6 = explode('#comment', $f6[1]);
	        $res[$key]['jd_page'] = $f6[0];

	        $f7 = explode('防伪码：', $value);
	        $f7 = explode('" >', $f7[1], 2);
	        $res[$key]['jd_fwm'] = $f7[0];

        }

        return $res;

    }
    // 获取最新的页码
    private function getPage($url){

        $str = file_get_contents($url);
        $str = explode('<span class="current-comment-page">', $str);
        $str = explode('</span>', $str[1]);
        $str = $str[0];
        // 去除两边 []
        $str = substr($str, 0, -1);
        $str = substr($str, 1);
        //$fullstr = preg_replace("/[\t\n\r]+/","",$d);
        //array_shift($fullstr);
        $page = $str;
        return $page;
        
    }
}
