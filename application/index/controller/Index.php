<?php
namespace app\index\controller;
use \think\Controller;

class Index extends Controller
{
    public function index()
    {
        $a = file_get_contents('http://jandan.net/pic');

        $b = explode('<!-- begin comments -->', $a);

        $c = explode('<!-- end comments -->', $b[1]);

        $d = explode('class="text">', $c[0]);

        $str = preg_replace("/[\t\n\r]+/","",$d);

        // $str = substr(' ', $str);

        foreach ($str as $value) {
        	echo $value;
        }
        //var_dump($str);

/*        // 名称
        $z['author'];
        // 防伪码
        $z['fwm'];
        // oo
        $z['oo'];
        // xx
        $z['xx'];*/

        // return $this->fetch('index');
    }

}
