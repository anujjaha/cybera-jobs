<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transporter extends CI_Controller {

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
	public function index()
	{
            $this->load->model('transport_model');
            $data = array();
            $data['results'] = $this->transport_model->getAll();
            $data['heading'] =$data['title']="Manage Transporters - Cybera Print Art";

            $this->template->load('transporter', 'index', $data);		
	}

	public function add()
	{
		$data['heading'] = $data['title'] = "Add Restarant Menu";
		
		if($this->input->post()) 
		{
			$data = array(
				'code' 			=> $this->input->post('code'),
				'title'  		=> $this->input->post('title'),
				'price'  		=> $this->input->post('price'),
				'qty'  			=> $this->input->post('qty'),
				'extra'  		=> $this->input->post('extra'),
				'created_at'  => date('Y-m-d H:i:s')
			);

			$this->load->model('menu_model');
			$this->menu_model->create($data);
			redirect("menu/index",'refresh');
		}

		$this->template->load('menu', 'add', $data);
	}
}
