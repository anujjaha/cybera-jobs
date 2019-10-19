<?php

class Estimate_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
	}
    public $table = "estimate_job";
    public $table_transaction = "user_transactions";
    public $table_details = "estimate_job_details";
    public $table_customer = "customer";
    public $table_cutting_details = "estimate_cutting_details";
   
   // public $table_job_transaction = "job_transaction";
   // public $table_job_verify = "job_verify";
   // public $table_discount = "job_discount";
	
	public function insert_job($data) {
		$data['created'] = date('Y-m-d H:i:s');
		if(isset($data['tax']) && $data['tax'] == '')
		{
			$data['tax'] = 0;
		}

		$this->db->insert($this->table,$data);
		$job_id = $this->db->insert_id();
		/*$transaction_data['job_id']=$job_id;
		$transaction_data['customer_id']=$data['customer_id'];
		$transaction_data['cmonth']=$data['jmonth'];
		$transaction_data['amount']=$data['total'];
		$transaction_id = $this->insert_transaction($transaction_data);*/
		
		/*if($data['advance'] > 0 ) {
			$transaction_data['job_id']=$job_id;
			$transaction_data['customer_id']=$data['customer_id'];
			$transaction_data['cmonth']=$data['jmonth'];
			$transaction_data['amount']=$data['advance'];
			$transaction_data['t_type']=CREDIT;
			$transaction_data['notes']= 'Pay as Advance Amount';
			$transaction_id = $this->insert_transaction($transaction_data);
		}*/
		
			/*$dis_transaction_data['job_id'] =  $job_id;
			$dis_transaction_data['customer_id'] =  $data['customer_id'];
			$dis_transaction_data['amount'] =  0;
			$dis_transaction_data['notes'] =  "Apply Discount";
			$dis_transaction_data['creditedby'] =  $this->session->userdata['user_id'];
			$dis_transaction_data['t_type'] =  CREDIT;
			$dis_transaction_data['cmonth']=$data['jmonth'];
			$discount_transaction_id = $this->insert_transaction($dis_transaction_data);
			
			$discount_data['job_id'] = $job_id;
			$discount_data['user_transaction_id'] = $discount_transaction_id;
			$discount_data['amount'] = 0;
			$discount_data['createdby'] = $this->session->userdata['user_id'];
			$discount_id = $this->insert_discount($discount_data);*/
		return $job_id;
	}
	
	public function insert_discount($data=array()) {
		$data['created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table_discount,$data);
		return $this->db->insert_id();
	}
	
	public function update_job($job_id=null,$data=array()) {
		if($job_id) {
			$data['modified'] = date('Y-m-d H:i:s');
			$this->db->where('id',$job_id);
			return $this->db->update($this->table,$data);
		}
		return false;
	}
	
	public function update_job_details($jobdetails_id=null,$data=array()) {
		if($jobdetails_id) {
			$data['modified'] = date('Y-m-d H:i:s');
			$this->db->where('id',$jobdetails_id);
			return $this->db->update($this->table_details,$data);
		}
		return false;
	}
	
	public function insert_jobdetails($data,$flag=null) {
		if($flag) {
			return $this->db->insert($this->table_details,$data);
		}
		$status = $this->db->insert_batch($this->table_details,$data);
		return true;
	}
	
	public function get_job_data($job_id=null) {
		if($job_id) {
			$this->db->select('*,estimate_job.created as "created", estimate_job.id as id , employees.name as emp_name,(select j_status from job_transaction where job_transaction.j_id=estimate_job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus')
					->from($this->table)
					->join('employees', 'employees.id = estimate_job.emp_id', 'left')
					->where('estimate_job.id ='.$job_id);
			$query = $this->db->get();
			return $query->row();
		}
		$sql = "SELECT *,estimate_job.id as estimate_job,estimate_job.created as created FROM ". $this->table ."
				 LEFT JOIN customer
				 ON estimate_job.customer_id = customer.id
				 order by estimate_job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getJobById($jobId = null)
	{
		if($jobId)
		 {
			$this->db->select('*, estimate_job.id as id, estimate_job.created as "created",customer.*')
					->from($this->table)
					->join('customer','estimate_job.customer_id=customer.id','left')
					->where('estimate_job.id ='.$jobId);
			$query = $this->db->get();
			return $query->row();
		}
		return false;
	}
	
	public function get_job_details($job_id) {
		$this->db->select('*')
				->from($this->table_details)
				->where('job_id ='.$job_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	public function get_cutting_details($job_id) {
		$this->db->select('*')
				->from($this->table_cutting_details)
				->where('j_id ='.$job_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_customer_details($customer_id) {
		$this->db->select('*')
				->from($this->table_customer)
				->where('id ='.$customer_id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function get_today_details($param=null,$value=null) 
	{
		$condition = "";
		if(!empty($param)) {
			$condition = "WHERE $param = $value";
			
		}

		$department = $this->session->userdata['department'];
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id AND department = '$department') 
				as j_view,
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM " . $this->table . "
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 $condition
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function get_dashboard_details() {
		$today = date('Y-m-d');
		$department = $this->session->userdata['department'];
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				customer.under_revision as revision,
				(select name from employees where employees.id = job.emp_id )  as emp_name,
				customer.customer_star_rate as rating,
				(select count(id) from job_views where job_views.j_id =job.id AND department = '$department') 
				as j_view,
				
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id

				 
				 WHERE 
				 job.status != 0 OR job.is_hold = 1 
				 OR job.cyb_delivery = 0
		
				 OR job.jdate = '".$today."' OR is_delivered = 0 or is_pin = 1
				 order by job.id DESC
				";
		//pr($sql);
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	
    public function insert_cuttingdetails($data,$flag=null) {
        if($flag) {
            return $this->db->insert($this->table_cutting_details,$data);
        }
        $status = $this->db->insert_batch($this->table_cutting_details,$data);
        return true;
    }
    
    
	
	
	public function get_job_details_by_param($param=null,$value=null) {
		if($param && $value) {
			$this->db->select('*')
				->from($this->table_details)
				->where($param,$value);
			$query = $this->db->get();
			return $query->row();
		}
		return false;
		
	}
	public function get_cutting_details_by_job_detail($job_id=null,$value=null) {
		if($job_id && $value) {
			$this->db->select('*')
				->from($this->table_cutting_details)
				->where('c_material',$value)
				->where('j_id',$job_id);
			$query = $this->db->get();
			return $query->row();
		}
		return false;
	}
	
	public function update_cutting_details($id,$data=array()) {
		$this->db->where('id',$id);
		$this->db->update($this->table_cutting_details,$data);
		return true;
	}
	
	public function is_cutting($job_id=null) {
		if($job_id) {
			$this->db->select('*')
			->from($this->table_cutting_details)
			->where('j_id',$job_id);
			$query = $this->db->get();
			if($query->result()) {
				return true;
			}
		}
		return false;
	}
	
	
	public function get_all_customers() {
		$this->db->select('id,name,companyname,mobile')
				->from($this->table_customer)
				->where('status',1)
				->order_by('companyname');
		$query = $this->db->get();
		return $query->result_array();
	}
}