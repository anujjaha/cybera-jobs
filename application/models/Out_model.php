<?php

class Out_model extends CI_Model {
	public function __construct()
    {
    	parent::__construct();
    }

    public $table = "data_out_jobs";
    public $tableDetails = "data_out_job_details";

    public function create($data=array())
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


    public function insertDetails($data)
    {
    	if(is_array($data) && count($data))
    	{
    		return $this->db->insert_batch($this->tableDetails, $data);
    	}

    	return false;
    }

    public function attachOutSide($token, $jobId, $customerId)
    {
        $data = [
            'job_id'      => $jobId,
            'customer_id' => $customerId
        ];

        $this->db->where('job_token', $token);
        return $this->db->update($this->table, $data);
    }

    public function checkOutside($jobId)
    {
        if($jobId)
        {
            $this->db->select('*')
                    ->from($this->table)
                    ->where('job_id', $jobId);
                    
            $query = $this->db->get();
            return $query->row();
        }

        return false;
    }
}
