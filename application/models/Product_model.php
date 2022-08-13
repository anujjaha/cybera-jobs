<?php

class Product_model extends CI_Model {
	public function __construct()
    {
		parent::__construct();
	}
    
    public $table = "products";
    public $relation_table = "general_products";

    public function getAll() {
		$this->db->select('*, products.title as product_title')
				->from($this->table)
				->where('products.status', 1);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function add_transaction($data = array())
	{
		$inStock = 0;
		$stockQty = $data['qty'];
		if($data['stock_in'] == 1)
		{
			$inStock = 1;
		}
		$data['created_at'] = date('Y-m-d H:i:s');
		$this->db->insert($this->relation_table, $data);

		$this->updateStock($data['product_id'], $stockQty, $inStock);
		return true;
	}

	function updateStock($productId, $stockQty, $inStock = 1)
	{
		$productInfo = $this->db->select('*')
			->from($this->table)
			->where('id', $productId)
			->get()
			->row();

		if($inStock == 1)
		{
			$newQty = $productInfo->qty + $stockQty;
		}
		else
		{
			$newQty = $productInfo->qty - $stockQty;
		}
		$this->db->where('id', $productId);
		$this->db->update($this->table, [
			'qty' => $newQty
		]);
	}
}