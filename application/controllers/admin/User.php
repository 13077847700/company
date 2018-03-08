<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户控制器
 */

class User extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/user_model');
		$this->load->model('admin/department_model');
		$this->load->model('admin/group_model');
	}

	public function index()
	{
		$where = $this->get_where();

		/* 分页代码开始 */
		$this->load->library('pagination');
		$page_size = 10;  // 每页显示10条数据
		$count = $this->db->where($where)->count_all_results('user');

		$config['base_url'] = site_url('admin/User/index');
		$config['total_rows'] = $count;
		$config['per_page'] = $page_size;

	    $offset = intval($this->uri->segment(4));

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();
		/* 分页代码结束 */

		$data['dept_name'] = $this->department_model->get_department_list('id, dept_name'); // 获取部门信息
		$data['group'] = $this->group_model->get_group_list('id, title');  // 获取分组信息

		$data['list'] = $this->user_model->get_user_list($where, $offset, $page_size);  // 用户列表
		$data['role'] = $this->user_model->get_role();  // 角色列表

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('User/index', $data);
	}

	/**
	 * 获取搜索条件
	 */
	private function get_where()
	{
		$where = '1 = 1';
		if(isset($_GET['name']) && $_GET['name'] != null)
		{
			$data['name'] = trim($_GET['name']);
			$where = $where . ' and name LIKE "%' . $data['name'] . '%"';
		}

		if(isset($_GET['s_gid']) && $_GET['s_gid'] != null)
		{
			$where = $where . " and gid = " . $_GET['s_gid'] . "";
		}

		if(isset($_GET['dept_id']) && $_GET['dept_id'] != null)
		{
			$where = $where . " and department_id = " . $_GET['dept_id'] . "";
		}

		if(isset($_GET['job_id']) && $_GET['job_id'] == 1)
		{
			$where = $where . " and is_delete = 1";
		}
		else
		{
			$where = $where . " and is_delete = 0";
		}

		return $where;
	}

	/**
	 * 新增或编辑用户
	 */
	public function add_or_update()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', '用户名', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('参数错误', 'back', 1);
		}
		else
		{
			$data = $this->get_form_data();  // 获取表单数据
			$this->user_model->add_or_update($data);
		}		
	}

	/**
	 * 获取下拉框的值
	 */
	public function add()
	{
		$group = $this->group_model->get_group_list('id, title');  // 获取分组信息
		$dept = $this->department_model->get_department_list('id, dept_name'); // 获取部门信息

		echo json_encode(array('group' => $group, 'dept' => $dept));
	}

	/**
	 * 显示编辑用户表单的模态框
	 */
	public function edit()
	{
		$group = $this->group_model->get_group_list('id, title');  // 获取分组信息
		$dept = $this->department_model->get_department_list('id, dept_name'); // 获取部门信息

		$id = $this->input->post('id');
		$user = $this->user_model->get_user_info($id);

		echo json_encode(array('group' => $group, 'dept' => $dept, 'user' => $user));
	}

	/**
	 * 删除用户
	 */
	public function del()
	{
		$id = $this->input->post('id');
		$bool = $this->user_model->del($id);
		if($bool)
		{
			echo json_encode(array('status' => 1));
		}
	}

	/**
	 * 修改状态
	 */
	public function status()
	{
		$id = $this->input->post('id');
		$status = $this->user_model->change_status($id);
		echo json_encode(array('status' => $status));
	}

	/**
	 * 获取表单数据
	 */
	private function get_form_data()
	{
		$data = array(
			'id' => intval($this->input->post('id')),
			'username' => $this->input->post('username'),
			'name' => $this->input->post('name'),
			'password' => $this->input->post('password'),
			'gid' => intval($this->input->post('gid')),
			'department_id' => $this->input->post('department_id'),
			'position' => $this->input->post('position'),
			'entry_date' => $this->input->post('entry_date'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'status' => $this->input->post('status'),
			'title_id' => $this->input->post('title')
		);

		return $data;
	}
}
