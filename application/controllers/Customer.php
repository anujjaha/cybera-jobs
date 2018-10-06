<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('customer_model');
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
	public function index()
	{
		$today = date("Y-m-d");
		$condition = array('condition'=>array('jdate'=>$today))	;
		$result = $this->customer_model->get_customer_details();
		$data['title']="Customer Management";
		$data['heading']="Customer Management";
		$data['customers']= $result;
		$this->template->load('customer', 'index', $data);
	}

	public function print_customer()
	{
		$this->load->model('dealer_model');
		$dealers = $this->dealer_model->get_customer_details();
		$html    = '<table style="border: solid 2px black;" class="table" border="2">
					<tr>
						<th style="border: solid 2px black;"> Name </th>
						<th style="border: solid 2px black;"> Contact </th>
						<th style="border: solid 2px black;"> Other Contact </th>
						<th style="border: solid 2px black;"> Email </th>
						<th style="border: solid 2px black;"> Address </th>
						<th style="border: solid 2px black;"> City </th>
						<th style="border: solid 2px black;"> Total Transaction </th>
						<th style="border: solid 2px black;"> Due </th>
					</tr>';

		$total = 0;
		$totalDue = 0;
		foreach($dealers as $dealer)
		{
			$dealer = (array)$dealer;

			$total 		= $total + $dealer['total_amount'];
			$totalDue 	= $totalDue + $dealer['due'];
			$dealerName = isset($dealer['companyname']) ? $dealer['companyname']  : $dealer['name'];

			$html   .= '<tr>';	

				$html   .= '<td style="border: solid 1px black;"> '. $dealerName .' </td>';
				$html   .= '<td style="border: solid 1px black;"> '. $dealer['mobile']. ' </td>';
				$html   .= '<td style="border: solid 1px black;"> '. $dealer['officecontact']. ' </td>';
				$html   .= '<td style="border: solid 1px black;"> '. $dealer['emailid']. ' </td>';
				$html   .= '<td style="border: solid 1px black;"> '. $dealer['add1'] . ' '. $dealer['add2'] . ' </td>';
				$html   .= '<td style="border: solid 1px black;"> '. $dealer['city']. ' </td>';
				$html   .= '<td style="border: solid 1px black;"> '. $dealer['total_amount']. ' </td>';
				$html   .= '<td style="border: solid 1px black;"> '. $dealer['due']. ' </td>';
				
			$html   .= '</tr>';
		}
			$html .= '<tr><td style="border: solid 1px black;" colspan="6"></td><td style="border: solid 1px black;">'. number_format($total, 2) .'</td><td style="border: solid 1px black;">'. number_format($totalDue, 2).'</td></tr>';
			$html .= '</table>';
		header("location:".create_pdf($html, 'A4'));
		exit;
	}
	
	public function quick()
	{
		$offset= 0;
		$limit = 10;
		$data['title']="Quick Customer Management";
		$data['heading']="Quick Customer Management";
		$data['customers']= $this->customer_model->get_quick_customer_details($offset, $limit);
		$this->template->load('customer', 'quick', $data);
	}
	
	public function admin()
	{
		$today = date("Y-m-d");
		$condition = array('condition'=>array('jdate'=>$today))	;
		$result = $this->user_model->get_jobs('',$condition);
		$data['title']="Dashboard";
		$data['heading']="Dashboard";
		$data['today_jobs']="15";
		$data['today_counter']="100";
		$data['total_dealers']="12";
		$data['total_customers']="100";
		$data['jobs']= $result;
		$this->template->load('user', 'index', $data);
	}
	
	public function get_customer_ajax($param=null,$value=null) {
		if($param) {
			$result = $this->customer_model->get_customer_details($param,$value);
			if($result) {
				if($result->mobile) {

					echo json_encode(array(
						'mobile' 	=> $result->mobile,
						'email' 	=> $result->emailid,
					));
					return true;
				}
				if($result->officecontact) {
					echo json_encode(array(
						'mobile' 	=> $result->officecontact,
						'email' 	=> $result->emailid,
					));
					return true;
				}
			}
		}
		return false;
	}
	
	public function edit($customer_id=null) {

		$this->load->model('customer_model');
		$data['title']="Add Customer";
		$data['heading']="Add Customer";
		if($customer_id) {
			$data['title']="Edit Customer";
			$data['heading']="Edit Customer";
			$data['dealer_info']= $this->customer_model->get_customer_details('id',$customer_id);
			$data['transporter_info'] = $this->customer_model->getTransporterDetailsByCustomerId($customer_id);
		}
		if($this->input->post()) {
			$data = array();
			$data['name'] = $this->input->post('name');
			$data['companyname'] = $this->input->post('companyname');
			$data['mobile'] = $this->input->post('mobile');
			$data['officecontact'] = $this->input->post('officecontact');
			$data['emailid'] = $this->input->post('emailid');
			$data['add1'] = $this->input->post('add1');
			$data['add2'] = $this->input->post('add2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['pin'] = $this->input->post('pin');
			$data['outside'] = $this->input->post('outside');
			$data['ctype'] = $this->input->post('ctype');
			$data['extra_amount'] = $this->input->post('extra_amount');
			$customer_id = $this->input->post('customer_id');
			$transporter_id = $this->input->post('transporter_id');
			if($customer_id) {
				$this->customer_model->update_customer($customer_id,$data);
			} else {

				if($this->input->post('ctype') && $this->input->post('ctype') == 1)
				{
					$this->load->model('dealer_model');
					
					$customer_id = $this->dealer_model->insert_dealer($data);
				}
				else
				{
					$customer_id = $this->customer_model->insert_customer($data);
				}
				
			}
			
			$transporterData = array(
				'customer_id' 		=> $customer_id,
				'name'		  		=> $this->input->post('transporter_name'),
				'contact_person'	=> $this->input->post('transporter_contact_person'),
				'contact_number'	=> $this->input->post('transporter_contact_number'),
				'location'		  	=> $this->input->post('transporter_location')
			);
			 
			if(isset($transporter_id) && $transporter_id != '') 
			{
				$this->customer_model->updateTransporterDetails($transporter_id, $transporterData);
			}
			else
			{
				$this->customer_model->addTransporterDetails($transporterData);
			}
			
			$this->load->helper('url');
			redirect("/",'refresh');
		}
		$this->template->load('customer', 'edit', $data);
	}
	
	public function get_paper_rate() 
	{
		$paper_gram = $this->input->post('paper_gram');
		$paper_size = $this->input->post('paper_size');
		$paper_print = $this->input->post('paper_print');
		$paper_qty = $this->input->post('paper_qty');
		$addPerPrint = 0;
		$data = array();
		$customerId = $this->input->post('check_customer_id');

		if(isset($customerId) && $customerId != 0)
		{
			$customerDetails = $this->customer_model->get_customer_details('id', $customerId);

			$addPerPrint = $customerDetails->extra_amount;
		}

		$this->load->model('paper_model');
		$data = $this->paper_model->get_paper_rate($paper_gram,$paper_size,$paper_qty);
		if(!empty($data)) {

			$data->paper_amount = $data->paper_amount + $addPerPrint;
			echo json_encode($data,true);
			die;
		}
		$data['success']=false;
		echo json_encode($data,true);
		die;
	}
	
	public function edit_prospects($customer_id=null) {
		$this->load->model('customer_model');
		$data['heading'] = $data['title']="Add Prospect";
		if($customer_id) {
			$data['heading']=$data['title']="Edit Prospect";
			$data['dealer_info']= $this->customer_model->get_prospects_details('id',$customer_id);
		}
		if($this->input->post()) {
			$data = array();
			$data['name'] = $this->input->post('name');
			$data['ccategory'] = $this->input->post('ccategory');
			$data['companyname'] = $this->input->post('companyname');
			$data['mobile'] = $this->input->post('mobile');
			$data['officecontact'] = $this->input->post('officecontact');
			$data['emailid'] = $this->input->post('emailid');
			$data['add1'] = $this->input->post('add1');
			$data['add2'] = $this->input->post('add2');
			$data['city'] = $this->input->post('city');
			$data['state'] = $this->input->post('state');
			$data['pin'] = $this->input->post('pin');
			$customer_id = $this->input->post('customer_id');
			if($customer_id) {
				$this->customer_model->update_prospect($customer_id,$data);
			} else {
				$this->customer_model->insert_prospect($data);
			}
			$this->load->helper('url');
			redirect("customer/prospects",'refresh');
		}
		$data['categories'] = $this->customer_model->get_customer_categories();	
		$this->template->load('customer', 'edit_prospect', $data);
	}
	public function prospects() {
		$result = $this->customer_model->get_prospects_details();
		$data['heading']=$data['title']="Prospects Management";
		$data['customers']= $result;
		
		$this->template->load('customer', 'prospect', $data);
	}
}
