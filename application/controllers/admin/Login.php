<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Login extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/user_model');
	}

	public function index()
	{
		$this->load->view('Login/index');
	}

	/**
	 * 生成验证码
	 */ 
	public function code()
	{
		$vals = array(
		    'word' => rand_chr(4),
		    //'img_path' => './captcha/',
		    //'img_url' => base_url() . 'captcha/', //程序迁移性强
		    'font_path' => './public/fonts/ttfs/6.ttf',
		    'img_width' => '144',
		    'img_height' => 40,
		    'expiration'   => 300,
            'word_length'  => 6,
            'font_size'    =>20,
            'colors'       => array(
                                    'background' => array(230, 230, 250),
                                    'border'     => array(230, 230, 250),
                                    'text'       => array(40, 40, 40),
                                    'grid'       => array(102, 205, 170)
                                                       )
		);

		$cap = create_captcha($vals);
		$_SESSION['code'] = $cap['word'];
		echo $cap['image'];
	}

	/**
	 * 异步验证用户名,密码
	 */
	public function check_user()
	{
		$data['code'] = $this->input->post('code');

		$status = array();
		if(strtoupper($data['code']) != $_SESSION['code'])
		{
			$status = array('status' => 1);  // 验证码 
		}
		else
		{
			$user = $this->user_model->get_user();
			if(!$user)
			{
				$status = array('status' => 2);  // 用户名或密码不正确
			}
			else if($user['status'] == 1)
			{
				$status = array('status' => 3);  // 该用户已被禁用
			}
			else
			{
				$status = array('status' => 0);
			}
		}

		echo json_encode($status);
	}

	/**
	 * 登录成功，处理数据
	 */
	public function dologin()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', '用户名', 'required');
		$this->form_validation->set_rules('password', '密码', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('参数错误', 'back', 1);
		}
		else
		{
			$user = $this->user_model->get_user();

			$remember = $this->input->post('remember');
			$remember = isset($remember) ? $remember : 0;

			if($user)
			{
				$salt = COOKIE_SALT;
				$ip = $this->input->ip_address();
				$ua = $_SERVER['HTTP_USER_AGENT'];

				$identifier = password($user['id'].$user['username'].$ua.$ip.$salt);
				$token = md5(uniqid(rand(), TRUE));
				$timeout = time() + 3600 * 24 * 7;

				$_SESSION['uid'] = $user['id'];   // 用户id写入session
				if($remember)  // 记住密码
				{
					setcookie('auth', "$identifier:$token", $timeout, '/company');
				}
				else
				{
					setcookie('auth', "$identifier:$token", '0', '/company');
				}

				$data = array(
					'login_time' => date("Y-m-d H:i:s", time()),
					'identifier' => $identifier,
					'token' => $token,
					'timeout' => $timeout
				);

				$this->db->where(array('id' => $user['id']))->update('user', $data);

				addlog('登录成功！');
				redirect('admin/Home/index');
			}
			else
			{
				$username = $this->input->post('username');
				addlog('登录失败。', $username);
				showmessage('参数错误', 'back', 1);
			}
		}
	}
}