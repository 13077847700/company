<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Log extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Log_model');
	}

	public function index()
	{
		$where = $this->get_where();

		$this->load->library('pagination');
		$page_size = 15;  // 每页显示10条数据
		$count = $this->db->where($where)->count_all_results('log');
		//echo $this->db->last_query();
		//dump($count);
		$config['base_url'] = site_url('admin/Log/index');
		$config['total_rows'] = $count;
		$config['per_page'] = $page_size;

	    $offset = intval($this->uri->segment(4));

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();

		$data['list'] = $this->Log_model->get_logs($where, $offset, $page_size);

		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Log/index', $data);
	}

	public function get_where()
	{
		$where = ' 1 = 1 ';
		return $where;
	}
}