<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model
{
	public function get_logs($where, $offset, $page_size)
	{
		$data = $this->db->where($where)->limit($page_size, $offset)->order_by('id', 'desc')->get('log')->result_array();
		//echo $this->db->last_query();
		return $data;
	}
}