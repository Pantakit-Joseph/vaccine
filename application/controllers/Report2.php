<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report2 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model2', 'report');
    }
    public function index()
    {
        redirect(site_url('report2/majors'));
        // $data = $this->report->majors();
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';

    }
    public function majors()
    {
        $data = $this->report->majors();
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        $this->load->view('report2/majors', $data);
    }
    public function groups()
    {
        $data = $this->report->groups($this->input->get('i'));
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        $this->load->view('report2/groups', $data);
    }
    public function std()
    {
		date_default_timezone_set('Asia/Bangkok');
		$this->load->library('tothai');
        $data = $this->report->std($this->input->get('i'));
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        $this->load->view('report2/std', $data);
    }
}
