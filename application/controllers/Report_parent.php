<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_parent extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Parent_report_model','parent');
		$this->load->helper('parent');
	}

	public function index()
    {
        redirect(site_url('report_parent/majors'));
    }
	public function majors()
	{
		$menu = $this->parent->menu();
		$data['menu'] = $this->load->view('report_parent/menu', $menu, true);
		$data['majors'] = $this->parent->majors();
		$this->load->view('report_parent/majors', $data);
	}	
	public function major()
    {
		if (empty($this->input->get('major_id'))) {
			redirect(site_url('report_parent/majors'));
		}
        $menu = $this->parent->menu();
		$data['menu'] = $this->load->view('report_parent/menu', $menu, true);
        $data['major'] = $this->parent->major($this->input->get('major_id'));
		// echo '<pre>';
		// var_dump($data['major']);
		// echo '</pre>';
        $this->load->view('report_parent/major', $data);
    }

	public function minor()
    {
		if (empty($this->input->get('minor_id'))) {
			redirect(site_url('report_parent/majors'));
		}
        $menu = $this->parent->menu();
		$data['menu'] = $this->load->view('report_parent/menu', $menu, true);
        $data['minor'] = $this->parent->minor($this->input->get('minor_id'));
		// echo '<pre>';
		// var_dump($data['minor']);
		// echo '</pre>';
        $this->load->view('report_parent/minor', $data);
    }

	public function group()
    {
		if (empty($this->input->get('group_id'))) {
			redirect(site_url('report_parent/majors'));
		}
		$menu = $this->parent->menu();
		$data['menu'] = $this->load->view('report_parent/menu', $menu, true);
        $data['group'] = $this->parent->group($this->input->get('group_id'));
		// echo '<pre>';
		// var_dump($data['group']);
		// echo '</pre>';
        $this->load->view('report_parent/group', $data);
    }

	// public function engine()
	// {
	// 	$this->load->view('report_engine');
	// }	
	
	// public function get_items() 
	// {
	// 	$data = $this->parent->get_items();
	// 	echo "<hr><hr>";
	// 	echo "<pre>";
	// 	var_dump($data);
	// 	echo "</pre>";

	// }
}
