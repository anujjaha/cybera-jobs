<?php
class Menu_model extends CI_Model {

	public function __construct()
    {
                parent::__construct();
    }
    
    public $table = "menu";
    
    public function getAll() {
		$this->db->select('*, UPPER(title) as title')
				->from($this->table)
				->order_by('code');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function create($data = array())
	{
		if(count($data))
		{
			$latest = $this->db->select('sequence')->from($this->table)
				->order_by('sequence', 'desc')
				->limit(1)
				->get()
				->row();

			$data['sequence'] = $latest->sequence + 1;

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
}
