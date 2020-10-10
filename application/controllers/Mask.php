<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mask extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model('job_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data = array();
		$data['masks'] = $this->job_model->getMaskList();
		$data['heading'] = $data['title'] = "Mask List- Cybera Print Art";
		$data['allMasks'] = $this->job_model->getMaskInList($maskTitle);

		$this->template->load('mask', 'index', $data);
	}

	public function in($maskTitle = null)
	{
		$this->load->model('job_model');
		$maskTitle = str_replace("_2_", " ", urldecode($maskTitle));
		$maskTitle = str_replace("_4_", "(", urldecode($maskTitle));
		$maskTitle = str_replace("_5_", ")", urldecode($maskTitle));
		$data = array();
		$data['masks'] = $this->job_model->getMaskInList($maskTitle);
		$data['scheduleIds'] = [];
		$data['title']="Mask - IN Stock - Cybera Print Art";
		$data['heading']="Mask IN Stock";
		$data['maskTitle']= $maskTitle;
		$this->template->load('mask', 'in-list', $data);
	}

	public function out()
	{
		$data = array();
		$data['masks'] = $this->job_model->getMaskList();
		$data['heading'] = $data['title'] = "Mask List- Cybera Print Art";

		$this->template->load('mask', 'index', $data);
	}
	
	public function add()
	{
		$data['heading'] = $data['title']="Add New Mask - Cybera Print Art";
		
		if($this->input->post())
		{
			$data = $this->input->post();
			unset($data['save']);
			
			$this->job_model->addUpdateMask($data);
			
			redirect('mask', "refresh");
		}
		
		//$data['record'] =$this->cashier_model->getLastRecord();
		
		$this->template->load('mask', 'add', $data);
	}
}


