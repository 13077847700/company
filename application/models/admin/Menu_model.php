<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
	/**
	 * 获取菜单列表
	 */
	public function get_menu()
	{
		$data = $this->db->where(array('is_menu' => 1))
						->order_by('o', 'ASC')
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
			addlog('菜单更新成功！菜单名称 : ' . $data['title']);
			redirect('admin/Menu/index');
		}
		else
		{
			unset($data['id']);
			$bool = $this->db->insert('auth_rule', $data);

			if($bool)
			{
				addlog('新增菜单成功！菜单名称 : ' . $data['title']);
				redirect('admin/Menu/index');
			}	
			else
			{
				showmessage('参数错误', 'back', 1);
			}					
		}
	}

	/**
	 * 获取要编辑的菜单的信息, 返回显示到模态框中
	 */
	public function get_menu_info($id)
	{
		return $this->db->where(array('id' => $id))->get('auth_rule')->row_array();
	}

	/**
	 * 删除菜单
	 */
	public function delete($id)
	{
		return $this->db->where(array('id' => $id))->delete('auth_rule');			
	}
}