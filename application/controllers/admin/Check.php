<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 考核打分控制器
 */

class Check extends My_Controller 
{
	//public static $level = 1;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/check_model');
	}

	public function index()
	{
		$level = $this->input->get('level');

		$level = isset($level) ? $level : 1;

		$where = array('group_id' => $level);

		$data['level'] = $level;

		$data['list'] = $this->check_model->get_check_list($where);  // 列表

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Check/index', $data);
	}

	/**
	 * 新增或编辑时间段
	 */
	public function add_or_update()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('group_id', '考核级别', 'required');
		$this->form_validation->set_rules('title', '考核标题', 'required');
		$this->form_validation->set_rules('proportion', '考核权重', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('参数错误', 'back', 1);
		}
		else
		{
			$data = $this->get_form_data();  // 获取表单数据
			$this->check_model->add_or_update($data);
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
		$check = $this->check_model->get_check_info($id);
		echo json_encode($check);
	}

	/**
	 * 删除
	 */
	public function del()
	{
		$id = $this->input->post('id');
		$bool = $this->check_model->del($id);
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
			'group_id' => $this->input->post('group_id'),
			'title' => $this->input->post('title'),
			'proportion' => $this->input->post('proportion'),
			'content1' => $this->input->post('content1'),
			'content2' => $this->input->post('content2'),
			'content3' => $this->input->post('content3'),
			'content4' => $this->input->post('content4'),
			'content5' => $this->input->post('content5'),
			'score1' => $this->input->post('score1'),
			'score2' => $this->input->post('score2'),
			'score3' => $this->input->post('score3'),
			'score4' => $this->input->post('score4'),
			'score5' => $this->input->post('score5'),
		);

		return $data;
	}
}
