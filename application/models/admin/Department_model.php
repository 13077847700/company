<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Department_model extends CI_Model
{

	/**
	 * 获取部门列表
	 * $field 字段名, $order => 'asc' - 升序 , 'desc' - 降序
	 * return array
	 */
	public function get_department_list($field = '', $order = 'ASC')
	{
		$data = $this->db->select($field)
							->order_by('id', $order)
							->get('department')
							->result_array();
		return $data;
	}

	/**
	 * 获取要编辑部门的信息
	 */
	public function get_department_info($id)
	{
		if($id)
		{
			$department = $this->db->where(array('id' => $id))->get('department')->row_array();
			return $department;
		}
	}

	/**
	 * 新增或更新时间段
	 */
	public function add_or_update($data)
	{
		if($data['id'])
		{
			$bool = $this->db->where(array('id' => $data['id']))->update('department', $data);
			if($bool)
			{
				addlog('更新部门成功！名称 : ' . $data['dept_name']);
				redirect('admin/Department/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}			
		}
		else
		{
			unset($data['id']);
			$bool = $this->db->insert('department', $data);

			if($bool)
			{
				addlog('新增部门成功！名称 : ' . $data['dept_name']);
				redirect('admin/Department/index');
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
			$bool = $this->db->where(array('id' => $id))->delete('department');

			if($bool)
			{
				addlog('删除部门, ID: ' . $id);
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