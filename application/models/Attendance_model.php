<?php
class Attendance_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "attendance";
    
    public function getAllAttendance() 
    {
		$lastMonth  = date('F', strtotime('last month'));
		$curretYear = date('Y', strtotime('last month'));
		
		$this->db->select('*, attendance.id as id')
				->from($this->table)
				->join('employees', 'employees.id = attendance.emp_id', 'left')
				->where('month', $lastMonth)
				->where('year', $curretYear);
				
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	public function createAttendance($data=array())
	{
		if(is_array($data) && count($data))
		{
			$data['created_by'] = $this->session->userdata['user_id'];
			$data['created_at'] = date('Y-m-d H:i:s');
			
			$status = $this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}
		
		return false;
	}

	
	public function updateAttendance($id, $data=array())
	{
		if(is_array($data) && count($data))
		{
			$data['created_by'] = $this->session->userdata['user_id'];
			$data['created_at'] = date('Y-m-d H:i:s');
			
			return $this->db->where('id', $id)->update($this->table, $data);
		}
		
		return false;
	}
	
	public function getAttendanceById($employeeId = null)
	{
		if($employeeId)
		{
			$this->db->select('*')
				->from($this->table)
				->where('emp_id', $employeeId);
			
			$query = $this->db->get();
			
			return $query->row(); 
		}
		
		return false;
	}

	public function getEmpAttendanceById($employeeId = null, $year = 1)
	{

		if($employeeId)
		{
			$query = $this->db->select('*, attendance.id as id')
				->from($this->table)
				/*->join('employees', 'employees.id = attendance.emp_id', 'left')*/
				->where('emp_id', $employeeId)
				->order_by('attendance.id');

			if($year == 1)
			{
				$startDate 	= '2017-10-10 00:00:00';
				$endDate 	= '2018-10-30 23:59:59';
			}

			if($year == 2)
			{
				$startDate 	= '2018-10-10 00:00:00';
				$endDate 	= '2019-10-30 23:59:59';
			}

			if($year == 3)
			{
				$startDate 	= '2019-10-10 00:00:00';
				$endDate 	= '2020-10-30 23:59:59';
			}
			
			$query->where('created_at >=', $startDate)
				->where('created_at <=', $endDate);
			
			$query = $this->db->get();
			
			return $query->result_array(); 
		}
		
		return false;
	}
	
	public function getAllAttendanceById($employeeId = null)
	{
		if($employeeId)
		{
			$this->db->select('*')
				->from($this->table)
				->where('emp_id', $employeeId);
			
			$query = $this->db->get();
			
			return $query->result_array(); 
		}
		
		return false;
	}

	public function getById($id = null)
	{
		if($id)
		{
			$this->db->select('*, attendance.id as id')
					->from($this->table)
					->join('employees', 'employees.id = attendance.emp_id', 'left')
					->where('attendance.id', $id);

			$query = $this->db->get();

			return $query->row(); 
		}
		
		return false;
	}
	
	
	
	/*public function deleteEmployee($id=null) {
		if($id) {
			$this->db->where('id',$id);
			$this->db->delete($this->table);
			return true;
		}
		return false;
	}*/
	
	/*public function updateEmployee($id=null, $data) {
		if($id)
		{
			$this->db->where('id',$id);
			$this->db->update($this->table,$data);
			return true;
		}
		return false;
	}*/
}
