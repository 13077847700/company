<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Check_model extends CI_Model
{

	/**
	 * 获取内容列表
	 * $level 1 - 员工 2 - 总监array('group_id' => $level)
	 */
	public function get_check_list($where)
	{
		$data = $this->db->where($where)
						->order_by('id', 'ASC')
						->get('check')
						->result_array();
		return $data;
	}

	/**
	 * 获取要编辑考核内容的信息
	 */
	public function get_check_info($id)
	{
		if($id)
		{
			$check = $this->db->where(array('id' => $id))->get('check')->row_array();
			return $check;
		}
	}

	/**
	 * 新增或更新
	 */
	public function add_or_update($data)
	{
		$level = $data['group_id'];
		
		if($data['id'])
		{
			$bool = $this->db->where(array('id' => $data['id']))->update('check', $data);
			if($bool)
			{
				addlog('更新考核内容成功！标题 : ' . $data['title']);
				redirect("admin/Check/index?level=$level");
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}			
		}
		else
		{
			unset($data['id']);
			$bool = $this->db->insert('check', $data);

			if($bool)
			{
				addlog('新增考核内容成功！标题 : ' . $data['title']);
				redirect("admin/Check/index?level=$level");
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}
		}
	}

	/**
	 * 删除
	 */
	public function del($id)
	{
		if($id)
		{
			$bool = $this->db->where(array('id' => $id))->delete('check');

			if($bool)
			{
				addlog('删除考核内容, ID: ' . $id);
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