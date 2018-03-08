<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

/**
 * 年假查询控制器
 */

class Vacation extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/department_model');
		$this->load->model('admin/vacation_model');
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
		$count = $this->vacation_model->get_count($where);

		$config['base_url'] = site_url('admin/Vacation/index');
		$config['total_rows'] = $count;
		$config['per_page'] = $page_size;

	    $offset = intval($this->uri->segment(4));

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();
		/* 分页代码结束 */

		$this->update_year();  // 更新年份
		$this->save_standard_vacation($where, $offset, $page_size);  // 将标准年假, 可休年假保存到数据库中
		$this->save_have_vacation($where, $offset, $page_size);  // 将已休年假，剩余年假等数据更新到数据库中
		//$this->vacation_model->initDetailVacation();

		$data['dept_name'] = $this->department_model->get_department_list('id, dept_name'); // 获取部门信息

		$field = 'u.name, d.dept_name, u.position, u.entry_date, v.*';
		$data['list'] = $this->vacation_model->get_vacation_list($field, $where, $offset, $page_size);  // 获取年假

		//dump($data);die;
		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Vacation/index', $data);
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

	/**
	 * 更新年份
	 */
	public function update_year()
	{
		$data['year'] = date('Y');  //今年的年份
		$this->db->where(array('id > ' => 0))->update('vacation', $data);
	}

	/**
	 * 将标准年假, 可休年假保存到表中
	 * @author: 江南烟雨 <773157920@qq.com>
	 */
	public function save_standard_vacation($where, $offset, $page_size)
	{
		$field = 'u.id, u.entry_date';
		$entry_date = $this->vacation_model->get_vacation_list($field, $where, $offset, $page_size);

		$vacation = array();
		foreach($entry_date as $k => $v)
		{
			$v['entry_date'] = strtotime($v['entry_date']);
			$vacation[] = $this->vacation_model->count_vacation($v['entry_date']);
			$data['last_real'] = $vacation[$k][0];
			$data['real_vacation'] = $vacation[$k][1];

			$entry_year = explode('-', $entry_date[$k]['entry_date']);

			$year = date("Y") - $entry_year[0];
			//$year = 2018 - $entry_year[0];
			//dump($year);
			if($year < 0)
			{
				$data['last_standard'] = 0;
				$data['standard'] = 0;
			}
			else if($year == 0)
			{
				$data['last_standard'] = 0;
				$data['standard'] = 7;
			}
			else
			{	
				$data['last_standard'] = 6 + $year;
				$data['standard'] = 7 + $year;
			}
			
			$this->db->where(array('uid' => $entry_date[$k]['id']))->update('vacation', $data);
		}
	}

	public function save_have_vacation($where, $offset, $page_size)
	{
		$now = time(); // 当前时间戳
		//$now = strtotime("2018-01-30");

		$now_year = date('Y', $now);    //今年的年份	
		$middle = strtotime("$now_year-7-1 0:0:0");    //今年7月1日的时间戳

		if($now < $middle)  // 今年上半年
		{
			$field1 = 'v.uid, v.last_real, v.real_vacation, v.pre_vacation';
			$field2 = 'v.jan, v.feb, v.mar, v.apr, v.may, v.jun';

			$vacation = $this->vacation_model->get_vacation_list($field1, $where, $offset, $page_size);  
			$first_have = $this->vacation_model->get_vacation_list($field2, $where, $offset, $page_size); // 上半年请的年假

			$first_have_sum = array();
			foreach ($first_have as $kk => $vv) 
			{
				$first_have_sum[] = array_sum($vv);  // 今年上半年休的假	
			}

			$i = 0;
			foreach ($vacation as $k => $v) 
			{
				$data['pre_left'] = $v['pre_vacation'];  //（上一年的已休年假）去年已休年假存起来 	

				if(($v['last_real'] - $v['pre_vacation']) != 0 && ($v['pre_vacation'] + $first_have_sum[$i]) < $v['last_real'])
				{
					$data['last_have'] = $v['pre_vacation'] + $first_have_sum[$i];   //去年已休年假
					$data['last_left'] = $v['last_real'] - $data['last_have'];   //去年剩余年假
					$data['have_vacation'] = 0;   //今年已休年假
					$data['left_vacation'] = $v['real_vacation'] - $data['have_vacation'];  //今年剩余年假

				}
				else
				{	
					$data['last_have'] = $v['last_real'];   //去年已休年假	
					$data['last_left'] =  $v['last_real'] - $data['last_have'];   //去年剩余年假
					$data['have_vacation'] = $v['pre_vacation'] + $first_have_sum[$i] - $v['last_real'];   //今年已休年假
					$data['left_vacation'] = round(($v['real_vacation'] - $data['have_vacation']), 1);  //今年剩余年假
				}

				$i++;
				$this->db->where(array('uid' => $v['uid']))->update('vacation', $data);						
			}
		}
		else // 今年下半年
		{
			$field1 = 'v.uid, v.last_real, v.real_vacation, v.pre_left, v.last_have, v.last_left';
			$field2 = 'v.jan, v.feb, v.mar, v.apr, v.may, v.jun, v.jul, v.aug, v.sep, v.oct, v.nov, v.dec';

			$vacation = $this->vacation_model->get_vacation_list($field1, $where, $offset, $page_size);
			$full_year = $this->vacation_model->get_vacation_list($field2, $where, $offset, $page_size); // 全年请的年假
			$full_year_sum = array();
			foreach ($full_year as $kk => $vv) 
			{
				$full_year_sum[] = array_sum($vv);  // 今年休的假	
			}

			$i = 0;
			foreach ($vacation as $k => $v) 
			{
				if(($v['last_real'] - $v['last_have']) != 0)
				{
					$data['have_vacation'] = $full_year_sum[$i] + $v['pre_left'] - $v['last_have'];  //今年已休年假
				}
				else
				{
					$data['have_vacation'] = $v['pre_left'] + $full_year_sum[$i] - $v['last_real'];  //今年已休年假
				}

				$data['pre_vacation'] = $data['have_vacation'];   //今年已休年假存起来

				$data['left_vacation'] = $v['real_vacation'] - $data['have_vacation'];   //今年剩余年假
				
				$data['last_left'] =  $v['last_real'] - $v['last_have'];   //去年剩余年假 

				//dump($data);die;
				$i++;
				$this->db->where(array('uid' => $v['uid']))->update('vacation', $data);						
			}
		}
	}

	public function save_table_cell()
	{
		$id = $this->input->post('id');
		$month = $this->input->post('month');
		$data["$month"] = $this->input->post('value');

		$bool = $this->db->where(array('id' => $id))->update('vacation', $data);
		if($bool)
		{
			echo json_encode(array('msg' => 'ok'));
		}
	}
}
