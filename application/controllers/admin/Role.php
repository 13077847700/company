<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 权限控制器
 */

class Role extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/role_model');
	}

	public function index()
	{
		$data['list'] = $this->role_model->get_role();  // 角色列表

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Role/index', $data);
	}

	/**
	 * 新增或编辑角色
	 */
	public function add_or_update()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', '角色名称', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('角色名称不能为空', 'back', 1);
		}
		else
		{
			$this->role_model->add_or_update();
		}
	}

	/**
	 * 显示新增表单
	 */
	public function add()
	{
		$data['rule'] = $this->role_model->get_auth();
		$data['rule'] = $this->getMenu($data['rule']);

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Role/form', $data);
	}

	/**
	 * 显示编辑表单
	 */
	public function edit()
	{
		$data['rule'] = $this->role_model->get_auth();
		$data['rule'] = $this->getMenu($data['rule']);

		$id = $this->uri->segment(4);
		$data['group'] = $this->role_model->get_role_info($id);  // 获取该角色的角色信息

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Role/form', $data);
	}

	/**
	 * 删除角色
	 */
	public function del()
	{
		$id = $this->input->post('id');
		$bool = $this->role_model->delete($id);
		if($bool)
		{
			echo json_encode(array('status' => 1));
		}
	}
}
