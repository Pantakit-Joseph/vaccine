<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vaccine_parent extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!isset($this->session->user_id) || $this->session->user_level != "student") {
			redirect(site_url('auth/login'));
		}
		$this->load->model('Parent_model', 'parent');
	}
	public function index()
	{
		$data = $this->parent->index($this->session->user_id);
		$this->load->view('parent', $data);
	}

	public function submit()
	{
		$data = $this->parent->submit();
        $this->session->set_flashdata('submit', $data);
		redirect(site_url('vaccine_parent'));

	}

	public function edit()
	{
		$data = $this->parent->index($this->session->user_id);
		$this->load->view('parent_edit', $data);
	}

	public function editsubmit()
	{
		$data = $this->parent->edit();
        $this->session->set_flashdata('submit', $data);
		redirect(site_url('vaccine_parent/edit'));
	}
}
