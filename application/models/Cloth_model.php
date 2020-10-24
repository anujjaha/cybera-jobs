<?php
class Cloth_model extends CI_Model 
{
	public function __construct()
    {
		parent::__construct();
	}

	/** 
	 * Vendor List
	 *
	 * @return array
	 */
	public function vendorList()
	{
		return $this->db->from('cloth_vendors')->get()->result_array();
	}

	/** 
	 * Material List
	 *
	 * @return array
	 */
	public function materialList()
	{
		return $this->db->from('cloth_material')
			->where('status', 1)
			->get()->result_array();
	}

	/** 
	 * Add Vendor
	 *
	 * @param array $input
	 * @return array|bool
	 */
	public function addVendor($input = array())
	{
		if(is_array($input) && count($input)) {
			$input['created_at'] = date('Y-m-d H:i:s');
			$input['created_by'] = $this->session->userdata['user_id'];

			return $this->db->insert('cloth_vendors', $input);
		}

		return false;
	}

	/** 
	 * Add Material
	 *
	 * @param array $input
	 * @return array|bool
	 */
	public function addMaterial($input = array())
	{
		if(is_array($input) && count($input)) {
			$input['approx_output'] = $input['total_kg'] / $input['approx_ratio'];
			$input['approx_cost'] = $input['total_cost'] / $input['approx_output'];
			
			$input['created_at'] = date('Y-m-d H:i:s');
			$input['created_by'] = $this->session->userdata['user_id'];

			return $this->db->insert('cloth_material', $input);
		}

		return false;
	}

	/** 
	 * Block Unblock Vendor
	 *
	 * @param int $vendorId
	 * @param int $status
	 * @return bool
	 */
	public function blockUnblockVendor($vendorId = null, $status = 0)
	{
		if($vendorId)
		{
			return $this->db->where('id', $vendorId)
				->update('cloth_vendors', [
					'status' => $status
				]);
		}

		return false;
	}

	/**
	 * Delete Material
	 *
	 * @param int $materialId
	 */
	public function deleteMaterial($materialId = null)
	{
		if($materialId)
		{
			return $this->db->where('id', $materialId)
				->update('cloth_material', [
					'status' => 0
				]);
		}

		return false;	
	}
}
