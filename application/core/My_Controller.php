<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
	public $USER;

	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();

		$this->load->database();  // 加载数据库
		$this->load->library('auth');  // 加载类库 Auth 权限认证类
		$this->load->helper('captcha');  // 加载验证码类
		$this->load->model('admin/common_model');

		$controller = $this->router->fetch_class();
		if(in_array($controller, array("Login")))   // 不需要登录控制器
		{
			return true;
		}

		$flag = $this->_check_login();   // 检测是否登录

		if(!$flag)
		{
			redirect(site_url('admin/Login/index'));
			exit(0);
		}
		else
		{
			$this->check_auth();
			$this->assign_username();
			$this->assign_sidebar();
		}	
	}

	/**
     * 描述：拼装数组，把不是顶级菜单的数组整合到相对应的顶级菜单中去
     * @param $items  二维数组
     * @param mixed $menuTree
     * @param $id
	 * @param $pid  父id
	 * @param $son
	 * @return array 整合了家谱的数组
     */ 
	protected function getMenu($items, $id = 'id', $pid = 'pid', $son = 'children')
	{
		$tree = array();
		$tmpMap = array();
		foreach($items as $item)
		{
			$tmpMap[$item[$id]] = $item;
		} 
		foreach($items as $item)
		{
			//判断pid是否为0，不为0时将数组拼装到children后面
			if(isset($tmpMap[$item[$pid]]))
			{
				$tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];	
			}	
			//当pid为0时，将子孙合并的数组拼到一个新数组
			else
			{
				$tree[] = &$tmpMap[$item[$id]];
			}
		}
		return $tree;
	}

	/**
	 * 检测是否登录
	 */
	public function _check_login()
	{
		$flag = false;

		$salt = COOKIE_SALT;
		$ip = $this->input->ip_address();
		$ua = $_SERVER['HTTP_USER_AGENT'];

		if(isset($_SESSION['uid']))
		{
			$flag = true;
		}

		if(isset($_COOKIE['auth']))
		{
			$auth = $_COOKIE['auth'];
			list($identifier, $token) = explode(":", $auth);

			if(ctype_alnum($identifier) && ctype_alnum($token))
			{
				$data['identifier'] = $identifier;
				$data['token'] = $token;
			}

			$user = $this->db->where($data)->get('user')->row_array();
			
			if($user)
			{
				$flag = true;
				$_SESSION['uid'] = $user['id'];
				$this->USER = $user;
			}
		}

		return $flag;
	}

	/*
	 * 检查当前用户是否有权限
	 */
	public function check_auth()
	{ 
		$uid = $_SESSION['uid'];
		$role_info = $this->common_model->get_role_info($uid);  // 获取当前用户的角色信息

		$controller = $this->router->fetch_class();
		$method = $this->router->fetch_method();
		$name = $controller . '/' . $method;

		$auth = new Auth();
		$allow_controller = array('Upload');//放行控制器名称
        $allow_method = array('add_or_update', 'check_pass', 'update_pass', 'export_detail', 'export_analysis');//放行方法名称

        $auth_result = $auth->check($name, $uid);

        if(empty($role_info))
        {
        	showmessage('没有权限', 'back', 1); //改
        }
        else
        {
        	foreach ($role_info as $key => $val) 
	        {
	        	if($val['uid'] != 1 && $auth_result === false && !in_array($controller, $allow_controller) && !in_array($method, $allow_method))
	        	{        		
	        		if(IS_AJAX)
	        		{
	        			echo json_encode(array('auth' => 1, 'msg' => '没有权限'));
	        			exit;
	        		}
	        		else
	        		{
	        			showmessage('没有权限', 'back', 1); //改
	        		}
	        	}
	        }
        }
	}

	/**
	 * 分配用户名
	 */
	public function assign_username()
	{
		$uid = $_SESSION['uid'];
		$username = $this->db->where(array('id' => $uid))->get('user')->row_array();
		$this->load->vars('username', $username['name']);
	}

	/**
	 * 分配左侧菜单栏
	 */
	protected function assign_sidebar()
	{
		$uid = $_SESSION['uid'];
		$role_info = $this->common_model->get_role_info($uid);  // 获取当前用户的角色信息

		$current = $this->common_model->get_current_menu();
		$this->load->vars('current', $current);

		$menu = $this->common_model->get_sidebar($role_info);
		$menu = $this->getMenu($menu);
		$this->load->vars('menu', $menu);		
	}
}