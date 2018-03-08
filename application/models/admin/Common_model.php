<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model
{
	/**
	 * 获取当前用户的角色信息
	 */
	public function get_role_info($uid)
	{
		$role_info = $this->db->from('auth_group as g')
								->join('auth_group_access as ga', 'g.id = ga.group_id', 'left')
								->where(array('ga.uid'=>$uid))
								->get()
								->result_array();
		return $role_info;
	}

	/**
	 * 获取当前菜单信息
	 */
	public function get_current_menu()
	{
		$current_class_name = $this->router->fetch_class();
		$current_method_name = $this->router->fetch_method() == 'edit' ? 'index' : $this->router->fetch_method();
		$name = $current_class_name . '/' . $current_method_name;

		$current = $this->db->select('s.id, s.title, s.name, s.pid, p.pid as ppid, p.title as ptitle')
				->from('auth_rule as s')
				->join('auth_rule as p', 'p.id = s.pid', 'left')
				->where(array('s.name'=>$name))
				->get()
				->row_array();

		return $current;
	}

	/*
	 * 获取左侧菜单 
	 */
	public function get_sidebar($role_info)
	{
		$menu_access_id = array();
		foreach ($role_info as $val) 
		{
			$menu_access_id[] = explode(',', $val['rules']);
		}

		$temp_array = array();
		foreach ($menu_access_id as $v) 
		{
			foreach ($v as $value) 
			{
				$temp_array[] = $value;
			}
		}

		$menu_access_id = array_unique($temp_array);
		
		$str = implode(',', $menu_access_id);

		foreach ($role_info as $val) 
		{
			if($val['group_id'] != 1)
			{
				$menu_where = "AND id in ($str) ";
			}
			else
			{
				$menu_where = '';
				break;
			}
		}
		
		$menu = $this->db->select('id,title,pid,name,icon')
							->where("is_menu=1 AND is_show=1 $menu_where ")
							->order_by('o', 'ASC')
							->get('auth_rule')
							->result_array();
				
		return $menu;
	}
}