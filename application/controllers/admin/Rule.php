<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 规则控制器（菜单也是规则！！！）所以代码和菜单控制器一样
 */

class Rule extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/rule_model');
		$this->load->model('admin/menu_model');
	}

	public function index()
	{
		$data['list'] = $this->rule_model->get_menu();  // 菜单列表

		$data['option'] = $this->getMenu($data['list']);

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Rule/index', $data);
	}

	/**
	 * 新增或编辑菜单项
	 */
	public function add_or_update()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', '规则名称', 'required');

		if($this->form_validation->run() == FALSE)
		{
			showmessage('规则名称不能为空', 'back', 1);
		}
		else
		{
			$data = array(
				'id' => $this->input->post('id'),
				'pid' => $this->input->post('pid'),
				'title' => $this->input->post('title'),
				'name' => $this->input->post('name'),
				'icon' => $this->input->post('icon'),
				'o' => $this->input->post('o'),
				'is_show' => $this->input->post('is_show'),
				'is_menu' => $this->input->post('is_menu'),
			);

			$this->rule_model->add_or_update($data);
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
	 * 显示编辑菜单的模态框
	 */
	public function edit()
	{
		$id = $this->input->post('id');
		$menu = $this->menu_model->get_menu_info($id);
		echo json_encode($menu);
	}

	/**
	 * 删除菜单
	 */
	public function del()
	{
		$id = $this->input->post('id');
		$bool = $this->menu_model->delete($id);

		if($bool)
		{
			addlog('删除规则, id : ' . $id);
			echo json_encode(array('status' => 1));
		}
		else
		{
			showmessage('参数错误', 'back', 1);
		}
	}
}
