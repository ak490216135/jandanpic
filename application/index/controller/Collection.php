<?php
namespace app\index\controller;
use \think\Controller;

// 采集类
class Collection extends Controller
{

    // 获取一个页面的所有图片信息
    public function getAllInfo($url){

        $a = file_get_contents($url);

        $b = explode('<!-- begin comments -->', $a);
        $c = explode('<!-- end comments -->', $b[1]);
        $d = explode('<li id="commen', $c[0]);
        $fullstr = preg_replace("/[\t\n\r]+/","",$d);
        array_shift($fullstr);

        $res = [];

        foreach ($fullstr as $key => $value) {

        	//$res[$key]['value'] = $value;
        	//echo $value."||\n`";

        	$p = explode('<div class="text">', $value);
        	$p = explode('<div class="vote"', $p[1]);
        	$p = explode('</a></span>', $p[0]);
        	$p = $p[1];
        	// 存储内容段
        	$res[$key]['jd_p'] = $p;
        	// 存储文字内容
        	$jd_text = strip_tags($p);
        	$res[$key]['jd_text'] = str_replace('[查看原图]', '', $jd_text);

	        // 图片和缩略图
        	// 图片数量
        	$num = substr_count($p, '[查看原图]');
        	$res[$key]['num'] = $num;

        	// 单图 还是多图
        	if ($num > 1) {
        		// 多图处理
	        	$imgs = explode('<a href="', $p);
	        	array_shift($imgs);
	        	$af = [];
	        	foreach ($imgs as $key2 => $value2) {
	        		$ex 			= explode('" target="_blank" class="view_img_link">[查看原图]</a><br /><img src="', $value2);
	        		$af[$key2] 		= $ex;
	        		// 存储原图
	        		$af[$key2]['large'] = $af[$key2][0];
	        		$af[$key2]['ext'] 	= $this->getExt($af[$key2][0]);
	        		unset($af[$key2][0]);
	        		if(strpos($af[$key2][1], '" org_src="')){
	        			// 如果是gif
	        			$gif 				= explode('" org_src="', $af[$key2][1]);
	        			// 存储展示图
	        			$af[$key2]['mw'] 	= $gif[0];
	        			$gif2 				= explode('"', $gif[1]);
	        			// 存储点击后图
	        			$af[$key2]['thumb'] = $gif2[0];
	        			unset($af[$key2][1]);
	        		}else{
	        			// 如果是普通图
	        			$ppt 				= explode('"', $af[$key2][1]);
	        			$af[$key2]['mw']	= $ppt[0];
	        			unset($af[$key2][1]);
	        		}
	        	}
	        	$res[$key]['imgs'] 	= $af;
        	} else {
        		// 单图处理
	        	$af 				= explode('<a href="', $p);
	        	array_shift($af);
	        	$af 				= explode('" target="_blank" class="view_img_link">[查看原图]</a><br /><img src="', $af[0]);
	        	$imgs 				= [];
	        	// 存储原图
	        	$imgs[0]['large'] 	= $af[0];
	        	$af[1] 				= explode('"', $af[1]);
	        	$af[1] 				= $af[1][0];
	        	// 存储展示图
	        	$imgs[0]['mw'] 		= $af[1];
	        	$imgs[0]['ext'] 	= $this->getExt($af[0]);

	        	$res[$key]['imgs'] 	= $imgs;
        	}

        	// 转为JSON字符串存储
        	$res[$key]['imgs'] = json_encode($res[$key]['imgs']);
        	//$res[$key]['imgs'] = json_decode($res[$key]['imgs'], true);

	        // 煎蛋url地址
	        $f2 = explode('<span class="righttext"><a href="', $value);
	        $f2 = explode('">', $f2[1], 2);
	        $res[$key]['jd_location'] = $f2[0];

	        // 煎蛋评论号
	        $f3 = explode('</a></span><p>', $f2[1]);
	       	$res[$key]['jd_comment_num'] = $f3[0];

	        // 作者
	        $f5 = explode('</strong>', $value);
	        $f5 = explode('" >', $f5[0]);
	        $res[$key]['jd_author'] = $f5[1];

	        // 页码
	        $res[$key]['jd_page'] = $this->explodeContent($res[$key]['jd_location'], '/pic/page-', '#comment');

	        // 防伪码
	        $f7 = explode('防伪码：', $value);
	        $f7 = explode('" >', $f7[1], 2);
	        $res[$key]['jd_fwm'] = $f7[0];

        }

        return $res;

    }

    // 更新单条内容
    public function updateOneInfo(){

    }

    // 获取最新的页码
    public function getPageNum($url){

        $str = file_get_contents($url);
        $str = $this->explodeContent($str, '<span class="current-comment-page">', '</span>');
        // 去除两边 []
        $str = substr($str, 0, -1);
        $str = substr($str, 1);
        //$fullstr = preg_replace("/[\t\n\r]+/","",$d);
        //array_shift($fullstr);
        $page = $str;
        return $page;

    }

    // 分割
    public function explodeContent($string,$start,$end){ 

		$content=explode($start,$string); 
		$content=explode($end,$content[1]); 
		return $content[0]; 

	}

	// 获取扩展名
	public function getExt($string){

		$a = explode('.', $string);
		if(count($a) > 1){
			$b = array_pop($a);
		}else{
			$b = '';
		}
		return $b;

	}

	// 获取评论信息 输入评论号返回内容
	public function getCommentContent($comment_num){
		$a = file_get_contents($url);
		return 123;
	}
}
