<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('cashier_model');
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
		//echo addDueEmailToday();
		$data = array();
		$data['items'] = $this->cashier_model->getAllCashier();
		$data['heading'] = $data['title']="Cashier - Cybera Print Art";
		$this->template->load('cashier', 'index', $data);
	}
	
	public function add()
	{
		$data['heading'] = $data['title']="Add New Cashier - Cybera Print Art";
		date_default_timezone_set('Asia/Kolkata');
		if($this->input->post())
		{
			$data = $this->input->post();
			$data['today_business'] = $data['total'] - $data['open_balance'];
			unset($data['save']);
			$todayBusiness 		= getBusinessByDate();	
			$totalSale 			= getSaleByDate();	
			$totalXeros 		= $data['xerox_business'];
			$todayCollection 	= getBusinessCollectionByDate();
			$todayCash 			= getBusinessCashCollectionByDate();
			$totalBusiness 		= $totalSale + $totalXeros;
			$lastRecord 		= getLastCashier();	
			$m1x				= $data['m1x'] - $lastRecord->m1x;
			$m2x				= $data['m2x'] - $lastRecord->m2x;
			$totalCopies		= $m1x + $m2x;

			$msgText = "RA - ".$data['open_balance']." PO - ". $data['expense'] ." Copies - ". $totalCopies ." Xerox - ".$data['xerox_business']." Wd - ". $data['withdrawal'] ." Closing ".$data['close_balance']." Business ".$totalBusiness." Cash ". $todayCash ." Collection ".$todayCollection." Time ". date('m-d-Y H:i A') .".";
			send_account_sms('9898618697', $msgText);
			$this->cashier_model->createCashier($data);
			
			redirect('cashier', "refresh");
		}
		
		$data['record'] =$this->cashier_model->getLastRecord();
		
		$this->template->load('cashier', 'add', $data);
	}

	public function quickmsg()
	{
		die("stop");
		/*$today 				= "13-12-2019";
		$todayBusiness 		= getBusinessByDate($today);	
		$totalSale 			= getSaleByDate($today);	
		$totalXeros 		= 1605;
		$todayCollection 	= getBusinessCollectionByDate($today);
		$todayCash 			= getBusinessCashCollectionByDate($today);
		$totalBusiness 		= $totalSale + $totalXeros;
		
		$msgText = "RA - ".$data['open_balance']." PO - ". $data['expense'] ." Xerox - ".$data['xerox_business']." Wd - ". $data['withdrawal'] ." Closing ".$data['close_balance']." Business ".$totalBusiness." Cash ". $todayCash ." Collection ".$todayCollection." Time ". date('m-d-Y H:i A') .".";
		send_account_sms('9898618697', $msgText);
		send_account_sms('8000060541', $msgText);*/
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
