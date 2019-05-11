<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('employee_transaction_model');
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
		$data['items'] = $this->expense_model->getAllExpense();
		$data['heading'] = $data['title']="Expense - Cybera Print Art";
		$this->template->load('expense', 'index', $data);
	}
	
	public function add()
	{
		$data['heading'] = $data['title']="Add New Expense - Cybera Print Art";
		
		if($this->input->post())
		{
			$data = $this->input->post();
			unset($data['save']);
			
			$this->expense_model->createExpense($data);
			
			redirect('expense', "refresh");
		}
		
		//$data['record'] =$this->cashier_model->getLastRecord();
		
		$this->template->load('expense', 'add', $data);
	}
	
	public function edit($id = null)
	{
		$data['heading'] = $data['title']="Edit Expense - Cybera Print Art";
		$data['record']  = $this->expense_model->getExpenseById($id);

		if($this->input->post())
		{
			$data = $this->input->post();
			
			$expenseId = $this->input->post('expense_id');
			unset($data['save']);
			unset($data['expense_id']);
			$this->expense_model->updateExpense($expenseId, $data);
				
			redirect('expense', "refresh");
		}

		$this->template->load('expense', 'edit', $data);
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
