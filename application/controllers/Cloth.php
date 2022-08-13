<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cloth extends CI_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('cloth_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function vendors()
	{
		$data  = [
			'title' 	=> 'Vendor List',
			'heading' 	=> 'Vendor List',
			'vendors' 	=> $this->cloth_model->vendorList(),
		];

		$this->template->load('cloth', 'vendor-list', $data);
	}

	/**
	 * Material
	 *
	 */
	public function material()
	{
		$data  = [
			'title' 	=> 'Material List',
			'heading' 	=> 'Material List',
			'materials'	=> $this->cloth_model->materialList(),
		];

		$this->template->load('cloth', 'material-list', $data);
	}

	/**
	 * Add Material
	 *
	 */
	public function add_material()
	{
		$data  = [
			'title' 	=> 'Add Material',
			'heading' 	=> 'Add Material',
			'vendors' 	=> $this->cloth_model->vendorList(),
		];

		if($this->input->post())
		{
			$data = $this->input->post();
			unset($data['save']);
			
			$this->cloth_model->addMaterial($data);
			
			redirect('cloth/material', "refresh");
		}
		
		$this->template->load('cloth', 'material-add', $data);
	}
	
	/** 
	 * Add Vendor
	 *
	 * @return view
	 */	
	public function add_vendor()
	{
		$data['heading'] = $data['title']="Add New Cloth Vendor - Cybera Print Art";
		
		if($this->input->post())
		{
			$data = $this->input->post();
		
			unset($data['save']);
			
			$this->cloth_model->addVendor($data);
			
			redirect('cloth/vendors', "refresh");
		}
			
		$this->template->load('cloth', 'vendor-add', $data);
	}

	/** 
	 * Block Vendor
	 *
	 * @return view
	 */	
	public function vendor_block($vendorId = null)
	{
		if($vendorId)
		{
			$this->cloth_model->blockUnblockVendor($vendorId, 0); 
			redirect('cloth/vendors', "refresh");
		}
	}

	/** 
	 * Delete Material
	 *
	 * @return view
	 */	
	public function delete_material($materialId = null)
	{
		if($materialId)
		{
			$this->cloth_model->deleteMaterial($materialId, 0); 
			redirect('cloth/material', "refresh");
		}
	}

	/** 
	 * Un Block Vendor
	 *
	 * @return view
	 */	
	public function vendor_unblock($vendorId = null)
	{
		if($vendorId)
		{
			$this->cloth_model->blockUnblockVendor($vendorId, 1); 
			redirect('cloth/vendors', "refresh");
		}
	}
}