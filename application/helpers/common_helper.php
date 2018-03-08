<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter common Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		
 * @link		
 */

// ------------------------------------------------------------------------

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

/**
* 加密函数
* @param string            密码
* @return string           加密后的密码
*/
function password($password)
{
    return md5('H' . $password . 'G'); 
}


/**
 * 增加日志
 * @param $log
 * @param bool $name
 */
function addlog($log, $name = false)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->load->library('session');

    if(!$name)
    {
        $uid = $ci->session->uid;
        if($uid)
        {
            $user = $ci->db->select('name')
                            ->from('user')
                            ->where(array('id' => $uid))
                            ->get()
                            ->row_array();

            $data['username'] = $user['name'];
        }
        else
        {
            $data['username'] = '';
        }
    }
    else
    {
        $data['username'] = $name;
    }
    $data['time'] = time();
    $data['ip'] = $ci->input->ip_address();
    $data['log'] = $log;
    $ci->db->insert('log', $data);
}

/**
 * 信息提示页面
 * @$content 要提示的文字
 * @$continue 即将跳往的页面，返回用“-1”
 * @$status 提示状态，值为0,1或其它，0为错误提示(红色)，1为正常提示（绿色）
 * @author theNbsp
 */
function showmessage($content, $continue, $status = 1) 
{
    $continue = ($continue == 'back') ? 'history.back()' : 'window.location="'.site_url($continue).'"';
    $waits = ($status == 0) ? 'setTimeout("thisUrl()", 2500)' : 'setTimeout("thisUrl()", 1500)';
    $status = ($status == 0) ? 'color:#FF0000' : 'color:#009900';
    $string = "<div class='box'>\n<h5>提示信息</h5>\n<p class='content'>".$content."</p>\n<p class='clickUrl'>
    如果浏览器没有自动跳转，请 <a href='javascript:;' onClick='".$continue."'>点击这里</a></p>\n</div>";
    $style = "<style>\nbody,h5,p,a{font:12px Verdana,Tahoma;text-align:center;text-decoration:none;margin:0;padding:0;}
    \nh5{color:#555;font-size:14px;height:28px;text-align:center;line-height:28px;font-weight:bold;background:
    #EEE;margin:1px;padding:0 10px;} \n.box{width:480px;border:1px solid #DDD;margin:120px auto;-moz-box-shadow:
    3px 4px 5px #EEE;-webkit-box-shadow:3px 4px 5px #EEE;}\n.content{".$status.";font-size:14px;font-weight:bold;
    line-height:24px;padding:30px 10px;}\n.clickUrl{color:#888;margin-bottom:15px;padding:0 10px;}\n</style>";
    $html = "<!DOCTYPE html>\n<html>\n<head>\n<title>提示信息</title>\n<meta http-equiv='Content-Type' content='text/html;
    charset=utf-8'/>\n".$style."\n<script type='text/javascript'>\nfunction thisUrl(){".$continue."}\n".$waits."\n
    </script>\n</head>\n<body>\n".$string."\n</body>\n</html>";
    exit($html);
}

if ( ! function_exists('rand_chr'))
{
    function rand_chr($length)
    {
        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';  //自己定义喜欢的字符串
        $str = str_shuffle($str);
        return substr($str,0,$length);
    }  
}


