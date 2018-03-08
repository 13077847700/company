<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Group_model extends CI_Model
{
	/**
	 * 获取分组列表
	 * $field 字段名, $order => 'asc' - 升序 , 'desc' - 降序
	 * return array
	 */
	public function get_group_list($field = '', $order = 'ASC')
	{
		$data = $this->db->select($field)
							->order_by('id', $order)
							->get('group')
							->result_array();
		return $data;
	}

	/**
	 * 获取要编辑分组的信息
	 */
	public function get_group_info($id)
	{
		if($id)
		{
			$group = $this->db->where(array('id' => $id))->get('group')->row_array();
			return $group;
		}
	}

	/**
	 * 新增或更新分组
	 */
	public function add_or_update($data)
	{
		if($data['id'])
		{
			$bool = $this->db->where(array('id' => $data['id']))->update('group', $data);
			if($bool)
			{
				addlog('用户组成功！组名 : ' . $data['username'] . ' , id : ' . $data['id']);
				redirect('admin/Group/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}			
		}
		else
		{
			unset($data['id']);
			$bool = $this->db->insert('group', $data);

			if($bool)
			{
				addlog('新增组成功！组名 : ' . $data['username'] . ' , id : ' . $uid);
				redirect('admin/Group/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}
		}
	}

	/**
	 * 删除分组
	 */
	public function del($id)
	{
		if($id)
		{
			$bool = $this->db->where(array('id' => $id))->delete('group');

			if($bool)
			{
				addlog('删除分组, ID: ' . $id);
				return true;
			}
			else
			{
				showmessage('参数错误', 'back', 1);
				return false;
			}			
		}
	}
}