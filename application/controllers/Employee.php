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

	public function advance()
	{
		$data = array();
		$data['items'] = $this->employee_model->getAllEmployeeAdvance();
		$data['heading'] = $data['title']="Advance Salary - Cybera Print Art";
			
		$this->template->load('employee', 'advance', $data);
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

	public function add_advance()
	{
		$data['heading'] = $data['title']="Add New Advance - Cybera Print Art";
		
		if($this->input->post())
		{
			$data = $this->input->post();
			
			unset($data['save']);

			$this->employee_model->createEmployeeAdvance($data);

			redirect('employee/advance', "refresh");
		}

		$this->template->load('employee', 'add-advance', $data);
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

	public function print_emp($id = null)
	{
		$data['heading'] = $data['title']="Print Employee - Cybera Print Art";
		$data['employeeInfo']  = $this->employee_model->getEmployeeById($id);
		
		$this->template->load('employee', 'print_employee', $data);
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

	
	public function deleteEmployeeAdvance($id)
	{
		if($this->input->post())
		{
			$id = $this->input->post('id');
			$status = $this->employee_model->deleteEmployeeAdvance($id);	
			
			if($status)
			{
				echo json_encode(array('status'=>true));
				die;
			}
		}
		echo json_encode(array('status'=>false));
		die;
	}

	public function getEmployeeAdvance()
	{
		if($this->input->post())
		{
			$id = $this->input->post('empId');
			$result = $this->employee_model->getEmployeeAdvance($id);	
			
			if(isset($result) && count($result))
			{
				echo json_encode(array('status'=>true, 'data' => $result));
				die;
			}
		}
		echo json_encode(array('status'=>false));
		die;
	}
	
	public function getEmployeeSalaryDetails()
	{
		if($this->input->post())
		{
			$id = $this->input->post('empId');
			$result = $this->employee_model->getEmployeeById($id);	
			
			if(isset($result) && count($result))
			{
				echo json_encode(array('status'=>true, 'data' => $result));
				die;
			}
		}
		echo json_encode(array('status'=>false));
		die;
	}
	
	public function overview()	
	{
		$data['heading'] 	= $data['title']="Overview - Cybera Print Art";
		$data['startDate']	= date('m/d/Y', strtotime('first day of january this year'));
		$data['endDate'] 	= date('m/d/Y', strtotime('last day of december this year'));
		
		if($this->input->post())
		{
			$data['startDate'] 	= $this->input->post('start_date');
			$data['endDate'] 	= $this->input->post('end_date');
		}
		
		$this->template->load('employee', 'overview', $data);				
	}
}
