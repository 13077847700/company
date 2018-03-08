<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户控制器
 */

class Group extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/group_model');
	}

	public function index()
	{
		$data['list'] = $this->group_model->get_group_list();  // 分组列表

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Group/index', $data);
	}

	/**
	 * 新增或编辑用户
	 */
	public function add_or_update()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', '组名', 'required');
		$this->form_validation->set_rules('assess_num', '互评数', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('参数错误', 'back', 1);
		}
		else
		{
			$data = $this->get_form_data();  // 获取表单数据
			$this->group_model->add_or_update($data);
		}		
	}

	/**
	 * 空方法（用于检测是否有添加按钮的权限）
	 */
	public function add()
	{
		echo json_encode(array('msg' => '成功'));
	}

	/**
	 * 显示编辑用户表单的模态框
	 */
	public function edit()
	{
		$id = $this->input->post('id');
		$group = $this->group_model->get_group_info($id);
		echo json_encode($group);
	}

	/**
	 * 删除
	 */
	public function del()
	{
		$id = $this->input->post('id');
		$bool = $this->group_model->del($id);
		if($bool)
		{
			echo json_encode(array('status' => 1));
		}
	}

	/**
	 * 获取表单数据
	 */
	private function get_form_data()
	{
		$data = array(
			'id' => intval($this->input->post('id')),
			'title' => $this->input->post('title'),
			'assess_num' => $this->input->post('assess_num'),
			'remark' => $this->input->post('remark')
		);

		return $data;
	}
}
