<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Role_model extends CI_Model
{
	/**
	 * 获取角色列表
	 */
	public function get_role()
	{
		$data = $this->db->order_by('id', 'ASC')->get('auth_group')->result_array();
		return $data;
	}

	/**
	 * 获取权限列表
	 */
	public function get_auth()
	{
		$rule = $this->db->select('id, pid, title')->order_by('o', 'ASC')->get('auth_rule')->result_array();
		return $rule;
	}

	/**
	 * 新增或更新角色
	 */
	public function add_or_update()
	{
		$id = $this->input->post('id');

		$data = array(
			'title' => $this->input->post('title'),
			'remark' => $this->input->post('remark'),
			'rules' => $this->input->post('rules')
		);

		$rules = isset($data['rules']) ? $data['rules'] : 0;

		if(is_array($rules))
		{
			foreach($rules as $k => $v)
			{
				$rules[$k] = intval($v);
			}
			$rules = implode(',', $rules);
		}
		$data['rules'] = $rules;

		if($id)
		{
			$time = time();
			$data['update_time'] = date("Y-m-d H:i:s",$time);
			$this->db->where(array('id'=>$id))->update('auth_group', $data);
			addlog('角色更新成功！角色名称 : ' . $data['title']);
			redirect('admin/Role/index');
		}
		else
		{
			$time = time();
			$data['add_time'] = date("Y-m-d H:i:s",$time);
			$bool = $this->db->insert('auth_group', $data);

			if($bool)
			{
				addlog('新增角色成功！角色名称 : ' . $data['title']);
				redirect('admin/Role/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}
		}
	}

	/**
	 * 获取该角色的角色信息
	 */
	public function get_role_info($id)
	{		
		if($id)
		{
			$group = $this->db->where(array('id' => $id))->get('auth_group')->row_array();
			$group['rules'] = explode(',', $group['rules']);
			return $group;
		}
		else
		{
			showmessage('参数错误', 'back', 1);
		}
	}

	/**
	 * 删除角色
	 */
	public function delete($id)
	{
		if($id)
		{
			$data = $this->db->select('title')->where(array('id' => $id))->get('auth_group')->row_array();
			$bool = $this->db->where(array('id' => $id))->delete('auth_group');

			if($bool)
			{
				addlog('删除角色, 角色名称 : ' . $data['title'] . ' , id : ' . $id);
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