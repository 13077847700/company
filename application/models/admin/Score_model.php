<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Score_model extends CI_Model
{
	/**
	 * 获取要评价员工的信息
	 */
	public function get_evaluation_info($id)
	{
		if($id)
		{
			$evaluation = array();
			$evaluation = $this->db->where(array('assign_id' => $id))->get('evaluation')->row_array();
			$uid = $this->db->select('user_id')->where(array('id' => $id))->get('assign_user')->row_array();
			$user = $this->db->select('name')->where(array('id' => $uid['user_id']))->get('user')->row_array();
			$evaluation['user'] = $user['name'];

			//dump($evaluation);die;
			return $evaluation;
		}
	}

	/**
	 * 新增或更新时间段
	 */
	public function add_or_update($data)
	{
		if($data['id'])
		{
			$bool = $this->db->where(array('id' => $data['id']))->update('evaluation', $data);
			if($bool)
			{
				//addlog('更新部门成功！名称 : ' . $data['dept_name']);
				redirect('admin/Score/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}			
		}
		else
		{
			unset($data['id']);
			$bool = $this->db->insert('evaluation', $data);

			if($bool)
			{
				//addlog('新增部门成功！名称 : ' . $data['dept_name']);
				redirect('admin/Score/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}
		}
	}
}