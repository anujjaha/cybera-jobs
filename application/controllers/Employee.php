<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('employee_model');
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
		$data['items'] = $this->employee_model->getAllEmployees();
		$data['heading'] = $data['title']="Employees - Cybera Print Art";
		
		$this->template->load('employee', 'index', $data);
	}
	
	public function add()
	{
		$data['heading'] = $data['title']="Add New Employee - Cybera Print Art";
		
		if($this->input->post())
		{
			$data = $this->input->post();
			
			unset($data['save']);
			
			$this->employee_model->createEmployee($data);
			
			redirect('employee', "refresh");
		}
		$this->template->load('employee', 'add', $data);
	}
	
	public function edit($id = null)
	{
		$data['heading'] = $data['title']="Edit Employee - Cybera Print Art";
		$data['employeeInfo']  = $this->employee_model->getEmployeeById($id);
		
		if($this->input->post())
		{
			$data = $this->input->post();
			
			unset($data['save']);
			unset($data['employeeId']);
			$employeeId = $this->input->post('employeeId');
			$this->employee_model->updateEmployee($employeeId, $data);
				
			redirect('employee', "refresh");
		}
		$this->template->load('employee', 'edit', $data);
	}
	
	public function deleteEmployee($id)
	{
		if($this->input->post())
		{
			$id = $this->input->post('id');
			$status = $this->employee_model->deleteEmployee($id);	
			
			if($status)
			{
				echo json_encode(array('status'=>true));
				die;
			}
		}
		echo json_encode(array('status'=>false));
		die;
	}
}
