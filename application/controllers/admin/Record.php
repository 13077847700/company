<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

/**
 * 年假查询控制器
 */

class Record extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/department_model');
		$this->load->model('admin/record_model');
	}

	public function test()
	{
		$data = $this->db->select('uid, last_real, last_have, last_left')->get('vacation')->result_array();
		foreach($data as $v)
		{
			$temp['real_vacation'] = $v['last_real'];
			$temp['have_vacation'] = $v['last_have'];
			$temp['left_vacation'] = $v['last_left'];
			$this->db->where(array('uid' => $v['uid']))->update('record', $temp);
		}
		echo "success";
	}

	/**
	 * 年假列表
	 */
	public function index()
	{
		$where = $this->get_where();

		/* 分页代码开始 */
		$this->load->library('pagination');
		$page_size = 15;  // 每页显示10条数据
		$count = $this->record_model->get_count($where);

		$config['base_url'] = site_url('admin/Record/index');
		$config['total_rows'] = $count;
		$config['per_page'] = $page_size;

	    $offset = intval($this->uri->segment(4));

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();
		/* 分页代码结束 */

		$data['dept_name'] = $this->department_model->get_department_list('id, dept_name'); // 获取部门信息

		$field = 'u.name, d.dept_name, u.position, u.entry_date, r.*';
		$data['list'] = $this->record_model->get_record_list($field, $where, $offset, $page_size);  // 获取年假
		//dump($data);die;
		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Record/index', $data);
	}

	/**
	 * 获取搜索条件
	 */
	private function get_where()
	{
		$uid = $_SESSION['uid'];
		$role_info = $this->common_model->get_role_info($uid);  // 获取当前用户的角色信息

		foreach ($role_info as $v) 
		{
			if($v['title'] == '超级管理员')  // 超级管理员
			{
				$where = 'is_delete = 0';
				if(isset($_GET['name']) && $_GET['name'] != null)
				{
					$data['name'] = trim($_GET['name']);
					$where = $where . ' and name LIKE "%' . $data['name'] . '%"';
				}

				if(isset($_GET['dept_id']) && $_GET['dept_id'] != null)
				{
					$where = $where . ' and department_id = ' . $_GET['dept_id'] . "";
				}

				if(isset($_GET['year']) && $_GET['year'] != null)
				{
					$this->load->vars('select_year', $_GET['year']);
				}
				else
				{
					$_GET['year'] = date("Y") - 1;
					$this->load->vars('select_year', $_GET['year']);
				}

				$where = $where . ' and year = ' . $_GET['year'] . "";

				$this->load->vars('title', $v['title']);
				break;
			}
			else
			{
				$where = array('u.id' => $_SESSION['uid']);
			}
		}
		
		return $where;
	}
}