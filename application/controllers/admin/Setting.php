<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 设置控制器
 * 密码修改
 */

class Setting extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('setting/index');
	}

	/**
	 * 异步验证密码
	 */
	public function check_pass()
	{
		$data = $this->get_pass_form_data();

		$user = $this->db->select('password')->where(array('id' => $_SESSION['uid']))->get('user')->row_array();

		$status = array();

		if($user['password'] != password($data['oldPass']))
		{
			echo json_encode(array('status' => 1));
		}
		else if(!preg_match("/(?=.*[0-9])(?=.*[a-zA-Z]).{8,16}/",$data['newPass']))
		{
			echo json_encode(array('status' => 2));
		}
		else 
		{
			echo json_encode(array('status' => 3));
		}	
	}

	/**
	 * 修改密码
	 */
	public function update_pass()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('oldPass', '旧密码不能为空!', 'required');
		$this->form_validation->set_rules('newPass', '新密码不能为空!', 'required');
		$this->form_validation->set_rules('confirmPass', '确认密码不能为空!', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('参数错误', 'back', 1);
		}
		else
		{
			$data = $this->get_pass_form_data();  // 获取表单数据
			if($data['newPass'] != $data['confirmPass'])
			{
				showmessage('新密码与确认密码不一致!', 'back', 1);
			}
			else
			{
				$newPass['password'] = password($data['newPass']);
				$this->db->where(array('id' => $_SESSION['uid']))->update('user', $newPass);
				addlog('密码修改成功!');
				showmessage('密码修改成功!', 'back', 1);
			}
		}
	}

	/**
	 * 获取表单数据
	 */
	private function get_pass_form_data()
	{
		$data = array(
			'oldPass' => $this->input->post('oldPass'),
			'newPass' => $this->input->post('newPass'),
			'confirmPass' => $this->input->post('confirmPass')
		);

		return $data;
	}
}
