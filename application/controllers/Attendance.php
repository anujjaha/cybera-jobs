<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('attendance_model');
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
		if(isAdmin())
		{
			redirect('attendance/admin', "refresh");
		}

		$data = array();
		$data['items'] = $this->attendance_model->getAllAttendance();
		$data['heading'] = $data['title']="Attendance - Cybera Print Art";
		
		$this->template->load('attendance', 'index', $data);
	}

	public function admin()
	{
		$data = array();
		$data['items'] = $this->attendance_model->getAllAttendance();
		$data['heading'] = $data['title']="Attendance - Cybera Print Art";
	
		$this->template->load('attendance', 'admin', $data);
	}

	public function by_employee($id, $year)
	{
		$year = $year ? $year : 1;
		$data = array();
		$data['items'] = $this->attendance_model->getEmpAttendanceById($id, $year);
		$data['employeeInfo'] = $this->employee_model->getEmployeeById($id);
		$data['heading'] = $data['title']="Attendance - Cybera Print Art";

		//pr($data);

		$this->template->load('attendance', 'admin-emp-attendance', $data);
	}
	
	public function add()
	{
		$data['heading'] = $data['title']="Add New Attendance - Cybera Print Art";
		
		if($this->input->post())
		{
			$data = $this->input->post();
			
			unset($data['save']);
			
			$this->attendance_model->createAttendance($data);
			
			redirect('attendance', "refresh");
		}
		
		$this->template->load('attendance', 'add', $data);
	}
	
	public function edit($id = null)
	{
		$data['heading'] 			= $data['title']="Edit Employee - Cybera Print Art";
		$data['attaendaceInfo']  	= $this->attendance_model->getById($id);

		if($this->input->post())
		{
			$data = $this->input->post();
			
			$id   = $data['attendance_id'];

			unset($data['save']);
			unset($data['attendance_id']);

			$status = $this->attendance_model->updateAttendance($id, $data);
			
			redirect('attendance', "refresh");
		}
		$this->template->load('attendance', 'admin-edit', $data);
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
