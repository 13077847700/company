<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 首页控制器
 */

class Home extends My_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Index/index');
	}
}
