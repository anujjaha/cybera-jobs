<?php
class Customer_model extends CI_Model {
	public function __construct()
    {
                parent::__construct();
                date_default_timezone_set('Asia/Kolkata');
    }

    public $table 				= "customer";
    public $tableLocation 		= "customer_addresses";
    public $table_prospects 	= "prospects";
    public $table_categories 	= "ccategories";
	public $table_transporters 	= "transporter_details";
	
	public function checkCustomerByEmailId($emailId = null)
	{
		if($emailId)
		{
			$sql = "SELECT id from customer where emailid = '". $emailId ."'";
			
			$query = $this->db->query($sql);
			
			if($query->row())
			{
				return $query->row();
			}
		}
			
		return false;
	}
	
	public function get_quick_customer_details()
	{
		$sql = "SELECT * FROM $this->table 
				order by companyname";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getCustomerLocations($customerId = null)
	{
		if($customerId)
		{
			$sql = "SELECT *
					FROM customer_addresses
					WHERE customer_id = ". $customerId ."
					order by id";
			$query = $this->db->query($sql);
			return $query->result();
		}

		return false;
	}
	
	public function get_customer_details($param=null,$value=null) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit'
				FROM $this->table 
				where ctype = 0
				order by companyname";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_block_customer_details($param=null,$value=null) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit'
				FROM $this->table 
				where ctype = 0
				AND 
				is_block = 1
				OR
				under_revision = 1
				order by companyname";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_customer_details_quick($like=null,$offset=0,$limit=10,$sort_by="companyname",$sort_value="ASC") {
		if($like) {
			$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit'
				FROM $this->table 
				WHERE customer.companyname like '%$like%'
				OR  customer.name like '%$like%'
				OR customer.mobile like '%$like%'
				OR customer.emailid like '%$like%'
				AND
				ctype = 0
				ORDER BY customer.$sort_by  $sort_value 
				LIMIT $offset,$limit
				";	
		} else {
		$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit'
				FROM $this->table 
				where ctype = 0
				ORDER BY customer.$sort_by $sort_value  
				LIMIT $offset,$limit";
		}
		
		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_customer_details_quick_balance($like=null,$offset=0,$limit=10,$sort_by="companyname",$sort_value="ASC") {
		if($like) {
			$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit',
				(SELECT COALESCE(total_credit - total_debit) ) as balance
				FROM $this->table 
				WHERE customer.companyname like '%$like%'
				OR  customer.name like '%$like%'
				OR customer.mobile like '%$like%'
				OR customer.emailid like '%$like%'
				and ctype = 0
				ORDER BY $sort_by  $sort_value 
				LIMIT $offset,$limit
				";	
		} else {
		$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit',
				(SELECT COALESCE(total_credit - total_debit) ) as balance
				FROM $this->table 
				where ctype = 0
				ORDER BY $sort_by $sort_value  
				LIMIT $offset,$limit";
		}
		
		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_customer_details_ajax($like=null,$offset=0,$limit=10) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		
		if($like) {
		$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit'
				FROM $this->table
				WHERE
				customer.companyname LIKE '%$like%'
				OR 
				customer.name LIKE '%$like%'
				OR 
				customer.mobile LIKE '%$like%'
				OR 
				customer.emailid LIKE '%$like%'
				order by companyname
				LIMIT $offset,$limit";
		} else  {
			$sql = "SELECT *, 
				(SELECT SUM(amount) from user_transactions ut WHERE ut.customer_id = $this->table.id and t_type ='debit')  as 'total_debit' ,
				(select sum(amount) from user_transactions ut where ut.customer_id=customer.id  and t_type ='credit') as 'total_credit'
				FROM $this->table 
				order by companyname
				LIMIT $offset,$limit";
			
		}
		
	//	echo $sql;
		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
	
	public function insert_customer($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$status = $this->db->insert($this->table,$data);
		$customer_id = $this->db->insert_id();
		$update_data['username'] = 'customer'.$customer_id;
		$update_data['password'] = 'customer'.$customer_id;
		$status = $this->update_customer($customer_id,$update_data);

		$locationData = array(
			'customer_id'	=> $customer_id,
			'location_name'	=> $data['name'] ? $data['name'] : $data['companyname'],
			'mobile'		=> $data['mobile'] ? $data['mobile'] : '',
			'email'			=> $data['email'] ? $data['email'] : '',
			'add1'			=> $data['add1'] ? $data['add1'] : '',
			'add2'			=> $data['add2'] ? $data['add2'] : '',
			'city'			=> $data['city'] ? $data['city'] : '',
			'state'			=> $data['state'] ? $data['state'] : '',
			'pin'			=> $data['pin'] ? $data['pin'] : '',
			'is_default'	=> 1,
			'created_by'	=> $this->session->userdata['user_id'],
			'created_at'	=> date('Y-m-d H:i:s')
		);
		$locationStatus = $this->db->insert($this->tableLocation, $locationData);


		if($status) { return $customer_id;}
		return false;
	}
	
	public function update_customer($customer_id=null,$data) {
		if($customer_id) {
		$data['modified'] = date('Y-m-d H:i:s');
		$this->db->where('id = '.$customer_id);
		 $this->db->update($this->table,$data);
		 return true;
		}
		return false;
	}
	
	public function get_prospects_details($param=null,$value=null) {
		if(!empty($param)) {
			$sql = "SELECT * FROM $this->table_prospects WHERE $param = $value";
			$query = $this->db->query($sql);
			return $query->row();
		}
		$sql = "SELECT *
				FROM $this->table_prospects
				order by name";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function insert_prospect($data) {
		$data['created'] = date('Y-m-d H:i:s');
		$status = $this->db->insert($this->table_prospects,$data);
		$customer_id = $this->db->insert_id();
		$update_data['username'] = 'customer'.$customer_id;
		$update_data['password'] = 'customer'.$customer_id;
		$status = $this->update_customer($customer_id,$update_data);
		if($status) { return $customer_id;}
		return false;
	}
	
	public function update_prospect($customer_id=null,$data) {
		if($customer_id) {
		$data['modified'] = date('Y-m-d H:i:s');
		$this->db->where('id = '.$customer_id);
		 $this->db->update($this->table_prospects,$data);
		 return true;
		}
		return false;
	}
	
	public function get_customer_categories() {
		$sql = "SELECT *
				FROM data_categories
				order by name";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function delete_customer($id=null) {
		if($id) {
			$sql = "INSERT INTO customer_deleted SELECT * FROM $this->table WHERE id = $id";
			$query = $this->db->query($sql);
			$this->db->where('id',$id);
			return $this->db->delete($this->table);
		}
		return false;
	}
	
	public function getTransporterDetailsByCustomerId($customerId = null)
	{
		if($customerId)
		{
			$sql = "SELECT *
					FROM $this->table_transporters
					where customer_id = $customerId";
					
			$query = $this->db->query($sql);
			return $query->row() ? $query->row() : false;
		}
		
		return false;
	}
	
	public function addTransporterDetails($data)
	{
		$status = $this->db->insert($this->table_transporters, $data);
		if($status)
		{
			return $this->db->insert_id();
		}
		
		return false;
	}
	
	public function updateTransporterDetails($id, $data)
	{
		$this->db->where('id', $id);
		
		return $this->db->update($this->table_transporters, $data);
	}
	
	public function checkOrUpdateCustomerEmailId($customerId = null, $emailId = null)
	{
		if($customerId)
		{
			$data['emailid'] = $emailId;
			
			$this->db->where('id', $customerId);
			return $this->db->update($this->table, $data);
		}
	}

	/**
 	 * Add Special Rates
	 */
	public function addSpecialRates($inputData = array())
	{
		return $this->db->insert('data_special_rates', $inputData);		
	}

	public function getAllSpecialRates($inputData = array())
	{
		$sql = "SELECT *, data_special_rates.id as rate_id,
			data_special_rates.description as rate_description
			FROM data_special_rates
			LEFT join customer on customer.id = data_special_rates.customer_id
			order by data_special_rates.id";
		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function deleteSpecialRate($id)
	{
		$sql = "DELETE from data_special_rates WHERE id = " . $id;
		return  $this->db->query($sql);
	}

	public function getSpecialRate($id)
	{
		$sql = "SELECT *
			FROM data_special_rates
			WHERE id = ".$id."";
		
		$query = $this->db->query($sql);
		return $query->row();
	}

	public function updateSpecialRates($id, $data)
	{
		$this->db->where('id = '.$id);
		$this->db->update('data_special_rates', $data);
		
		return true;
	}

	public function manageTransporterData($customerId = null, $data = array())
	{
		$sql = "SELECT * FROM transporter_details WHERE customer_id = ".$customerId;
		$ci=& get_instance();
		$ci->load->database(); 	
		$query = $ci->db->query($sql);
		$transporterData = $query->result_array();

		foreach($data as $key => $transporterName)
		{
			if(isset($transporterData[$key]))
			{	
				$id 	=  $transporterData[$key]['id'];
				$upData = [
					'name' => $transporterName
				];

				$this->db->where('id = '.$id);
				$this->db->update('transporter_details', $upData);
			}
			else
			{
				$tdata = [
					'customer_id' 	=> $customerId,
					'name'			=> $transporterName
				];
				
				$status = $this->db->insert('transporter_details', $tdata);
			}
		}

		return true;
	}

}
