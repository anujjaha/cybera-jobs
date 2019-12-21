<?php

class Address_model extends CI_Model {

	public function __construct()
    {
		parent::__construct();
    }

    public $table = "customer_addresses";
    
    public function get_all() {
		$this->db->select('*')
				->from($this->table)
				->order_by("name");
		$query = $this->db->get();
		return $query->result_array();
	}
	public function insert_data($data) {
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['created_by'] = $this->session->userdata['user_id'];

		$this->db->insert($this->table, $data);
		return true;
	}
	
	public function del_data($id) {
		$this->db->where('id',$id);
		$this->db->delete($this->table);
	}
	
	public function get_single($id) {
		$this->db->select('*')
			->from($this->table)
			->where('id', $id);
		$query = $this->db->get();
		return $query->row(); 
	}
	
	public function update_data($id,$data) {
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
		return true;
	}

	public function getDefaultAddress($customerId)
	{
		$this->db->select('*')
			->from($this->table)
			->where('customer_id', $customerId)
			->where('is_default', 1);
		$query = $this->db->get();
		return $query->row(); 
	}

	public function getAddressByCustomerId($customerId = null)
	{
		if($customerId)
		{
			$this->db->select('*')
				->from($this->table)
				->where('customer_id', $customerId)
				->where('is_deleted', 0);
			$query = $this->db->get();
			return $query->result_array();
		}

		return array();
	}

	public function setDefault($customerId, $addressId)
	{
		$this->db->where('customer_id', $customerId);
		$this->db->update($this->table, array('is_default' => 0));		

		$this->db->where('customer_id', $customerId)
			->where('id', $addressId);
		
		return $this->db->update($this->table, array('is_default' => 1));		
	}

	public function deleteAddress($customerId, $addressId)
	{
		$this->db->select('*')
			->from($this->table)
			->where('id', $addressId);
		$query = $this->db->get();
		$result = $query->row(); 

		$this->db->where('id', $addressId);
		$this->db->update($this->table, array('is_deleted' => 1));

		if(isset($result) && $result->is_default == 1)
		{
			$this->db->select('*')
			->from($this->table)
			->where('customer_id', $customerId)
			->where('id', '!=', $addressId);
			$query = $this->db->get();
			$result = $query->row(); 

			$this->db->where('id', $result->id);
			return $this->db->update($this->table, array('is_default' => 1));			
		}

		return true;
	}
}
