<?php
class Employee_Transaction_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "employee_transactions";
    
    public function getAllEmployeeTransactions() 
    {
    	$sql = "SELECT SUM(amount_added) as creditBalance,
    			SUM(amount_removed) as debitBalance,
    			employee_transactions.*,
				employees.name, employees.mobile
				FROM employee_transactions 
				LEFT JOIN employees ON
				employees.id = employee_transactions.emp_id
				group by emp_id
				order by id desc";

		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function createEmployee($data=array())
	{
		if(is_array($data) && count($data))
		{
			$status = $this->db->insert($this->table,$data);
			return $this->db->insert_id();
		}
		
		return false;
	}
	
	public function getEmployeeById($employeeId = null)
	{
		if($employeeId)
		{
			$this->db->select('*')
				->from($this->table)
				->where('id', $employeeId);
			
			$query = $this->db->get();
			
			return $query->row(); 
		}
		
		return false;
	}
	
	public function deleteEmployee($id=null) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->delete($this->table);
			return true;
		}
		return false;
	}
	

	
	public function updateEmployee($id=null, $data) {
		if($id)
		{
			$this->db->where('id',$id);
			$this->db->update($this->table,$data);
			return true;
		}
		return false;
	}

	public function getAllEmployeeAdvance($month = null)
	{
		$currentMonth 	= $month ? $month : date('M-Y');
		$sql 			= 'SELECT advance_salary.*,
				employees.name
				FROM advance_salary 
				LEFT JOIN employees ON
				employees.id = advance_salary.emp_id
				WHERE month = "'. $currentMonth .'"
				';
		$query = $this->db->query($sql);
		return $query->result_array();
	}	

	public function deleteEmployeeAdvance($id=null) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->delete('advance_salary');
			return true;
		}
		return false;
	}

	public function getEmployeeAdvance($empId = null)
	{
		if($empId)	
		{

			$query =$this->db->select('*')
				->from('advance_salary')
				->where('emp_id', $empId);
			
			$query = $this->db->get();

			return $query->result_array();
		}	

		return false;
	}

	public function createEmployeeAdvance($data)
	{
		$employee = $this->getEmployeeById($data['emp_id']);
		$data 	  = array_merge($data, array(
			'salary' 	=> $employee->salary,
			'max_limit' => $employee->max_limit,
			'date' 		=> date('Y-m-d'),
			'month' 	=> date('M-Y')
		));

		return $this->db->insert('advance_salary', $data);
	}

	public function getEmployeeTransactionByEmpId($empId = null)
	{
		if($empId)
		{
			$sql = "SELECT employee_transactions.*
				FROM employee_transactions 
				WHERE emp_id = ". $empId ."
				order by id";

			$query = $this->db->query($sql);
			return $query->result_array();			
		}

		return false;
	}

	public function getLastTransaction($empId = null)
	{
		//die($empId);
		$this->db->select('*')
			->from($this->table)
			->where('emp_id', $empId)
			->order_by('id', 'desc')
			->limit(1);
		
		$query 	= $this->db->get();
		$result = $query->row();
			
		return isset($result) ? $result : false;
	}

	public function create($data)
	{
		$lastTransaction = $this->getLastTransaction($data['emp_id']);

		if(isset($lastTransaction))
		{
			if($data['is_salary'] == 1 || $data['is_bonus'] == 1)
			{
				$data['current_balance'] = $lastTransaction->current_balance + $data['amount_added'];
			}

			if($data['is_penalty'] == 1)
			{
				$data['current_balance'] = $lastTransaction->current_balance - $data['amount_removed'];
			}
		}
		
		$prefix = [
			'created_by' => $this->session->userdata['user_id'],
			'created_at' => date('Y-m-d H:i:s')
		];

		$input = array_merge($data, $prefix);

		$status = $this->db->insert($this->table, $input);

		if($status && $data['is_salary'] == 1)
		{
			$lastTransactionId = $this->db->insert_id();
			$salaryRedeemData = [
				'emp_id' 				=> $data['emp_id'],
				'salary_transaction_id' => $lastTransactionId,
				'amount_removed'		=> $data['amount_added'],
				'employee_redeem'		=> $data['amount_added'],
				'current_balance'		=> isset($lastTransaction) ? $lastTransaction->current_balance : 0,
				'is_salary_redeem'		=> 1,
				'description'			=> 'Salary Redeemed by Employee at ' . date('Y-m-d H:i:s'),
				'created_by' 			=> $this->session->userdata['user_id'],
				'created_at' 			=> date('Y-m-d H:i:s')
			];

			$this->db->insert($this->table, $salaryRedeemData);
		}

		return true;
	}
}
