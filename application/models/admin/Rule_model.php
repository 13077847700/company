<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Rule_model extends CI_Model
{
	/**
	 * 获取菜单列表（此处筛选出所有的规则，包括菜单！其他代码都一样）
	 */
	public function get_menu()
	{
		$data = $this->db->order_by('o', 'ASC')
						->get('auth_rule')
						->result_array();
		return $data;
	}

	/**
	 * 新增或更新菜单
	 */
	public function add_or_update($data)
	{
		if($data['id'])
		{
			$this->db->where(array('id'=>$data['id']))->update('auth_rule', $data);
			addlog('规则更新成功！规则名称 : ' . $data['title']);
			redirect('admin/Rule/index');
		}
		else
		{
			unset($data['id']);
			$bool = $this->db->insert('auth_rule', $data);

			if($bool)
			{
				addlog('新增规则成功！规则名称 : ' . $data['title']);
				redirect('admin/Rule/index');
			}	
			else
			{
				showmessage('参数错误', 'back', 1);
			}					
		}
	}
}