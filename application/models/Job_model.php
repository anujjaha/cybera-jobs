<?php
class Job_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
	}
    public $table = "job";
    public $table_transaction = "user_transactions";
    public $table_details = "job_details";
    public $table_customer = "customer";
    public $table_cutting_details = "cutting_details";
    public $table_job_transaction = "job_transaction";
    public $table_job_verify = "job_verify";
    public $table_discount = "job_discount";
	
	public function insert_job($data) {
		$data['created'] = date('Y-m-d H:i:s');
		if(isset($data['tax']) && $data['tax'] == '')
		{
			$data['tax'] = 0;
		}

		$this->db->insert($this->table,$data);
		$job_id = $this->db->insert_id();

		$transaction_data['job_id']=$job_id;
		$transaction_data['customer_id']=$data['customer_id'];
		$transaction_data['cmonth']=$data['jmonth'];
		$transaction_data['amount']=$data['total'];

		$transaction_id = $this->insert_transaction($transaction_data);
		
		if($data['advance'] > 0 ) {
			$transaction_data['job_id']=$job_id;
			$transaction_data['customer_id']=$data['customer_id'];
			$transaction_data['cmonth']=$data['jmonth'];
			$transaction_data['amount']=$data['advance'];
			$transaction_data['t_type']=CREDIT;
			$transaction_data['notes']= 'Pay as Advance Amount';
			$transaction_id = $this->insert_transaction($transaction_data);
		}
		
			$dis_transaction_data['job_id'] =  $job_id;
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
			$discount_id = $this->insert_discount($discount_data);
		return $job_id;
	}
	
	public function insert_discount($data=array()) {
		$data['created'] = date('Y-m-d H:i:s');
		$this->db->insert($this->table_discount,$data);
		return $this->db->insert_id();
	}
	public function insert_transaction($data=array()) {
		$data['created'] = date('Y-m-d H:i:s');
		if(isset($data['amountby']) && $data['amountby'] == '')
		{
			$data['amountby'] = 0;
		}
		
		$this->db->insert($this->table_transaction,$data);
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
			$this->db->select('*,job.created as "created", job.id as id , employees.name as emp_name,(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus')
					->from($this->table)
					->join('employees', 'employees.id = job.emp_id', 'left')
					->where('job.id ='.$job_id);
			$query = $this->db->get();
			return $query->row();
		}
		$sql = "SELECT *,job.id as job_id,job.created as created FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getJobById($jobId = null)
	{
		if($jobId)
		 {
			$this->db->select('*, job.id as id, job.created as "created",customer.*')
					->from($this->table)
					->join('customer','job.customer_id=customer.id','left')
					->where('job.id ='.$jobId);
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
				FROM job
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
				customer.fix_note,
				customer.under_revision as revision,
				(select name from employees where employees.id = job.emp_id )  as emp_name,
				customer.customer_star_rate as rating,
				(select count(id) from job_views where job_views.j_id =job.id AND department = '$department') 
				as j_view,
				
				(select  group_concat(bill_number separator ',') as 'ref_bill_number'
				from user_transactions where user_transactions.job_id = job.id) as 't_bill_number',
				
				(select  group_concat(receipt separator ',') as 'ref_receipt'
				from user_transactions where user_transactions.job_id = job.id) as 't_reciept',

				(select other from user_transactions where user_transactions.job_id = job.id order by id desc LIMIT 1) as 'other_payment',
				
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

	public function get_dashboard_pending_details1()
	{
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

				(select other from user_transactions where user_transactions.job_id = job.id order by id desc LIMIT 1) as 'other_payment',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id

				 
				 WHERE 
				 jstatus = 'Pending'
				 and
				 job.status != 0 OR job.is_hold = 1 
				 OR job.cyb_delivery = 0
		
				 OR is_delivered = 0 or is_pin = 1
				 order by job.id DESC
				";
		//pr($sql);
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	
	public function get_dashboard_pending_details() {
		//$today = date('Y-m-d');
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

				(select other from user_transactions where user_transactions.job_id = job.id order by id desc LIMIT 1) as 'other_payment',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id

				 
				 WHERE 
				 job.status != 0 OR job.is_hold = 1 
				 OR job.cyb_delivery = 0
		
				  OR is_delivered = 0 or is_pin = 1
				 order by job.id DESC
				";
		//pr($sql);
		$query = $this->db->query($sql);
		$result = $query->result_array();	
		$jobData = array();

		foreach($result as $jR)
		{
			if($jR['jstatus'] == "Pending")
			{
				$jobData[] = $jR;
			}
		}

		return $jobData;
	}

	public function get_dashboard_undeliver_details() {
		//$today = date('Y-m-d');
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

				(select other from user_transactions where user_transactions.job_id = job.id order by id desc LIMIT 1) as 'other_payment',
				
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id

				 
				 WHERE 
				 is_delivered = 0
				 order by job.id DESC
				";
		//pr($sql);
		$query = $this->db->query($sql);
		$result = $query->result_array();	
		$jobData = array();

		foreach($result as $jR)
		{
			if(1==1)//$jR['jstatus'] == "Un-delivered")
			{
				$jobData[] = $jR;
			}
		}

		return $jobData;
	}

	public function getPendingJobIds()
	{
		$sql = 'SELECT j_id FROM `job_transaction`  where
				j_status = "Pending"
				order by id desc LIMIT 0, 1';
		$query = $this->db->query($sql);
		$jobIds = array();	
		$result = $query->result_array();	


		foreach($result as $jR)
		{
			$jobIds[] = $jR['j_id'];
		}
		return $jobIds;
	}
	
	
	public function get_today_cutting_details($param=null,$value=null) {
		$department = $this->session->userdata['department'];
		$today = date('Y-m-d');
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id AND department = '$department') 
				as j_view,
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 LEFT JOIN cutting_details
				 ON job.id = cutting_details.j_id
				 WHERE job.id IN (select j_id from cutting_details where c_status =0)
				 and job.jdate = '".$today."'
				 group by job.id
				 order by job.id DESC
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_all_cutting_details($param=null,$value=null) {
		if(empty($param)) {
			$param = 'job.jdate';	
			$value = date('Y-m-d');
		}
		$sql = "SELECT *,job.id as job_id,job.created as 'created',
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 LEFT JOIN cutting_details
				 ON job.id = cutting_details.j_id
				 WHERE job.id IN (select j_id from cutting_details)
				 group by job.id
				 order by job.id DESC
				 
				";
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
    
    public function get_paper_gsm() {
		$sql = "SELECT paper_gram, paper_name from paper_details group by paper_gram";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
    public function get_paper_size() {
		$sql = "SELECT paper_size from paper_details group by paper_size";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function add_job_transaction($data=array()) {
		if($data) {
			$data['user_id']= $this->session->userdata['user_id'];
			$data['j_time']= date('H:i A');
			$data['j_date']= date('Y-m-d');
			$data['created_date']= date('Y-m-d H:i:s');
			if(!isset($data['j_status']))
			{
				$data['j_status'] = JOB_PENDING;
			}

			if($data['j_status'] == JOB_COMPLETE) {
				$update_job['status']=0;
				$this->update_job($data['j_id'],$update_job);
			}


			$this->db->insert($this->table_job_transaction,$data);
			return $this->db->insert_id();
		}
		return false;
	}
	
	public function job_status_history($job_id=null) {
		if($job_id) {
			$this->db->select('*')
			->from($this->table_job_transaction)
			->join('user_meta ','user_meta.user_id=job_transaction.user_id','left')
			->where('job_transaction.j_id',$job_id)
			->order_by('job_transaction.id','DESC');
			$query = $this->db->get();
			return $query->result_array();
		}
		return false;
	}
	
	public function get_job_details_by_param($param=null,$value=null) {
		if($param && $value) {
			$this->db->select('*')
				->from('job_details')
				->where($param,$value);
			$query = $this->db->get();
			return $query->row();
		}
		return false;
		
	}
	public function get_cutting_details_by_job_detail($job_id=null,$value=null) {
		if($job_id && $value) {
			$this->db->select('*')
				->from('cutting_details')
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
	
	public function verify_job_by_user($data=array()) {
			$data['created'] = date('Y-m-d H:i:s');
			$this->db->insert($this->table_job_verify,$data);
			return $this->db->insert_id();
	}
	public function get_print_dashboard($param=null,$value=null) {
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
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 $condition
				 order by job.id DESC
				 LIMIT 1000
				";
		$query = $this->db->query($sql);
		$result['jobs'] = $query->result_array();
		
		$sql_jd = "SELECT jd.* from job LEFT JOIN job_details jd 
					ON job.id = jd.job_id
					 $condition order by id DESC";
		$jd_result = $this->db->query($sql_jd);
		$j_set = array();
		foreach($jd_result->result_array() as $jd) {
			$j_set[$jd['job_id']][] = $jd;
		}
		
		$result['job_details'] = $j_set;
		return $result;
	}
	
	public function get_cutting_dashboard($param=null,$value=null) {
		
		$department = $this->session->userdata['department'];
		$today = date('Y-m-d');

		// Used NewSql Earlier
		$newSql = "SELECT *,job.id as job_id,job.created as 'created',
				(select count(id) from job_views where job_views.j_id =job.id AND department = '$department') 
				as j_view,
				(select j_status from job_transaction where job_transaction.j_id=job.id ORDER BY id DESC LIMIT 0,1) 
				as jstatus
				FROM job
				 LEFT JOIN customer
				 ON job.customer_id = customer.id
				 LEFT JOIN cutting_details
				 ON job.id = cutting_details.j_id
				 WHERE job.id IN (select j_id from cutting_details where c_status =0)
				 and job.jdate = '".$today."'
				 group by job.id
				 order by job.id DESC
				 LIMIT 10
				";


		$sql = "SELECT job.*,job.id as job_id,job.created as 'created'
					FROM job
					LEFT JOIN customer ON job.customer_id = customer.id 
 					WHERE
  					job.id IN (select j_id from cutting_details where c_status =0) and job.jdate = '". $today ."' group by job.id order by job.id

  					 DESC LIMIT 100";
		//echo $sql;die('test');
		$query = $this->db->query($sql);
		$result['jobs'] = $query->result_array();
		$jobIds 		= [];

		foreach($result['jobs'] as $job)
		{
			$jobIds[] = $job['id'];
		}
		
		$sql_cd = "SELECT *, job.created as created from cutting_details 
					LEFT JOIN job on job.id = cutting_details.j_id
					LEFT JOIN customer on customer.id = job.customer_id
					WHERE j_id IN (".  implode(',', $jobIds) .")
					order by job.id desc
					";
		$cd_result = $this->db->query($sql_cd);
		return $cd_result->result_array();
	}
	
	public function get_all_customers() {
		$this->db->select('id,name,companyname,mobile')
				->from($this->table_customer)
				->where('status',1)
				->order_by('companyname');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function addJobBillNumber($jobId, $billNumber)
	{
		$data = array(
			'bill_number' 	=> $billNumber,
			'modified' 		=> date('Y-m-d H:i:s')
		);
		
		$this->db->where('id', $jobId);
		
		return $this->db->update($this->table, $data);
	}
	
	public function getAllCourierServices()
	{
		$sql = 'SELECT *, courier_services.id as id, courier_services.created as courier_created FROM courier_services  
				LEFT JOIN job ON courier_services.j_id = job.id
				LEFT JOIN customer ON customer.id = job.customer_id
				order by courier_services.id DESC
				';
		$query = $this->db->query($sql);
		
		return $query->result_array(); 
	}
	
	public function getJobsWithoutBill($customerId = null)
	{
		$userTransactions = "SELECT job_id, bill_number from user_transactions where customer_id = ".$customerId." AND t_type = 'credit' ";

		$receiptTransactions = "SELECT job_id
								FROM user_transactions
								WHERE receipt != '' and receipt != 0 
								and customer_id = '" .$customerId.  "'
								and job_id != 0
								ORDER BY id DESC";
								

		$bQuery 	= $this->db->query($userTransactions);
		
		$bResult	= $bQuery->result_array(); 
		$response 	= array();

		$receiptQuery 	= $this->db->query($receiptTransactions);
		
		$receiptResult	= $receiptQuery->result_array(); 

		$getReceiptJobId = array();
		foreach($receiptResult as $receiptJobIds)
		{
			$getReceiptJobId[] = $receiptJobIds['job_id'];
		}
		

		$jobIds 	= $this->getJobIdWithoutBill($bResult);
		$withBill   = array();

		if(count($jobIds))
		{
		if(count($getReceiptJobId) == 0)
		{
			$getReceiptJobId[0]	 = 0;
		}
		
		$withBill   = "SELECT DISTINCT(job_id) from user_transactions where customer_id = ".$customerId." AND 
			job_id NOT IN (".implode(',', $getReceiptJobId).")
			AND
			job_id NOT IN (".implode(',', $jobIds).")";

		}
		else
		{
			$withBill   = "SELECT DISTINCT(job_id) from user_transactions where customer_id = ".$customerId;
		}

		$billQ 		= $this->db->query($withBill);
		$billResult	= $billQ->result_array(); 
		$response 	= array();
		$billIds 	= $this->getJobIds($billResult);

		$sql = "SELECT * FROM job WHERE customer_id = ".$customerId." order by id ";

		$query = $this->db->query($sql);
		
		$results = $query->result_array();

		$myData = array();

		foreach($results as $result)
		{


			if(strlen($result['bill_number']) > 3)
				continue;
			
			if(in_array($result['job_id'], $billIds))
				continue;

			if(in_array($result['id'], $getReceiptJobId))
				continue;
			

			$myData[] = $result;
		}
	

		return $myData;
	}

	public function getJobIdWithoutBill($records)
	{
		$response = array();

		foreach($records as  $record)
		{
			if(strlen($record['bill_number']) > 1)
			{
				$response[] = $record['job_id'];
			}
		}

		return $response;
	}

	public function getJobIds($jobs)
	{
		$result = array();

		foreach($jobs as $job)
		{
			$result[] = $job['job_id']		;
		}

		return $result;
	}

	
	public function addNewBonus($data = array())
	{
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['notes'] 		= "Bonus Generated";

		$this->db->insert("data_bonus_details", $data);

		return $this->db->insert_id();
	}	

	public function creditBonus($customerId = null, $data = array())
	{
		$this->db->select('*')
				->from('data_bonus_account')
				->where('customer_id ='.$customerId)
				->order_by('id', 'desc')
				->limit(1);

		$query 			= $this->db->get();
		$creditEntry 	= $query->row();


		if($creditEntry && $creditEntry->id)
		{
			$data['balance'] = $creditEntry->balance + $data['credit'];
		}
		else
		{
			$data['balance'] = $data['credit'];
		}


		$data['created_at'] = date('Y-m-d H:i:s');
		$data['notes'] 		= "Bonus Generated";

		$this->db->insert("data_bonus_account", $data);

		return $this->db->insert_id();
	}	

	public function debitBonus($data = array())
	{
		$this->db->insert("data_bonus_account", $data);

		return $this->db->insert_id();
	}	

	public function getReferenceDetails($jobId = null)
	{
		if($jobId)
		{
			$this->db->select('data_bonus_details.*')
					->from('data_bonus_details')
					->where('job_id ='.$jobId);

			$result 		= $this->db->get();

			if($result->row())
			{
				return $result->row();
			}
		}

		return [];
	}

	public function resetBonus($refCustomerId, $job_id, $data)
	{
		$bonusAmount = $data['bonus_amount'];

		$sql = 'SELECT * FROM data_bonus_account WHERE job_id = ' . $job_id . 
		' order by id desc';

		$query 			= $this->db->query($sql);
		$bonusRecord 	=  $query->row();		

		$debitData = [
			'customer_id' => $bonusRecord->customer_id,
			'job_id'	  => $job_id,
			'debit'	  	  => $bonusRecord->credit,
			'balance'	  => $bonusRecord->balance - $bonusRecord->credit,
			'notes'		  => 'Debit - Due to Job Updated with Ref  ' . $job_id,
			'created_at'  => date('Y-m-d H:i:s')
		];
		
		$this->debitBonus($debitData);

		$this->db->where('job_id', $job_id);

		$status =  $this->db->update('data_bonus_details', $data);
	}

	public function today_view_cuttings()
	{
		$today = date('Y-m-d');
		$sql = 'SELECT DISTINCT(j_id) from job_views where view_date = "'. $today .'" AND department = "cuttings" ';
		$query = $this->db->query($sql);
		$jobs  = $query->result_array();
		$jobIds = [];

		foreach($jobs as $job)
		{
			$jobIds[] = $job['j_id'];
		}

		return $jobIds;
	}

	public function getUserTransporters($userId)
	{
		$sql = "SELECT * FROM transporter_details
				 WHERE customer_id = $userId
				 order by id DESC";

		$query = $this->db->query($sql);
		return $query->result_array();		
	}

	public function getTransporterById($transporterId)
	{
		$this->db->select('name')
				->from('transporter_details')
				->where('id ='.$transporterId);
		$query = $this->db->get();
		return $query->row();
	}

	public function addNewTransporter($customerId = null, $manualTransporter)
	{
		if($customerId)
		{
			$data = [
				'customer_id' 	=> $customerId,
				'name' 			=> $manualTransporter
			];

			$this->db->insert('transporter_details', $data);		
			return $this->db->insert_id();
		}

		return true;
	}

	public function pinJob($jobId = null, $isPin = 1)
	{
		if($jobId)
		{
			$data['is_pin'] = $isPin;

			$this->db->where('id',$jobId);
			return $this->db->update($this->table, $data);		
		}

		return false;
	}

	public function updateUserTransaction($jobId, $data)
	{
		$this->db->select('*')
				->from($this->table_transaction)
				->where('job_id ='.$jobId)
				->order_by('id')
				->limit(1);
		$query = $this->db->get();
		$userTransaction =  $query->row();

		$this->db->where('id', $userTransaction->id);
		return $this->db->update($this->table_transaction, $data);
	}
}