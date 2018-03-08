<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

/**
 * 考核打分控制器
 */

class Score extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/quarter_model');
		$this->load->model('admin/result_model');
		$this->load->model('admin/check_model');
		$this->load->model('admin/score_model');
	}

	public function index()
	{

		$data = $this->quarter_model->get_quarter_list(array('status' => 1));  // 找出正在考核的季度id

		if($data)
		{
			$where = array('quarter_id' => $data[0]['id'], 'judger_id' => $_SESSION['uid']);	
		}
		else
		{
			$where = '1 = 2'; // what???
		}

		$data['list'] = $this->result_model->get_detail_list($where);  // 待考核员工信息	

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Score/index', $data);
	}

	// 显示待评价员工列表
	public function comment()
	{
		$id = $this->input->get('id');

		$level = $this->input->get('level');

		$level = isset($level) ? $level : 1;

		$where = array('group_id' => $level);

		$data['level'] = $level;

		$data['list'] = $this->check_model->get_check_list($where);  // 考核内容

		$data['info'] = $this->score_model->get_evaluation_info($id);  // 获取评价填写的信息

		//dump($data);die;

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Score/comment', $data);
	}

	// 对员工进行评分
	public function mark()
	{
		$data = $this->input->post();
		$count = count($data['score']);

		for($i = 0; $i < $count; $i++)
		{
			if($data['score'][$i] == null || $data['score'][$i] < 0 || $data['score'][$i] > 100 || !is_numeric($data['score'][$i]))
			{
				showmessage('参数错误', 'back', 1);
			}
		}
		
		for($i = 1; $i < 6; $i++)
		{
			$data["score{$i}"] = isset($data['score'][$i - 1]) ? $data['score'][$i - 1] : 0;
		}
		unset($data['score']);
		$data['create_time'] = date('Y-m-d H:i:s', time());
		$this->score_model->add_or_update($data);
	}

}
