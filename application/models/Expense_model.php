<?php
class Expense_model extends CI_Model
{
	public function __construct()
    {
		parent::__construct();
    }
    
    public $table = "data_expense_manager";
    
    public function getAllExpense() 
    {
		$this->db->select('*')
				->from($this->table)
				->order_by('id', 'desc');
				
		$query = $this->db->get();
		
		return $query->result_array();

	}
	
	public function getLastRecord() 
    {
		$this->db->select('*')
				->from($this->table)
				->order_by('id', 'DESC')
				->limit(1);
				
		return $this->db->get()->row();
	}

	public function getExpenseById($id) 
    {
		$this->db->select('*')
				->from($this->table)
				->where('id', $id);
		
		return $this->db->get()->row();
	}
	
	public function createExpense($data=array())
	{
		if(is_array($data) && count($data))
		{
			$data['created_month'] 		= date('m-Y');
			$data['created_by'] = $this->session->userdata['user_id'];
			$data['created_at'] = date('Y-m-d H:i:s');
			
			$status = $this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}
		
		return false;
	}

	public function updateExpense($id, $data=array())
	{
		if(is_array($data) && count($data))
		{
			$data['created_month'] 	= date('m-Y');
			$data['created_by'] 	= $this->session->userdata['user_id'];
			$data['created_at'] 	= date('Y-m-d H:i:s');
			
			$this->db->where('id',$id);
			return $this->db->update($this->table, $data);
		}
		
		return false;
	}
}
