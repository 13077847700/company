<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		setcookie('auth', '', time()-100, '/company');
		unset($_SESSION['uid']);
		redirect(site_url('admin/Login/index'));
		exit(0);
	}
}