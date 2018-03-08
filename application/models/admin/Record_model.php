<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Record_model extends CI_Model
{

	/**
	 * 年假列表数据
	 */

	public function get_record_list($field = '', $where = '1 = 1', $offset, $page_size)
	{
		$data = $this->db->select($field)
							->from('user as u')
							->join('department as d', 'd.id = u.department_id', 'left')
							->join('record as r', 'r.uid = u.id', 'left')
							->where($where)
							->limit($page_size, $offset)
							->get()
							->result_array();
		//echo $this->db->last_query();
		//dump($data);die;

		return $data;
	}

	public function get_count($where = '1 = 1')
	{
		$count = $this->db->from('user as u')
						->join('department as d', 'd.id = u.department_id', 'left')
						->join('record as r', 'r.uid = u.id', 'left')
						->where($where)
						->count_all_results();
		return $count;
	}
}