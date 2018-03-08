<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 部门控制器
 */

class Department extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/department_model');
	}

	public function index()
	{
		$data['list'] = $this->department_model->get_department_list();  // 部门列表

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Department/index', $data);
	}

	/**
	 * 新增或编辑时间段
	 */
	public function add_or_update()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('dept_name', '部门', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('参数错误', 'back', 1);
		}
		else
		{
			$data = $this->get_form_data();  // 获取表单数据
			$this->department_model->add_or_update($data);
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
		$department = $this->department_model->get_department_info($id);
		echo json_encode($department);
	}

	/**
	 * 删除
	 */
	public function del()
	{
		$id = $this->input->post('id');
		$bool = $this->department_model->del($id);
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
			'dept_name' => $this->input->post('dept_name'),
			'remark' => $this->input->post('remark')
		);

		return $data;
	}
}
