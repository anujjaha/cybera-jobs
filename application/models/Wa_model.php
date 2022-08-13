<?php
class Wa_model extends CI_Model 
{

	public function __construct()
    {
                parent::__construct();
    }
    
    public $table = "wa_estimations";

    public function create($data=array())
    {
    	if(is_array($data) && count($data))
        {
        	$latest = $this->db->select('*')
        				->from($this->table)
        				->limit(1)
        				->order_by('id', 'desc')
        				->get()
        				->row();

        	if(
        		$latest->customer == $data['customer']
        		&&
        		$latest->title == $data['title']
        		&&
        		$latest->total == $data['total']
        		&&
        		$latest->pay_by == $data['pay_by']
        		&&
        		$latest->transport_by == $data['transport_by']
        		&&
        		$latest->transport_cost == $data['transport_cost']
        		&&
        		$latest->sub_total == $data['sub_total']
        	)
        	{
        		return $latest->id;
        	}

    		date_default_timezone_set("Asia/Calcutta");
            $data['created_by'] = $this->session->userdata['user_id'];
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['job_notes'] 	= implode(",", $data['job_notes']);

            $status = $this->db->insert($this->table, $data);
            return $this->db->insert_id();	
            
        }
        
        return false;
    }

    public function update($outId = null, $data=array())
    {
    	if(is_array($data) && count($data))
    	{
            return $this->db->where('id', $outId)
            ->update($this->table, $data);
    	}
    	
    	return false;
    }

    public function getAll() 
    {
		$this->db->select($this->table.'.*, CONCAT(user_meta.first_name, " ", user_meta.last_name) as username')
				->from($this->table)
				->join('user_meta', 'user_meta.user_id = wa_estimations.created_by', 'left')
				->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}

    public function getOnlyTitles() 
    {
        $this->db->select($this->table.'.title')
                ->where("title != '' ")
                ->from($this->table)
                ->order_by('title')
                ->group_by('title');

        $query = $this->db->get();
        return $query->result_array();
    }

    

	/**
	 * Get By Id
	 *
	 * @param int $id
	 * @return object
	 **/
	public function getById($id)
	{
		return $this->db->select('*')
			->from($this->table)
			->where('id', $id)
			->get()
			->row();
	}
}
