<?php
class Employee_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "employees";
    
    public function getAllEmployees() {
		$this->db->select('*')
				->from($this->table);
		$query = $this->db->get();
		
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

			if(isset($data['resignation_date']) && $data['resignation_date'] != '')
			{
				$data['resignation_date'] = date('Y-m-d', strtotime($data['resignation_date']));
			}
			
			if(isset($data['last_date']) && $data['last_date'] != '')
			{
				$data['last_date'] = date('Y-m-d', strtotime($data['last_date']));
			}

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
}
