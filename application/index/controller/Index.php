<?php
namespace app\index\controller;
use \think\Controller;

class Index extends Controller
{
    public function index()
    {

        $url = 'http://jandan.net/pic';

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
	        $res[$key]['jd_source'] = $g[1];

	        $f2 = explode('<span class="righttext"><a href="', $value);
	        $f2 = explode('">', $f2[1], 2);
	        $res[$key]['jd_url'] = $f2[0];

	        $f22 = explode('</a></span><p>', $f2[1]);
	       	$res[$key]['jd_comment_num'] = $f22[0];

	        $f3 = explode('[查看原图]</a><br /><img src="', $e[1]);
	        $f3 = explode('" ', $f3[1], 2);
	        $res[$key]['jd_thumb'] = $f3[0];

	        $f4 = explode('</strong>', $value);
	        $f4 = explode('" >', $f4[0]);
	        $res[$key]['jd_author'] = $f4[1];

        }

        print_R($res);

        // return $this->fetch('index');
    }

}
