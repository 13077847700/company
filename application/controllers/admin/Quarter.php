<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

/**
 * 季度控制器
 */

class Quarter extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/quarter_model');
	}

	public function index()
	{
		$where = $this->get_where();

		/* 分页代码开始 */
		$this->load->library('pagination');
		$page_size = 10;  // 每页显示10条数据
		$count = $this->db->where($where)->count_all_results('quarter');

		$config['base_url'] = site_url('admin/Quarter/index');
		$config['total_rows'] = $count;
		$config['per_page'] = $page_size;

	    $offset = intval($this->uri->segment(4));

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();
		/* 分页代码结束 */

		$data['list'] = $this->quarter_model->get_quarter_list($where, $offset, $page_size);  // 时间段列表

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Quarter/index', $data);
	}

	private function get_where()
	{
		return $where = '1 = 1';
	}

	/**
	 * 新增或编辑时间段
	 */
	public function add_or_update()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('year', '年份', 'required');
		$this->form_validation->set_rules('quarter', '考核季度', 'required');
		$this->form_validation->set_rules('startDate', '开始时间', 'required');
		$this->form_validation->set_rules('endDate', '结束时间', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('参数错误', 'back', 1);
		}
		else
		{
			$data = $this->get_form_data();  // 获取表单数据
			$this->quarter_model->add_or_update($data);
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
		$quarter = $this->quarter_model->get_quarter_info($id);
		echo json_encode($quarter);
	}

	/**
	 * 删除
	 */
	public function del()
	{
		$id = $this->input->post('id');
		$bool = $this->quarter_model->del($id);
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
			'year' => intval($this->input->post('year')),
			'quarter' => $this->input->post('quarter'),
			'startdate' => $this->input->post('startDate'),
			'enddate' => $this->input->post('endDate'),
			'remark' => $this->input->post('remark')
		);

		return $data;
	}

	/**
	 * 开始考核
	 */
	public function start_check($times = 1000)
	{
		if($times == 0)
		{
			echo json_encode(array('status' => 4));  // 请重试或者重新调整分组名单!
			exit();
		}

		$id = $this->input->post('id');

		$quarter = $this->quarter_model->get_quarter_info($id);

		if($quarter['status'] == 2)
		{
			echo json_encode(array('status' => 2));  // 该考核季度已结束!
			exit();
		}
		else
		{
			$group_name = $this->db->select('id, department_id, gid')->where(array('is_delete' => 0, 'gid != ' => 0))->get('user')->result_array();  // 分组名单

			foreach ($group_name as $k => $v) 
			{
				$group[$v['gid']][] = $v;  // 同一个组的分到一起
			}

			$group = array_values($group); // 返回数组中所有的值并给其建立数字索引(分组名单)

			$temp = array();
			for($i = 0; $i < count($group); $i++)
			{	
				$temp[$i] = $this->allots($group[$i], $times);	
			}

			foreach ($temp as $v) 
			{
				foreach ($v as $val) 
				{
					for($j = 0; $j < count($val) - 3; $j++)
					{
						$data['quarter_id'] = $id;
						$data['judger_id'] = $val['id'];
						$data['user_id'] = $val[$j];
						$time = time();
						$data['create_time'] = date("Y-m-d H:i:s", $time);
						//dump($data);die;

						$bool = $this->db->insert('assign_user', $data);

						$arr = array();
						if($bool)
						{
							$arr['assign_id'] = $this->db->insert_id();
							$this->db->insert('evaluation', $arr);
						}
					}
					//dump($data);
				}
			}

			$status['isalloted'] = 1;
			$status['status'] = 1;

			$bool = $this->db->where(array('id' => $id))->update('quarter', $status); // 改变时间段的状态
			if($bool)
			{	
				echo json_encode(array('status' => 3));  //名单已分配, 考核中...
				exit();
			}
		}	
	}

	// 分配名单
	public function allots($input = array(), $times)
	{
		// var_dump($input);
		$count = count($input);
		$j = 0;

		foreach ($input as $key => $val) 
		{
			$arr = array();
			for($i = 0; $i < $count; $i++)
			{
				if($input[$i]['department_id'] == $val['department_id'] || count($input[$i]) == 3+9)
				{
					$arr[$i] = $input[$i];
					unset($input[$i]);
				}
			}

			if(count($input) < 8)  // 若少于8个数组
			{
				$this->start_check(--$times); // 循环
			}

			//var_dump($input);
			$rand_keys = array_rand($input, 8);
			//var_dump($rand_keys);

			for($i = 0; $i < 8; $i++)
			{
				$input[$rand_keys[$i]][] = $arr[$j]['id'];
			}
			//var_dump($input);
			$input = $arr + $input;
			ksort($input);
			//var_dump($input);die;
			$j++;			
		}
	
		return $input;
	}

	// 结束考核
	public function end_check()
	{
		$id = $this->input->post('id');

		$quarter = $this->quarter_model->get_quarter_info($id);

		if($quarter['status'] != 1)
		{
			echo json_encode(array('status' => 1));
		}
		else
		{
			// count 计算考核结果
			$data['status'] = 2;  // 状态为2 => 考核结束
			$bool = $this->db->where(array('id' => $id))->update('quarter', $data); // 改变时间段的状态
			if($bool)
			{
				echo json_encode(array('status' => 2));
			}			
		}		
	}
}
