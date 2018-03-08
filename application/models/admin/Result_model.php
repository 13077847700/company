<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Result_model extends CI_Model
{

	/**
	 * 获取考核结果明细表数据
	 */
	public function get_detail_list($where)
	{
		$data = $this->db->select('a.id, d.dept_name as u_dept, u.position, u.name as user, dd.dept_name as uu_dept, uu.name as judger, e.score1, e.score2, e.score3, e.score4, e.score5, e.advantage, e.advise, e.create_time')
						->from('assign_user as a')
						->join('user as u', 'u.id = a.user_id', 'left')
						->join('department as d', 'd.id = u.department_id', 'left')
						->join('user as uu', 'uu.id = a.judger_id', 'left')
						->join('department as dd', 'dd.id = uu.department_id', 'left')
						->join('evaluation as e', 'e.assign_id = a.id', 'left')
						->where($where)
						->get()
						->result_array();
		//dump($data);die;
		return $data;
	}

	/**
	 * 获取考核结果分析表数据
	 */
	public function get_analysit_list($where)
	{
		$data = $this->db->select('a.id, d.dept_name as u_dept, u.id as uid, u.position, u.name as user')
						->from('assign_user as a')
						->join('user as u', 'u.id = a.user_id', 'left')
						->join('department as d', 'd.id = u.department_id', 'left')
						->where($where)
						->group_by('user')
						->order_by('u_dept')
						->get()
						->result_array();
		//dump($data);die;
		return $data;
	}
}