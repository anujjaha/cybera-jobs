<?php
class Diwali_model extends CI_Model {

	public function __construct()
    {
        parent::__construct();
    }
    
    public $table = "d_customers";
    
    public function getAll()
    {
		$this->db->select('*')
				->from($this->table)
				->where('d_status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function create($data = array())
	{
		if(count($data))
		{
			$data['created_at'] = date('Y-m-d H:i:s');

			return $this->db->insert($this->table, $data);
		}
	}	

	public function softDeleteMenu($id)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, [
			'status' => 0
		]);
	}

	public function updateMenu($data)
	{
		$menuId = $data['menu_id'];
		unset($data['menu_id']);
		
		$this->db->where('id', $menuId);

		return $this->db->update($this->table, $data);
	}

	public function bulkInsert($data)
	{
		return $this->db->insert_batch($this->table, $data);
	}

	public function migrateDCustomers()
	{
		die;
		$customers = $this->db->select("*")
			->from('customer')
			->get()
			->result_array();

		$ins = [];
		foreach($customers as $customer)
		{
			$ins[] = [
				'customer_id' 	=> $customer['id'],
				'name' 			=> $customer['name'],
				'companyname' 	=> $customer['companyname'],
				'mobile' 		=> $customer['mobile'],
				'othermobile' 	=> $customer['officecontact'],
				'email' 		=> $customer['emailid'],
				'add1' 			=> $customer['add1'],
				'add2' 			=> $customer['add2'],
				'city' 			=> $customer['city'],
				'state' 		=> $customer['state'],
				'pin' 			=> $customer['pin'],
				'ctype' 		=> $customer['ctype'],
				'description' 	=> $customer['description'],
				'status' 		=> $customer['status'],
				'created_at' 	=> date('Y-m-d H:i:s')
			];
		}

		return $this->db->insert_batch('d_customers', $ins);
	}

	public function soft_delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, [
			'd_status' => 0
		]);
	}

	public function update_gtype($id, $gtype)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, [
			'gtype' => $gtype
		]);
	}

	public function copy_to_diwali($cid)
	{	
		$isExist = $this->db->select('id')
			->from($this->table)
			->where('customer_id', $cid)
			->get()
			->row();
		if(isset($isExist) && !empty($isExist->id))
		{
			return false;
		}

		$customer = $this->db->select("*")
			->from('customer')
			->where('id', $cid)
			->get()
			->row();

		$customer = (array)$customer;
		
		return $this->db->insert('d_customers', [
			'customer_id' 	=> $customer['id'],
			'name' 			=> $customer['name'],
			'companyname' 	=> $customer['companyname'],
			'mobile' 		=> $customer['mobile'],
			'othermobile' 	=> $customer['officecontact'],
			'email' 		=> $customer['emailid'],
			'add1' 			=> $customer['add1'],
			'add2' 			=> $customer['add2'],
			'city' 			=> $customer['city'],
			'state' 		=> $customer['state'],
			'pin' 			=> $customer['pin'],
			'ctype' 		=> $customer['ctype'],
			'description' 	=> $customer['description'],
			'status' 		=> $customer['status'],
			'created_at' 	=> date('Y-m-d H:i:s')
		]);
	}
}
