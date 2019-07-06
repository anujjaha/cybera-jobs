<?php
class Insurance_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "data_insurances";
    
    public function getAll() 
    {
    	$sql = 'SELECT data_insurances.*, employees.name as employee_name from data_insurances
    			LEFT JOIN employees ON employees.id = data_insurances.employee_id
    			order by id desc';
    	$query = $this->db->query($sql);
    	return $query->result_array();
		
		/*$this->db->select('*')
				->from($this->table)
				->
				->order_by('id', 'desc');
				
		$query = $this->db->get();
		
		return $query->result_array();*/

	}
	
	public function getLastRecord() 
    {
		$this->db->select('*')
				->from($this->table)
				->order_by('id', 'DESC')
				->limit(1);
				
		return $this->db->get()->row();
	}

	public function getById($id) 
    {
		$this->db->select('*')
				->from($this->table)
				->where('id', $id);
		
		return $this->db->get()->row();
	}
	
	public function create($data=array())
	{
		if(is_array($data) && count($data))
		{
			$data['user_id'] = $this->session->userdata['user_id'];
			$data['employee_id'] = isset($data['emp_id']) && $data['emp_id'] != '0' ? $data['emp_id'] : null;
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['renewal_date'] = date('Y-m-d', strtotime($data['renewal_date']));
			
			unset($data['emp_id'])	;

			//pr($data);
			$status = $this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}
		
		return false;
	}

	public function update($id, $data=array())
	{
		if(is_array($data) && count($data))
		{
			$data['user_id'] 	= $this->session->userdata['user_id'];
			$data['created_at'] 	= date('Y-m-d H:i:s');
			
			$this->db->where('id',$id);
			return $this->db->update($this->table, $data);
		}
		
		return false;
	}
}
