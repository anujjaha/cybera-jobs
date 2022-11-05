<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function ajax_job_view() {
		if($this->input->post()) {
			$this->load->model('jobview_model');
			$data=array();
			$data['department'] = $this->input->post('department');
			$data['j_id'] = $this->input->post('id');
			$data['user_id'] = $this->session->userdata['user_id'];
			$data['view_time'] = date('h:i');
			$data['view_date'] = date('Y-m-d');
			$this->jobview_model->insert_jobview($data);
			return true;
		}
		
	}
	public function ajax_job_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$this->load->model('user_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['courier'] = $this->user_model->get_courier($job_id);
		$data['userInfo'] = get_user_by_param('id', $job_data->user_id);
		$data['cuttingInfo'] = $this->job_model->get_cutting_details($job_id);
		$this->load->view('ajax/view_job', $data);
	}
	public function ajax_job_simple_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$this->load->model('user_model');
		$this->load->model('account_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$data['cuttingInfo'] = $this->job_model->get_cutting_details($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['userInfo'] = get_user_by_param('id', $job_data->user_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['job_transactions'] = $this->account_model->get_job_transactions($job_id);
		$this->load->view('ajax/view_simple_job', $data);
	}
	
	public function ajax_cutting_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$cutting_details = $this->job_model->get_cutting_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['cutting_details']=$cutting_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$this->load->view('ajax/view_cutting', $data);
	}
	
	public function ajax_job_datatable($param='jdate',$value) {
		$this->load->model('job_model');
		$data = array();
		if(! $value) {
			$value = "'".date('Y-m-d')."'";
		}
		$data['jobs'] = $this->job_model->get_today_details("job.$param","$value");
		$this->load->view('ajax/job_datatable', $data);
	}
	public function ajax_cutting_datatable($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		//$data['jobs'] = $this->job_model->get_today_cutting_details();
		$data = $this->job_model->get_cutting_dashboard();
		$this->load->view('ajax/cutting_datatable', $data);
	}
	
	public function ajax_job_count($param='jdate',$value) {
		$this->load->model('job_model');
		if(! $value) {
			$value = "'".date('Y-m-d')."'";
		}
		$data = array();

		$today 	= date('Y-m-d');
        $data 	= $this->job_model->get_print_dashboard('job.jdate',"'".$today."'");

        echo count($data['jobs']);
        return;
		/*$data['jobs'] = count($this->job_model->get_today_details("job.$param","$value"));
		pr($this->job_model->get_today_details("job.$param","$value"))
		echo $data['jobs'];return true;*/
		
	}
	public function ajax_cutting_count($param='jstatus',$value='Pending') {
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = count($this->job_model->get_today_cutting_details());
		echo $data['jobs'];
		return true;
	}
	
	public function ajax_jobstatus_history($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$data['job_data'] = $this->job_model->get_job_data($job_id);
			$data['job_history'] = $this->job_model->job_status_history($job_id);
			$this->load->view('ajax/job_history', $data);
		}
	}
	
	public function save_courier($job_id=null){ 
		if($job_id) {
			$this->load->model('user_model');
			$data['j_id'] = $job_id;
			$data['courier_name'] = $this->input->post('courier_name');
			$data['docket_number'] = $this->input->post('docket_number');
			$data['user_id'] = $this->session->userdata['user_id'];
			$data['created'] = date('Y-m-d H:i:s');
			
			$this->load->model('job_model');
			$job_data = $this->job_model->get_job_data($job_id);
			$customer = $this->job_model->get_customer_details($job_data->customer_id);
			$cusName = !empty($customer->companyname) ? $customer->companyname : $customer->name;
			
			$sms_text = 'Dear '. $cusName .', We have dispatched your parcel via - '. $this->input->post('courier_name') .' and the docket number is '.$this->input->post('docket_number').'. Thank You. CYBERA';

			$note2 = 'Our responsibility ceases absolutely as soon as the goods have been handed over to Rail, Motor Lorry and other career on in person.';
			$mailText = $sms_text . '<br /><br /><br /> <strong>Note:</strong> We always try to deliver your parcels to courier or transport services within committed time frame. In case, if your parcel is delayed due to any reason, Cybera will not be responsible. Inconvenience is regretted.<br /><br/><br /> ' . $note2;

				// Hindi / Gujarati Courier version

				 /*અમે હંમેશાં તમારા પાર્સલને કુરિયર અથવા પરિવહન સેવાઓમાં નિર્ધારિત  સમય મર્યાદામાં પહોંચાડવાનો પ્રયાસ કરીએ છીએ. જો કોઈ કારણોસર તમારું પાર્સલ મોડું થાય તો સાયબેરા જવાબદાર રહેશે નહીં. અસુવિધા બદલ દિલગીર છીએ.<br /><br/><br /><br/><br />हम हमेशा आपके पार्सल को कूरियर या परिवहन सेवाओं मेंं समय सीमा के भीतर वितरित करने का कोशिश करते हैं। यदि आपका पार्सल किसी भी कारण से लेट होता है तो साइबेरा जिम्मेदार नहीं होगा। असुविधा के लिए खेद है।';*/

			$subject = 'Dispatched Parcel via - ' . $this->input->post('courier_name') . ' by Cybera';
			
			$status = sendBulkEmail(array($customer->emailid), 'cyberaprintart@gmail.com', $subject, $mailText);


			send_sms($this->session->userdata['user_id'], $customer->id,$customer->mobile,$sms_text);
			
			$this->user_model->save_courier($job_id,$data);
		}
		return true;
	}
	
	public function create_estimation() {
		if($this->input->post()) {
			$this->load->model('estimationsms_model'); 	
			$customer_id = $this->input->post('customer_id');
			$customer_email = $this->input->post('customer_email');
			$sms_message = $this->input->post('sms_message');
			$sms_mobile = $this->input->post('sms_mobile');
			$sms_customer_name = $this->input->post('sms_customer_name');
			$prospect_id = 0;	
			if($this->input->post('prospect') && $this->input->post('prospect') == 1) {
				$this->load->model('customer_model');
				$pdata['name']= $sms_customer_name;
				$pdata['mobile']= $sms_mobile;
				$pdata['ccategory']= 'General-Estimation';
				$prospect_id = $this->customer_model->insert_prospect($pdata);
			}
			
			$quote_data['customer_id'] = $customer_id;
			$quote_data['prospect_id'] = $prospect_id;
			$quote_data['sms_message'] = $sms_message;
			$quote_data['mobile'] = $mobile = $sms_mobile;
			$quote_data['user_id'] = $user_id =  $this->session->userdata['user_id'];
			$quote_id = $this->estimationsms_model->insert_estimation($quote_data);
			$sms_text = "Dear ".$sms_customer_name.", ".$sms_message." GST Extra.Quote No. ".$quote_id." valid for 7 days. CYBERA";

			send_sms($user_id,$customer_id,$mobile,$sms_text,$prospect_id);
			sendCorePHPMail('cybera.printart@gmail.com', 'cybera.printart@gmail.com', 'Cybera Estimation - ' .$sms_customer_name, $sms_text);
			
			if($customer_email) {
				$emailStatus = send_mail($customer_email,'cybera.printart@gmail.com','Estimation - Cybera',$sms_text);
			}
			
			
			echo $sms_text;
		}
		return true;
	}
	
	public function get_cutting_details_by_job_detail($id,$job_id) {
		$this->load->model('job_model');
		$jdetails = $this->job_model->get_job_details_by_param('id',$id);
		$cutting_details = $this->job_model->get_cutting_details_by_job_detail($job_id,$jdetails->jdetails);
		echo json_encode($cutting_details);
		die();
	}
	
	public function ajax_update_cutting_details($job_details_id,$job_id,$sr) {
		
		$this->load->model('job_model');
		$jdetails = $this->job_model->get_job_details_by_param('id',$job_details_id);
		$data['cutting_details'] = $this->job_model->get_cutting_details_by_job_detail($job_id,$jdetails->jdetails);
		$data['jdetails'] = $jdetails;
		$data['j_id'] = $job_id;
		$data['sr'] = $sr;
		$this->load->view('ajax/update_cutting',$data);
	}
	
	public function save_edit_cutting_details() {
		if($this->input->post()) {
			$this->load->model('job_model');
			$data = $this->input->post();
			unset($data['update']);
			unset($data['cutting_id']);
			$id = $this->input->post('cutting_id');
			$data['j_id'] = $this->input->post('j_id');
			if(!$id) {
				$this->job_model->insert_cuttingdetails($data,true);
			}
			$this->job_model->update_cutting_details($id,$data);
			return true;
		}
	}
	
	public function pay_job($job_id=null) {
		if($job_id) {
			$this->load->model('job_model');
			$this->load->model('account_model');
			
			$myjob = $this->job_model->get_job_data($job_id);
			
			$data = array();
			$data['settlement_amount'] = $this->input->post('settlement_amount');
			
			$data['due'] = $myjob->due - $this->input->post('settlement_amount');
			if($data['due'] == 0 ) {
				$data['jpaid'] = 1;
			}
			$this->job_model->update_job($job_id,$data);
			
			$cMonth = date("M-Y",strtotime($this->input->post('cmonth')));	
			
			$job_data = $this->job_model->get_job_data($job_id);
			$pay_data['job_id'] = $job_id;
			$pay_data['customer_id'] = $job_data->customer_id;
			$pay_data['amount'] = $data['settlement_amount'];
			$pay_data['amountby'] = 'Cash';
			$pay_data['bill_number'] = $this->input->post('bill_number') ? $this->input->post('bill_number') : "";
			$pay_data['receipt'] = $this->input->post('receipt');
			$pay_data['other'] = $this->input->post('other') ? $this->input->post('other') : '';
			$pay_data['cmonth'] = $cMonth;
			$pay_data['pay_ref'] = $this->input->post('payRef');
			$pay_data['notes'] = $this->input->post('payRefNote');
			
			$pay_data['cheque_number'] = $this->input->post('cheque_number') ? $this->input->post('cheque_number') : '';
			$pay_data['creditedby'] =$this->session->userdata['user_id'];
			$this->account_model->credit_amount($job_data->customer_id,$pay_data,CREDIT);

			$cashReceiptContent = getTodayCashReceiptMailContent();
			$subject = 'Today Cash Receipt -' . date('d-m-Y h:i');
			sendBulkEmail(array('shaishav77@gmail.com'), 'cyberaprintart@gmail.com', $subject, $cashReceiptContent);

			return true;
		}
	}
	
	public function ajax_get_customer($customer_id=null) {
		if($customer_id) {
			$this->load->model('job_model');
			$data = $this->job_model->get_customer_details($customer_id);
			echo json_encode($data);
		die();
		}
		return false;
	}
	
	public function ajax_customer_details_by_param($param=null,$value=null) {
		if($param && $value) {
			$this->load->model('customer_model');
			$data = $this->customer_model->get_customer_details($param,$value);
			if( count($data) > 0 ) {
				echo $data->companyname ? $data->companyname : $data->name;
			}
		}

		return true;
	}
	
	public function ajax_job_short_details($job_id=null) {
		if(! $job_id) {
			return true;
		}
		$this->load->model('job_model');
		$this->load->model('user_model');
		$job_data = $this->job_model->get_job_data($job_id);
		$job_details = $this->job_model->get_job_details($job_id);
		$customer_details = $this->job_model->get_customer_details($job_data->customer_id);
		$data['customer_details']=$customer_details;
		$data['job_details']=$job_details;
		$data['job_data']=$job_data;
		$data['heading'] = $data['title']='View Job';
		$data['courier'] = $this->user_model->get_courier($job_id);
		$this->load->view('ajax/view_short_job', $data);
	}
	
	public function ajax_job_verify($job_id=null) {
		if($this->input->post()) {
			$this->load->model('job_model');
			$jdata['job_id'] = $job_id;
			$jdata['user_id'] = $this->session->userdata['user_id'];
			$jdata['notes'] = $this->input->post('notes');
			$verify_id = $this->job_model->verify_job_by_user($jdata);
			$data['bill_number'] = $this->input->post('bill_number');
			$data['receipt'] = $this->input->post('receipt');
			$data['voucher_number'] = $this->input->post('voucher_number');
			$data['verify_id'] = $verify_id;
			$this->job_model->update_job($job_id,$data);
			print_r($data);
			return true;
		}
	}
	
	public function update_user_status($user_id=null,$status) {
		if($user_id) {
			$data['active'] = 1;
			if($status == 1 ) {
				$data['active'] = 0;
			}
			$this->load->model('user_model');
			return $this->user_model->update_user($user_id,$data);
		}
		return false;
	}
	
	public function ajax_switch_customer($id=null,$roll=0) {
		if($id) {
			$this->load->model('customer_model');
			$customer_info = $this->customer_model->get_customer_details('id',$id);
			$update_customer = array();
			//Convert to Customer
			if($roll == 0 ) {
				$update_customer['username'] = $update_customer['password'] = 	"customer".$customer_info->id;
				$update_customer['ctype'] = 0;
				$update_customer['dealercode'] = "";
			}
			//Convert to Dealer
			if($roll == 1 ) {
				$update_customer['username'] = $update_customer['password'] = 	"dealer".$customer_info->id;
				$update_customer['ctype'] = 1;
				$update_customer['dealercode'] = "D-".$customer_info->id;
			}
			//Convert to Voucher
			if($roll == 2 ) {
				$update_customer['username'] = $update_customer['password'] = 	"customer".$customer_info->id;
				$update_customer['ctype'] = 2;
				$update_customer['dealercode'] = "";
			}
			$this->customer_model->update_customer($id,$update_customer);
				return true;
		}
		return false;
	}
	
	public function ajax_delete($id=null) {
		if($id) {
			$this->load->model('customer_model');
			return $this->customer_model->delete_customer($id);
		}
		return false;
	}

	public function ajax_delete_rate($id=null) {
		if($id) {
			$this->load->model('customer_model');
			return $this->customer_model->deleteSpecialRate($id);
		}
		return false;
	}
	
	public function ajax_old_job_details($id=null) {
		$this->load->model('user_model');
		$data['jobdata'] = $this->user_model->get_old_job($id);
		$this->load->view('ajax/view_old_job',$data);
	}
	
	public function get_customer_due_with_outside($user_id=null) {
		if($user_id) {
			
			echo json_encode(array(
				'balance' 		=> round(get_balance($user_id)),
				'outsideStatus' => getCustomerOutside($user_id)
			));
			die;
		}
		return false;
	}
	
	public function get_customer_due($user_id=null) {
		if($user_id) {
			echo round(get_balance($user_id));
			die;
		}
		return false;
	}
	
	public function ajax_credit_amount() {
		if($this->input->post()) {
			
			$this->load->model('account_model');
			$this->load->model('job_model');
			$customer_id = $this->input->post('customer_id');
			$pay_data['amount'] = $this->input->post('settlement_amount');
			$pay_data['customer_id'] = $this->input->post('customer_id');
			$pay_data['amountby'] = 'Cash';
			$pay_data['cheque_number'] = $this->input->post('bill_number') ? $this->input->post('bill_number') : 0;
			$pay_data['receipt'] = $this->input->post('receipt') ? $this->input->post('receipt') : 0;
			$pay_data['other'] = $this->input->post('other') ? $this->input->post('other') : '';
			$pay_data['notes'] = $this->input->post('notes') ? $this->input->post('notes') : 'Cash Added';
			$pay_data['creditedby'] =$this->session->userdata['user_id'];
			
			if(strlen($this->input->post('cmonth')) > 1) {
				$pay_data['cmonth'] = date("M-Y",strtotime($this->input->post('cmonth')));
			}
			
			$this->account_model->credit_amount($customer_id,$pay_data,CREDIT);
			
			if($this->input->post('send_sms') == "0") {
				$send_sms = false;
				return true;
			}
			
				$today = date('d-m-Y');
				$customer_details = $this->job_model->get_customer_details($customer_id);
				$mobile = $customer_details->mobile;
				//$mobile = "9898618697";
				$customer_name = $customer_details->companyname ? $customer_details->companyname : $customer_details->name; 
				//$sms_text = "Dear \$customer_name, we have received ".$pay_data['amount']." Rs. by Cash on date ".$today.". Thank You.";
				$user_balance  = get_balance($customer_id);
				$sms_text = "Dear $customer_name, we have received ".$pay_data['amount']." Rs. by Cash on date ".$today.". Thank You. CYBERA";

				send_sms($this->session->userdata['user_id'],$customer_id,$mobile,$sms_text) ;
			
			return true;
		}
	}
	
	public function ajax_delete_transaction($id) {
		$this->load->model('account_model');
		$this->account_model->delete_entry($id);
		die('done');
		return true;
	}
	
	public function ajax_account_statstics() {
		if($this->input->post()) {
			$this->load->model('account_model');
			$this->load->model('job_model');
			$user_id = $this->input->post('customer_id');
			$customer_details = $this->job_model->get_customer_details($user_id);
			$c_balance = get_balance($user_id);
			$month = $this->input->post('month');
			$year = $this->input->post('year');
			
			$all=false;
			
			if($year == "all" || $month[0] == 'all') {
				$all = true;
			}  
			else if (count($month) > 0 )
			{
				foreach($month as $useMonth) 
				{
					$jmonth[] = "'". $useMonth."-".$year .  "'";	
				}
			}
			else
			{
				$jmonth = $month[0]."-".$year;	
			}
			
			$customer_name = $customer_details->companyname ? $customer_details->companyname : $customer_details->name; 
			$data = $this->account_model->account_statstics($user_id,$jmonth,$all);
			/*
				<tr>
					<td colspan="10" align="center">
					<h2>'.$customer_name.' (Total Due - '.$c_balance.' ) </h2>
					</td>
				</tr>
			*/
			$print = '<table border="2" width="100%">
					
					
					<tr>
					<td style="border:1px solid">Date</td>
					<td style="border:1px solid">Time</td>
					<td style="border:1px solid">Job No.</td>
					<td style="border:1px solid">Job Name</td>
					<td style="border:1px solid">Debit</td>
					<td style="border:1px solid">Credit</td>
					<td style="border:1px solid">Balance</td>
					<td style="border:1px solid">Reference</td>
					<td style="border:1px solid">Credit Note</td>
					<td style="border:1px solid">Received By</td>
					<td style="border:1px solid">Details</td>
					</tr>';
		$total_debit = $total_credit = 0;
		foreach($data as $result) {
			
			
			if($result['t_type'] == CREDIT and $result['amount'] == 0) { 
				continue;
			}
			if($result['t_type'] == DEBIT ) {
			$total_debit = $total_debit + $result['amount'];
			$balance = $balance - $result['amount'];
		} else {
			$total_credit = $total_credit + $result['amount'];
			$balance = $balance + $result['amount'];
		}
		
		$print .= '<tr>
					<td style="border:1px solid">'.date('d-m-y',strtotime($result['created'])).'</td>
					<td style="border:1px solid">'.date('H:i A',strtotime($result['created'])).'</td>
					<td style="border:1px solid">';
		
		if($result['job_id']) {
				$print .= $result['job_id'];
		 } else {
			$print .= "-";
		}
		//echo $print;
		$print .= '</td><td style="border:1px solid">'.$result['jobname'].'</td>
				  <td align="right" style="border:1px solid">';
			
				$show = "-";
					if($result['t_type'] == DEBIT ) {
							$show = $result['amount'];
					}
				$print .= $show;
		$print .= '</td><td align="right" style="border:1px solid">';
			
				$show = "-";
					if($result['t_type'] != DEBIT ) {
							$show = $result['amount'];
					}
				$print .= $show;
				
		$print .= '</td><td align="right" style="border:1px solid">'.$balance.'
		</td><td style="border:1px solid">';
			if(!empty($result['j_receipt'])) {
					$print .= "Receipt : ". $result['j_receipt'];
			}
			if(!empty($result['j_bill_number'])) {
				$print .=  "Bill  : ".$result['j_bill_number'];
			} 	
			if(!empty($result['cheque_number'])) {
				$print .=  "Cheque Number  : ".$result['cheque_number'];
			} 
		$print .= '</td><td style="border:1px solid">';
		
		
			if(!empty($result['receipt'])) {
				$print .=	 "Receipt : ". $result['receipt'];
			}
			if(!empty($result['bill_number'])) {
				$print .=  "Bill No. : ".$result['bill_number'];
			} 
		$print .= '</td><td style="border:1px solid">';
			$print .= $result['receivedby'];
			
			$print .= '-'.$result['amountby'];
		$print .= '</td><td style="border:1px solid">'.$result['notes'].'
		</td></tr>';
				
			}
			
		$monthly_balance = $total_credit - $total_debit;
		$print .= "<tr><td style='border:1px solid' colspan='4' align='right'>Total Debit</td><td style='border:1px solid'  align='right'><h3>".$total_debit."</h3></td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td></tr>";
		$print .= "<tr><td style='border:1px solid' colspan='4' align='right'>Total Credit</td><td style='border:1px solid'>-</td><td style='border:1px solid'  align='right'><h3>".$total_credit."</h3></td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td></tr>";
		$print .= "<tr><td style='border:1px solid' colspan='4' align='right'>Monthly Balance</td><td style='border:1px solid'>-</td><td style='border:1px solid'>-</td><td style='border:1px solid' align='right'><h3>".$monthly_balance."</h3></td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td><td style='border:1px solid'>&nbsp;</td></tr>";
		$print .= "</table>";
		$pdf = create_pdf($print,'A4');
		echo $pdf;
		}
	}

	public function ajax_view_customer($id,$print=0) {
		$this->load->model('customer_model');
		$c_info = $this->customer_model->get_customer_details('id',$id);
		$html = "";
		//print_r($print);
		if($print == 1) {
			$cname = $c_info->companyname ? $c_info->companyname : $c_info->name;
			$html .= '<table width="40%" align="center" border="0">
					<tr>
						<td>
							<strong>Name : '.$cname.'</strong>
							<p>
								'.$c_info->add1.',<br>
								'.$c_info->add2.',<br>
								'.$c_info->city.',<br>
								'.$c_info->state.',<br>
								'.$c_info->pin.'<br>
								Mobile : ' .$c_info->mobile.'<br>
								Email Id : ' .$c_info->emailid.'<br>
							</p>
						</td>
					</tr>
					</table>';
					
					$pdf = create_pdf($html,'A5');
		echo $pdf;
		die;			
		}else {
		$html .= '<table width="90%" border="1">
					<tr>
						<td align="right">Company Name : </td>
						<td>'.$c_info->companyname.'</td>
						<td align="right">	Mobile : </td>
						<td>'.$c_info->mobile.'</td>
					</tr>
					<tr>
						<td align="right">Contact Person Name : </td>
						<td>'.$c_info->name.'</td>
						<td align="right">	Mobile : </td>
						<td>'.$c_info->officecontact.'</td>
					</tr>
					<tr>
						<td align="right">Email Id : </td>
						<td>'.$c_info->emailid.'</td>
						<td align="right">	Other Email Id : </td>
						<td>'.$c_info->emailid2.'</td>
					</tr>
					<tr>
						<td colspan="4">
							<center>Address</center>
							<p>
								'.$c_info->add1.'<br>
								'.$c_info->add2.'<br>
								'.$c_info->city.'<br>
								'.$c_info->state.'<br>
								'.$c_info->pin.'<br>
							</p>
						</td>
					</tr>
					</table>';
					echo $html;
					die;
				}
	}
	
	public function ajax_check_receipt($rnum) {
		echo check_receipt_num($rnum);
	}
	
	public function ajax_task_reply() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$data['reply'] = $this->input->post('reply');
			$data['status'] = $this->input->post('status');
			$data['modified'] = date('Y-m-d H:i:s');
			$data['reply_from'] = $this->session->userdata['user_id'];
			
			$this->load->model('task_model');
			$status = $this->task_model->update_task($id,$data);
			echo "done";die;
		}
	}

	public function ajax_book_delete()
	{
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('book_model');
			$status = $this->book_model->deleteBook($id);
			echo "done";die;
		}
	}
	
	public function ajax_task_delete() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('task_model');
			$status = $this->task_model->delete_task($id);
			echo "done";die;
		}
	}

	public function ajax_mask_delete() {
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('job_model');
			$status = $this->job_model->deleteMask($id);
			echo json_encode(array( 
				'status' 	=> true,
			));
			die();
		}
		echo json_encode(array( 
			'status' 	=> false,
		));
	}
	
	public function set_schedule() {
		if($this->input->post()) {
			$data['title'] = $this->input->post('title');
			$data['description'] = $this->input->post('description');
			$data['reminder_time'] = $this->input->post('reminder_time');
			$data['user_for'] = implode(",",$this->input->post('receiver'));
			$data['is_sms'] = $this->input->post('is_sms');
			$data['user_creator'] = $this->session->userdata('user_id');
			$this->load->model('task_model');
			$this->task_model->save_scheduler($data);
			die("Done");
			
		}
	}
	
	public function check_notifications() {
		$this->load->model('task_model');
		$user_id = $this->session->userdata('user_id');
		$result = $this->task_model->get_all_schedules($user_id);
		
		/*$today = strtotime('today 14:30');
		$now =  strtotime('now');
		$today = ($today * 10 ) + 10000;
		
		if($today >= $now || $today <= $now)
		{
			echo 'Please Check Delivery Jobs !';
			die;
		}*/
		
		if($result['count'] > 0 ) {
			echo $result['task'];
		} else {
			echo 0;
		}
		die;
	}
	
	public function generaeAjaxCuttingSlip($jobId = null)
	{
		if($jobId)
		{
			$this->load->model('job_model');
			$jobData 			= $this->job_model->get_job_data($jobId);
			$jobDetails 		= $this->job_model->get_job_details($jobId);
			$customerDetails 	= $this->job_model->get_customer_details($jobData->customer_id);
			$cutting_info 		= $this->job_model->get_cutting_details($jobId);
			$created_info 		= get_user_by_param('id', $jobData->user_id);
			$isContinue 		= '';

			$cOther = '';
			$cPickup = '';

			if($jobData->is_continue == 1)
			{
				$isContinue = '<br/>Continue Parcel';
			}
			if($jobData->is_customer_waiting == 1)
			{
				$isWaiting = "CUSTOMER WAITING";
			}

			if($jobData->is_customer_waiting == 2)
			{
				$isWaiting = "CUSTOMER ON THE WAY";
			}


			$pcontent = "";
			$sr=0;
		
			foreach($cutting_info as $cutting) {
				
				
			$cuttingBlock = $cornerBlock = $laserBlock = $laminationBlock = $bindingBlock = '';

			$pcontent .= '<center><h3>Total Jobs : '.$jobData->sub_jobs.'</h3></center><table align="center" align="center" style="border:1px solid; width: 450px;" width="500px">
						<tr>
							<td style="font-size: 15px; width: 85%;" align="left" width="85%">Customer Name : '.$customerDetails->companyname.'</td>
							<td style="font-size: 15px;" align="right" width="15%"> <strong>'.$jobData->id.'</strong>
							</td>
							<td width="50px">&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" style="font-size: 14px;" align="left">Job Name : <strong>'.$jobData->jobname.'</strong></td>
						</tr>
						<tr>
							<td style="font-size: 12px;" align="left">'. strtoupper( $created_info->nickname ).'</td>
							<td style="font-size: 15px;" align="left" width="50%">'. date('d-m-Y H:i A', strtotime($jobData->created)).'</td>
							<td width="10%">&nbsp;&nbsp;</td>
						</tr></table>';

			$pcontent .='<table align="center" border="2" width="80%" style="border:1px solid;"><tr>';
			
				$pcontent .= '<td>
							<table align="center" border="2" width="550px" style="border:1px solid;">';
				
				if(!empty($cutting['c_material'])) {
					$c_m_label = "Material";
					if($cutting['c_material'] == "ROUND CORNER CUTTING") {
							$c_m_label = "";
					}	
				}

				/** Machine

				<tr>
					<td   style="width: 100px; font-size:16px;" align="right"> Machine : </td>
					<td style="font-size:16px;"> '.$cutting['c_machine'].' </td>
				</tr>

				<tr>
									<td style="font-size:16px;" align="right"> ' .$c_m_label. ' : </td>
									<td style="font-size:16px;"> '.$cutting['c_material'].' </td>
								</tr>
				**/
				$cuttingBlock .= '<table width="400px" align="center" border="1">
								<tr>
									<td colspan="2" style="font-size: 16px;">
										<strong>Cutting Details</strong>
									</td>
								</tr>
								
								<tr>
									<td width="50%"  style="font-size:16px;" > Quantity : '.$cutting['c_qty'].' </td>
									<td width="20%"  style="font-size:16px;" align="right"> Total Sheets: '.$cutting['c_sheet_qty'].' </td>
								</tr>
								<tr>
									<td colspan="2">
										<table border="1">
											<tr>
												<td width="33%" style="font-size:16px;" align="left"> 
													Size : '. $cutting['c_size'] .'
												</td>

												<td width="33%"  style="font-size:16px;" align="center"> 
													Print : '. $cutting['c_print'] .'
												</td>

												<td width="33%"  style="font-size:16px;" align="left"> 
													Cutting Details : '. $cutting['c_sizeinfo'] .'
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';
				
				if(strtolower($cutting['c_corner']) !== 'no' && strlen($cutting['c_corner']) > 2)
				{
					if(!empty($cutting['c_corner']) || !empty($cutting['c_cornerdie']) || !empty($cutting['c_rcorner']))
					{
						$cornerBlock .= '<table width="500px" align="center" border="1">
										<tr>
											<td colspan="6"  style="font-size:16px;">
												<strong>Corner Cutting Details</strong>
											</td>
										</tr><tr>';
										
										if(!empty($cutting['c_corner'])) {
											$cornerBlock .= '<td  style="width: 100px; font-size: 16px;" align="right"> Corner Cut : </td>
												<td  style="font-size:24px;"><strong> '.$cutting['c_corner'] .' </strong></td>';	
										}
										
										if(!empty($cutting['c_cornerdie'])) {
											$cornerBlock .= '<td  style="font-size:16px;" align="right"> Corner Die : </td>
											<td style="font-size:24px;"><strong> '.$cutting['c_cornerdie'] .'</strong> </td>';	
										}
										
										if(!empty($cutting['c_rcorner'])) {
											$cornerBlock .= '<td  style="font-size:16px;" align="right"> Round Side : </td>
											<td style="font-size:24px;"> <strong>'.$cutting['c_rcorner'] .' </strong></td>';	
										}
						$cornerBlock .=	'</tr></table>';
					} 
				}
				
				if(!empty($cutting['c_laser']))
				{
					$laserBlock .= '<table width="500px"  align="center" border="1">
									<tr>
										<td colspan="4"  style="font-size:16px;">
											<strong>Laser Cutting</strong>
										</td>
									</tr>';
									
									if(!empty($cutting['c_laser']))
									{
									$laserBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Laser Cut : </td>
											<td style="font-size:16px;"> '.$cutting['c_laser'] .' </td>
										</tr>';
									}
					$laserBlock .= '</table>';
				}
				
				if(!empty($cutting['c_lamination']) || !empty($cutting['c_laminationinfo']))
				{
					$laminationBlock .= '<table width="500px" align="center" border="1">
									<tr>
										<td colspan="2"  style="font-size:16px;">
											<strong>Lamination Details</strong>
										</td>
									</tr><tr>';
									
									if(!empty($cutting['c_lamination']))
									{
										$laminationBlock .= '<td style="width:100px; font-size: 16px;" align="right"> Lamination : </td>
											<td style="font-size:16px;"> '.$cutting['c_lamination'] .' </td>';
									}
									
									if(!empty($cutting['c_laminationinfo']))
									{
										$lCutting = $cutting['c_lamination_cutting'] == 1 ? '': '| NO CUTTING';
										$laminationBlock .= '<td style="width:100px; font-size: 16px;" align="right">Info: </td>
										<td style="font-size:16px;"> '.$cutting['c_laminationinfo']. ' <b>' . $lCutting.'</b> </td>';
									}
									
					$laminationBlock .= '</tr></table>';
				}
					
				if(!empty($cutting['c_binding']) || !empty($cutting['c_bindinginfo']))
				{
					$bindingBlock .= '<table width="500px" align="center" border="1">
									<tr>
										<td colspan="2"  style="font-size:16px;">
											<strong>Binding Details</strong>
										</td>
									</tr>';
										
									if(!empty($cutting['c_binding']))
									{
										$bindingBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Binding Detaiils : </td>
											<td style="font-size:16px;"> '.$cutting['c_binding']  .' </td>
										</tr>';
									}

									if(!empty($cutting['c_blade_per_sheet']))
									{
										$bindingBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Blade Per Sheet : </td>
											<td style="font-size:16px;"> '.$cutting['c_blade_per_sheet']  .' </td>
										</tr>';
									}
									if(!empty($cutting['c_bindinginfo']))
									{
										$bindingBlock .= '<tr>
											<td style="width:100px; font-size: 16px;" align="right"> Extra Details : </td>
											<td style="font-size:16px;"> '.$cutting['c_bindinginfo']  .' </td>
										</tr>';
									}
									
					$bindingBlock .= '</table>';
				}
				
				if(strlen($cuttingBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$cuttingBlock.'</td></tr>';
					//$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}

				if(isset($cutting['c_box_box']) && $cutting['c_box_box'] == 'Yes')
				{
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">BOX : </td><td style="font-size:16px;"><strong> YES </strong></td></tr>';
				}

				if(isset($cutting['c_box_dubby']) && $cutting['c_box_dubby'] == 'Yes')
				{
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Dubby : </td><td style="font-size:16px;"><strong> YES </strong></td></tr>';
				}

				if(isset($cutting['c_box_dubby']) && strtolower($cutting['c_box_dubby']) == 'no')
				{
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Dubby : </td><td style="font-size:16px;"><strong> NO </strong></td></tr>';
				}

				if(isset($cutting['c_corner']) && $cutting['c_corner'] == 'Yes')
				{
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Corner Cutting: </td><td style="font-size:16px;"><strong> YES </strong></td></tr>';
				}

				if(isset($cutting['c_corner']) && strtolower($cutting['c_corner']) == 'no')
				{
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Corner Cutting: </td><td style="font-size:16px;"><strong> NO </strong></td></tr>';
				}
				
				if(strlen($cornerBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$cornerBlock.'</td></tr>';
					//$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}
				
				if(strlen($laserBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$laserBlock.'</td></tr>';
					//$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}
				
				if(strlen($laminationBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$laminationBlock.'</td></tr>';
					//$pcontent .= '<tr><td colspan="2"><br></td></tr>';
				}
				
				if(strlen($bindingBlock) > 1 )
				{
					$pcontent .= '<tr><td colspan="2">' .$bindingBlock.'</td></tr>';
				}
				
				if(!empty($cutting['c_details'])) {
					$pcontent .= '<tr><td colspan="2" style="font-size:16px;"><strong> '.$cutting['c_details'].'</strong></td></tr>';
				}
				
				if(!empty($cutting['c_packing'])) {
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Packing Details : </td><td style="font-size:16px;"><strong>'.$cutting['c_packing'].'</strong></td></tr>';
				}

				if(!empty($cutting['c_packing_other_details'])) {
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Special Note: </td><td style="font-size:16px;">'.$cutting['c_packing_other_details'].'</td></tr>';
				}

				if(!empty($cutting['c_pickup_details'])) {
					$pcontent .= '<tr><td style="width:40px; font-size: 16px;">Pickup (Time): </td><td style="font-size:16px;">'.$cutting['c_pickup_details'].'</td></tr>';
				}

			
				$pcontent .= '</table> </td>';
				$pcontent .= '</tr></table>';
				$sr++;
				
				if(isset($cutting_info[$sr]))
				{
					$pcontent .= "<pagebreak />";
				}
			}

			
			if($isWaiting != '' || $isContinue != '')
			{
				$pcontent .= '<table align="center" align="center" style="border:1px solid; width: 450px;" width="500px"><tr><td align="center" style="font-size: 45px;">' . $isWaiting . $isContinue .'</td></tr></table>';
			}

			$isPorter = '';

			if(isset($jobData->cyb_porter) && $jobData->cyb_porter == 1)
			{
				$isPorter .= '<br /><h3 style="font-size: 20px;">Porter</h3>';
				$isPorter .= '<p style="font-size: 14px;">Address: '. $jobData->cyb_porter_details .'</p>';
				$isPorter .= '<p style="font-size: 14px;">Mobile: '. $jobData->cyb_porter_mobile .'</p>';
				$isPorter .= '<p style="font-size: 14px;">Pay By: '. $jobData->cyb_porter_pay .'</p>';
				$pcontent .= '<br /><table style="border:1px solid; width: 550px;">
					<tr>
					<td>' . $isPorter .
					'</td>
					</tr>
				</table>';
			}
			

			//pr($pcontent);
			$pdfLink = create_pdf($pcontent, 'A5');
			
			echo json_encode(array( 
				'status' 	=> true,
				'link' 		=> $pdfLink
			));
			die();
		}
		
		echo json_encode(array( 
				'status' 	=> false,
				'message'  	=> "Unable to Crete PDF"
			));
		die;
	}
	
	public function getOutstationTransporterName($customerId)
	{
		$this->load->model('customer_model');
		$transporter = $this->customer_model->getTransporterDetailsByCustomerId($customerId);
		
		if($transporter)
		{
			echo json_encode(array(
				'status' => true,
				'transporter' => $transporter
			));
			
			die;
		}
		
		echo json_encode(array(
				'status' => false
			));
		die;
	}
	
	public function ajax_add_billnumber($jobId)
	{
		
		if($this->input->post()) 
		{
			$billNumber = $this->input->post('billNumber');
			
			$this->load->model('job_model');

			if(strlen($billNumber) > 2)
			{
				addBillToJobClearDueAmount($jobId, $billNumber);
				
			
				$status = $this->job_model->addJobBillNumber($jobId, $billNumber);
				
				if($status)
				{
					echo json_encode(array(
						'status' => true
					));
				
				die;
			}
			
		}
		
		echo json_encode(array(
				'status' => false
			));
		die;
		}
	}
		
		
	public function getJobsWithoutBill($customerId = null)
	{
			if($customerId)
			{
				$this->load->model('job_model');
				$jobs = $this->job_model->getJobsWithoutBill($customerId);
				
				if($jobs)
				{
					echo json_encode(array(
						'status' 	=> true,
						'jobs' 		=> $jobs
					));
					
					die;
				}
			}
			
			echo json_encode(array(
				'status' => false
			));
			die;
	}
	
	public function setBillForSelectedJobs()
	{
		if($this->input->post())
		{
			$jobIds = $this->input->post('jobIds');
			$billNumber = $this->input->post('billNumber');
			$customerId = $this->input->post('customerId');
			$this->load->model('job_model');
			
			$sr = 0;
			foreach($jobIds as $jobId)
			{
				$jobData = array(
					'bill_number' => $billNumber
				);
				$this->job_model->update_job($jobId, $jobData);
				addBillToJobClearDueAmount($jobId, $billNumber);
				$sr++;
			}
			
			echo json_encode(array(
					'status' 	=> true,
					'process' 	=> $sr
			));
			die;
		}
		
		echo json_encode(array(
				'status' => false
			));
			die;
	}
	
	public function delieveredJobSuccess()
	{
		if($this->input->post())
		{
			$jobId 			= $this->input->post('jobId');
			$customDelivery = $this->input->post('customDelivery');

			$this->load->model('job_model');
			$jobData = array(
				'is_delivered' => 1,
				'custom_delivery' => $customDelivery
			);
			$this->job_model->update_job($jobId, $jobData);
			
			echo json_encode(array(
				'status' => true
			));
			die;
		}
		
		echo json_encode(array(
				'status' => false
			));
			die;
	}
	
	public function ajax_add_discount($jobId = null)
	{
		if($jobId)
		{
			$discount = $this->input->post('discountAmount');
			$customerId = $this->input->post('customerId');
			
			$data = array(
				'customer_id' 	=> $customerId,
				'job_id' 		=> $jobId,
				'amount'		=> $discount,
				't_type'		=> 'credit',
				'notes'			=> 'Apply Discount',
				'creditedby'	=> $this->session->userdata['user_id'],
				'cmonth' 		=> date('M-Y'),
				'date'			=> date('Y-m-d')
			);
			$this->load->model('job_model');
			
			$jobData = array(
				'discount' => $discount
			);
			$this->job_model->update_job($jobId, $jobData);
			
			$status = $this->job_model->insert_transaction($data);
			
			if($status)
			{
			echo json_encode(array(
					'status' => true
				));
			
			die;
			}
		}
		
		echo json_encode(array(
				'status' => false
			));
		die;
	}

	public function reschedule_timer()
	{
		if($this->input->post())
		{
			$id = $this->input->post('id');	
			
			$data = array(
				'reminder_time' => $this->input->post('value'),
				'status' 		=> 0
			);
			
			$this->load->model('task_model');
			$status = $this->task_model->update_schedule($id,$data);

			if($status)
			{
				echo json_encode(array(
					'status' => true
				));
			
			die;	
			}
		}

		echo json_encode(array(
				'status' => false
			));
		die;	
	}

	public function update_cutting_slip()
	{

		if($this->input->post())
		{
			$cuttingId = $this->input->post('id');


			$updateData = array(
				'c_machine' 		=> $this->input->post('machine'),
				'c_size' 			=> $this->input->post('size'),
				
				'c_material' 		=> $this->input->post('materialInfo'),
				'c_qty' 			=> $this->input->post('cardQty'),
				
				'c_sizeinfo' 		=> $this->input->post('sizeinfo'),
				'c_print' 			=> $this->input->post('printing'),
				'c_corner'			=> $this->input->post('corner'),
				'c_laser' 			=> $this->input->post('laserCut'),
				'c_rcorner' 		=> $this->input->post('roundcorner'),
				'c_cornerdie' 		=> $this->input->post('cornerDie'),
				'c_details' 		=> $this->input->post('details'),
				'c_lamination' 		=> $this->input->post('lamination'),
				'c_laminationinfo' 	=> $this->input->post('laminationDetail'),
				'c_binding' 		=> $this->input->post('binding'),
				'c_bindinginfo' 	=> $this->input->post('bindingInfo'),
				'c_blade_per_sheet' => $this->input->post('bladePerSheet')
			);

			$this->load->model('job_model');
			$status = $this->job_model->update_cutting_details($cuttingId, $updateData);
				
			if($status)
			{
				echo json_encode(array(
					'status' => true
				));	
				exit;
			}
		}
	
		echo json_encode(array(
			'status' => false
		));
		die;	
	}

	public function send_address()
	{
		if($this->input->post())
		{
			$sms_message = $this->input->post('sms_message');
			$mobile = $this->input->post('sms_mobile');
			
			echo $sms_mobile . "<br>";
			$msg = str_replace(" ","+",$sms_message);
			$msg = str_replace("&", "%26", $msg);
			$url = "http://sms.infisms.co.in/API/SendSMS.aspx?UserID=cyberabill&UserPassword=cybSat19&PhoneNumber=$mobile&Text=$msg&SenderId=CYBERA&AccountType=2&MessageType=0";
			$url = urlencode($url);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, urldecode($url));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
			$response = curl_exec($ch);
			curl_close($ch);
			
			//send_sms(NULL, 0,$sms_mobile,$sms_message);
			echo $sms_message;
		}
		return true;
	}

	public function send_feedback()
	{
		if($this->input->post())
		{
			$sms_message = $this->input->post('sms_message');
			$mobile = $this->input->post('sms_mobile');

			echo $sms_mobile . "<br>";
			$msg = str_replace(" ","+",$sms_message);
			$msg = str_replace("&", "%26", $msg);
			$msg = str_replace(",", "%2C", $msg);
			$msg = urlencode($msg);
			/*$url = "http://sms.infisms.co.in/API/SendSMS.aspx?UserID=cyberabill&UserPassword=cybSat19&PhoneNumber=$mobile&Text=$msg&SenderId=CYBERA&AccountType=2&MessageType=0";*/
			
			$url = "http://sms.infisms.co.in/API/SendSMS.aspx?UserID=cyberabill&UserPassword=cybSat19&PhoneNumber=$mobile&Text=Valuable%20Customer%2C%20%0ACYBERA%20is%20seeking%20your%20precious%20feedback%2C%20kindly%20rate%20us%20on%20http%3A%2F%2Fbit.ly%2F2z6bxpo%20for%20better%20products%20and%20services%20THANK%20YOU%20CYBERA%20PRINT%20ART&SenderId=CYBERA&AccountType=2&MessageType=0";
			$url = urlencode($url);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, urldecode($url));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
			$response = curl_exec($ch);
			curl_close($ch);
			
			//send_sms(NULL, 0,$sms_mobile,$sms_message);
			echo $sms_message;
		}
		return true;
	}

	public function get_customer_book_info()
	{
		if($this->input->post())
		{
			$customerId = $this->input->post('cutomerId');
			$bookTitle  = $this->input->post('bookTitle');
			
			$this->load->model('book_model');

			$status = $this->book_model->getBookInfoByCutomerId($customerId, $bookTitle);

			if($status)
			{
				echo json_encode(array(
					'status' => true
				));	
				exit;
			}
		}
	
		echo json_encode(array(
			'status' => false
		));
		die;	
	}

	public function send_reminder()
	{
		if($this->input->post())
		{
			$name 		= $this->input->post('customrName');
			$balance 	= abs($this->input->post('balance'));
			$mobile 	= $this->input->post('mobile');
			$messageO 	= "Dear $name Gentle reminder for overdue outstanding of rs $balance Expecting it at the earliest. CYBERA";

			$message = str_replace(" ","+",$messageO);
			send_sms(NULL, 0,$mobile,$message);
			
			/*$url = "http://ip.infisms.com/smsserver/SMS10N.aspx?Userid=cyberabill&UserPassword=cyb123&PhoneNumber=$mobile&Text=$msg&GSM=CYBERA";
			
			$url = urlencode($url);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, urldecode($url));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
			$response = curl_exec($ch);
			curl_close($ch);*/
			
			//send_sms(NULL, 0,$sms_mobile,$sms_message);
			echo $messageO;
		}	
	}

	public function reset_account_dates()
	{
		if($this->input->post())
		{
			$startDate 	= $this->input->post('startDate');
			$endDate 	= $this->input->post('endDate');

			$dateData['start_date'] = $startDate;
			$dateData['end_date'] 	= $endDate;
			$this->session->set_userdata($dateData);
			
			echo json_encode(array(
				'status' => true
			));
			die;			
		}

		echo json_encode(array(
			'status' => false
		));
		die;			
	}

	public function get_customer_transporter()
	{	
		$this->load->model('job_model');
		$userId 	= $this->input->post('userId');
		$transporter = $this->job_model->getUserTransporters($userId);
		$data[] 	= [
			'id' 	=> 0,
			'name' 	=>  'Please Select Transprter'
		];

		if(isset($transporter) && count($transporter))
		{
			foreach($transporter as $t)
			{
				if(strlen($t['name']) > 0)
				{

					$data[] = [
						'id' 	=> $t['id'],
						'name' 	=> $t['name']
					];
				}
			}
		}

		if(isset($data) && count($data))
		{
			echo json_encode(array(
				'status' => true,
				'transporters' => $data
			));
			die;			
			
		}
		

		echo json_encode(array(
			'status' => false
		));
		die;
		
	}	

	public function resetCustomerBlockStatus()
	{
		if($this->input->post()) 
		{
			$this->load->model('customer_model');

			$customerId = $this->input->post('customerId');
			$data['is_block'] = $this->input->post('block');
			
			$status = $this->customer_model->update_customer($customerId, $data);

			if($status)
			{
				echo json_encode(array(
					'status' => true,
					'message' => $data['is_block'] == 1 ? 'User Blocked Successfully' : 'User Unblocked Successfully'
				));
				die();
			}

		}
		echo json_encode(array(
			'status' => false,
			'message' => 'Something Went Wrong !'
		));
		die();
	}

	public function resetCustomerRevisionStatus()
	{
		if($this->input->post()) 
		{
			$this->load->model('customer_model');

			$customerId = $this->input->post('customerId');
			$data['under_revision'] = $this->input->post('revision');
			
			$status = $this->customer_model->update_customer($customerId, $data);

			if($status)
			{
				echo json_encode(array(
					'status' => true,
					'message' => $data['is_block'] == 1 ? 'User Added Under Revision Successfully' : 'User Removed From Revision Successfully'
				));
				die();
			}

		}
		echo json_encode(array(
			'status' => false,
			'message' => 'Something Went Wrong !'
		));
		die();
	}

	public function getEmployeeBasicDetails()
	{
		if($this->input->post())
		{
			$this->load->model('employee_model');
			$employeeId = $this->input->post('empId');
			$employee = $this->employee_model->getEmployeeById($employeeId);
			
			if($employee)
			{
				echo json_encode(array(
					'status'	=> true,
					'result' 	=> $employee
				));
				
				die;
			}
		}
		
		echo json_encode(array(
			'status' => false,
			'message' => 'Unable to find an Employee'
		));
		
		die;
	}

	public function getEmployeeAttendanceDetails()
	{
		if($this->input->post())
		{
			$this->load->model('attendance_model');
			$employeeId = $this->input->post('empId');
			$startDate 	= $this->input->post('startDate');
			$endDate 	= $this->input->post('endDate');
			$attendance = $this->attendance_model->getEmpAttendanceByIdBetween($employeeId, $startDate, $endDate);
			
			if($attendance)
			{
				echo json_encode(array(
					'status'	=> true,
					'result' 	=> $attendance
				));
				
				die;
			}
		}
		
		echo json_encode(array(
			'status' => false,
			'message' => 'Unable to find an Employee Attendance'
		));
		
		die;
	}

	public function getEmployeeTransactionDetails()
	{
		if($this->input->post())
		{
			$this->load->model('employee_transaction_model');
			$employeeId = $this->input->post('empId');
			$startDate 	= $this->input->post('startDate');
			$endDate 	= $this->input->post('endDate');
			$records 	= $this->employee_transaction_model->getEmpTransactionsByIdBetween($employeeId, $startDate, $endDate);
			
			if($records)
			{
				echo json_encode(array(
					'status'	=> true,
					'result' 	=> $records
				));
				
				die;
			}
		}
		
		echo json_encode(array(
			'status' => false,
			'message' => 'Unable to find an Employee Transactions'
		));
		
		die;
	}

	public function printEmployeeAttendanceReport()
	{
		if($this->input->post())
		{
			$this->load->model('employee_model');
			$this->load->model('attendance_model');

			$empId 		= $this->input->post('empId');
			$startDate 	= $this->input->post('startDate');
			$endDate 	= $this->input->post('endDate');

			$employee 	= getSelectedEmployeeDetails($empId, $startDate, $endDate);

			//pr($employee, false);

			$attendance = $this->attendance_model->getEmpAttendanceByIdBetween($empId, $startDate, $endDate);

			//pr($attendance);
			
			$print = '<table border="2" width="100%" style="border:2px solid; width: 450px;">';
			 
				$print .= '<tr><td style="border:1px solid">Name: '.$employee->name . '</td>';
				$print .= '<td style="border:1px solid;text-align: right;">Department: '.$employee->department . '</td></tr>';

				$print .= '<tr><td style="border:1px solid">Start Date: '.$startDate . '</td>';
				$print .= '<td style="border:1px solid; text-align: right;">End Date: '.$endDate . '</td></tr>';
				

				$print .= '<tr><td colspan="2">';

					$print .= '<table border="2" style="border:2px solid; width: 500px;">';
					$print .= '<tr>';
						$print .= '<td style="width: 150px; border:1px solid">Month</td>';
						$print .= '<td style="width: 50px; border:1px solid">Half Day</td>';
						$print .= '<td style="width: 50px; border:1px solid">Full Day</td>';
						$print .= '<td style="width: 50px; border:1px solid">Late</td>';
						$print .= '<td style="width: 50px; border:1px solid">Office Half Day</td>';
						$print .= '<td style="width: 50px; border:1px solid">Half Night</td>';
						$print .= '<td style="width: 50px; border:1px solid">Full Night</td>';
						$print .= '<td style="width: 50px; border:1px solid">Sunday</td>';
						$print .= '<td style="width: 250px; border:1px solid">Notes</td>';

					$print .= '</tr>';

				$totalHalf 		= 0;
				$totalFull 		= 0;
				$totalLate 		= 0;
				$totalOHalf 	= 0;
				$totalHNight	= 0;
				$totalFNight 	= 0;
				$totalSunday 	= 0;

				foreach($attendance as $att)
				{
					$totalHalf 		= $totalHalf + $att['half_day'];
					$totalFull 		= $totalFull + $att['full_day'];
					$totalLate 		= $totalLate + $att['office_late'];
					$totalOHalf 	= $totalOHalf + $att['office_halfday'];
					$totalHNight	= $totalHNight + $att['half_night'];
					$totalFNight 	= $totalFNight + $att['full_night'];
					$totalSunday 	= $totalSunday + $att['sunday'];

					$print .= '<tr>';
						
						$print .= '<td style="width: 150px; border:1px solid;">' . $att['month'] . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $att['half_day'] . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $att['full_day'] . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $att['office_late'] . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $att['office_halfday'] . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $att['half_night'] . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $att['full_night'] . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $att['sunday'] . '</td>';
						$print .= '<td style="width: 250px; border:1px solid">' . $att['notes'] . '</td>';
					$print .= '</tr>';
				}

					$print .= '<tr>';
						
						$print .= '<td style="width: 150px; border:1px solid;">-</td>';
						$print .= '<td style="width: 50px; border:1px solid"; text-align:center;><center>' . $totalHalf . '</center></td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $totalFull . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $totalLate . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $totalOHalf . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $totalHNight . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $totalFNight . '</td>';
						$print .= '<td style="width: 50px; border:1px solid; text-align:center;">' . $totalSunday . '</td>';
						$print .= '<td style="width: 250px; border:1px solid; text-align:center;">  - </td>';
					$print .= '</tr>';
					
					$print .= '</table>';

				$print .= '</td></tr>';

			$print .= '</table>';

			
			$pdf = create_pdf($print,'A4');
			
			if($employee)
			{
				echo json_encode(array(
					'status'	=> true,
					'result' 	=> $pdf
				));
				
				die;
			}
		}
		
		echo json_encode(array(
			'status' => false,
			'message' => 'Unable to find an Employee'
		));
		
		die;		
	}


	public function pinJob()
	{
		if($this->input->post()) {

			$jobId = $this->input->post('jobId');
			$isPin = $this->input->post('isPin');

			$this->load->model('job_model');

			$status = $this->job_model->pinJob($jobId, $isPin);

			if($status)
			{
				echo json_encode(array(
					'status' => true
				));
				
				die;	
			}
		}		

		echo json_encode(array(
			'status' 	=> false,
			'message' 	=> 'Unable to Set PIN Job'
		));
		
		die;		
	}

	public function ajax_pending_jobs()
	{
		$all = $this->input->post('all');
		$data['jobs'] = 'test';
		$this->load->model('job_model');
		$data = array();
		if(isset($all) && $all == 1)
		{
			$data['jobs'] = $this->job_model->get_dashboard_details();
			$data['title'] = "Dashboard List : " . date('m-d-y H:i:s');
		}
		else
		{
			$data['jobs'] = $this->job_model->get_dashboard_pending_details();
			$data['title'] = "Pending List : " . date('m-d-y H:i:s');
		}
		$html = $this->load->view('user/print-list', $data, true);
		$pdfFile = create_pdf($html, 'A4');

		echo $pdfFile;
	}

	public function saveCustomerLocation()
	{
		if($this->input->post()) 
		{
			$data = $this->input->post();
			$this->load->model('address_model');

			$locationData = array(
				'customer_id'	=> $data['customerId'],
				'location_name'	=> $data['name'] ? $data['name'] : $data['companyname'],
				'mobile'		=> $data['mobile'] ? $data['mobile'] : '',
				'email'			=> $data['email'] ? $data['email'] : '',
				'add1'			=> $data['add1'] ? $data['add1'] : '',
				'add2'			=> $data['add2'] ? $data['add2'] : '',
				'city'			=> $data['city'] ? $data['city'] : '',
				'state'			=> $data['state'] ? $data['state'] : '',
				'pin'			=> $data['pin'] ? $data['pin'] : '',
			);

			$status = $this->address_model->insert_data($locationData);

			if($status)
			{
				echo json_encode(array(
					'status' => true
				));
				exit;
			}
			
			echo json_encode(array(
					'status' => false
				));
			exit;
		}		
	}


	public function setDefaultAddress()
	{
		if($this->input->post()) 
		{
			$data = $this->input->post();
			$this->load->model('address_model');

			if(isset($data['customerId']) && isset($data['addressId']))
			{
				$status = $this->address_model->setDefault($data['customerId'], $data['addressId']);

				if($status)
				{
					echo json_encode(array(
						'status' => true
					));
					exit;
				}
			}
			
			echo json_encode(array(
					'status' => false
				));
			exit;
		}			
	}

	public function deleteAddress()
	{
		if($this->input->post()) 
		{
			$data = $this->input->post();
			$this->load->model('address_model');

			if(isset($data['customerId']) && isset($data['addressId']))
			{
				$status = $this->address_model->deleteAddress($data['customerId'], $data['addressId']);

				if($status)
				{
					echo json_encode(array(
						'status' => true
					));
					exit;
				}
			}
			
			echo json_encode(array(
					'status' => false
				));
			exit;
		}				
	}

	public function createOutStationJob()
	{
		if($this->input->post()) 
		{
			$data 	= $this->input->post();
			$input 	= $data['inputs'];
			$inputData = [];
			$detailData = [];

			foreach($input as $jobInput)
			{
				if($jobInput['name'] == 'token')
				{
					$inputData['job_token'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'location')
				{
					$inputData['location_name'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'person')
				{
					$inputData['person'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'charges')
				{
					$inputData['total'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'outJobId'  && $jobInput['value'] != 0)
				{
					$inputData['job_id'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'outJobCustomerId' && $jobInput['value'] != 0)
				{
					$inputData['customer_id'] = $jobInput['value'];
				}

				if(strpos($jobInput['name'], 'out') !== false)
				{
					$key = substr($jobInput['name'], 4, -1);

					$detailData[$key][] = $jobInput['value'];
				}
			}

			if(is_array($inputData) && count($inputData))
			{
				$this->load->model('out_model');

				$outJobId = $this->out_model->create($inputData);
				
				if($outJobId)
				{
					$masterData = [];

					for($i = 0; $i < count($detailData['size']); $i++)
					{
						$masterData[] = [
							'out_id' 	=> $outJobId,
							'out_location'	=> isset($detailData['out_location'][$i]) && !empty($detailData['out_location'][$i]) ? $detailData['out_location'][$i] : '',
							'out_size'	=> $detailData['size'][$i],
							'out_type'	=> $detailData['lamination_type'][$i],
							'out_side'	=> $detailData['lamination_side'][$i],
							'out_qty'	=> $detailData['qty'][$i],
							'out_notes'	=> $detailData['notes'][$i],
							'created_at'=> date('Y-m-d H:i:s')
						];
					}

					$status = $this->out_model->insertDetails($masterData);
				}

				if($outJobId)
				{
					echo json_encode(array(
						'status' => true
					));
					exit;
				}
			}

			echo json_encode(array(
					'status' => false
				));
			exit;
		}				
	}

	public function updateOutStationJob()
	{
		if($this->input->post()) 
		{
			$this->load->model('out_model');

			$data 	= $this->input->post();
			$outId 	= $this->input->post('outId');
			$outJob = false;

			if($outId)
			{
				$outJob = $this->out_model->isExists($outId);
			}

			$input 	= $data['inputs'];

			$inputData = [];
			$detailData = [];

			foreach($input as $jobInput)
			{
				if($jobInput['name'] == 'token')
				{
					$inputData['job_token'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'location')
				{
					$inputData['location_name'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'person')
				{
					$inputData['person'] = $jobInput['value'];
				}

				if($jobInput['name'] == 'charges')
				{
					$inputData['total'] = $jobInput['value'];
				}

				

				if(strpos($jobInput['name'], 'out') !== false)
				{
					$key = substr($jobInput['name'], 4, -1);

					$detailData[$key][] = $jobInput['value'];
				}
			}

			if(is_array($inputData) && count($inputData))
			{
				if($outJob)
				{
					$status = $this->out_model->update($outJob->id, $inputData);

					if(1 == 1)
					{
						$this->out_model->flushDetails($outJob->id);
					}

					$outJobId 	= $outJob->id;
				}	
				else
				{
					$outJobId = $this->out_model->create($inputData);
				}
				
				if($outJobId)
				{
					$masterData = [];

					for($i = 0; $i < count($detailData['size']); $i++)
					{
						$masterData[] = [
							'out_id' 	=> $outJobId,
							'out_location'	=> isset($detailData['out_location'][$i]) && !empty($detailData['out_location'][$i]) ? $detailData['out_location'][$i] : '',
							'out_size'	=> $detailData['size'][$i],
							'out_type'	=> $detailData['lamination_type'][$i],
							'out_side'	=> $detailData['lamination_side'][$i],
							'out_qty'	=> $detailData['qty'][$i],
							'out_notes'	=> $detailData['notes'][$i],
							'created_at'=> date('Y-m-d H:i:s')
						];
					}

					$status = $this->out_model->insertDetails($masterData);
				}

				if($outJobId)
				{
					echo json_encode(array(
						'status' => true
					));
					exit;
				}
			}

			echo json_encode(array(
					'status' => false
				));
			exit;
		}				
	}

	public function generateOutJob($jobId = null)
	{
		if($jobId)
		{
			$this->load->model('out_model');
			
			$data['jobInfo'] 	= $this->out_model->checkOutside($jobId);
			$data['jobDetails'] = $this->out_model->getJobAdditionalDetails($data['jobInfo']->{id});

			$html 		= $this->load->view('common/out_job.php', $data, true);
			//pr($html);
			$pdfFile 	= create_pdf($html, 'A5');

			echo json_encode(array(
				'status' => true,
				'link'	 => $pdfFile
			));
			die;
		}

		echo json_encode(array(
			'status' => false,
		));
		die;
	}

	public function ajax_print_attendance()
	{
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$pdfTitle = $this->input->post('title');
		$this->load->model('attendance_model');
		$data = array();
		
		$data['items'] = $this->attendance_model->getAllAttendance();
		$data['title'] = "Attendance List : " . $month . ' ' . $year;
		$data['pdfTitle'] = !empty($pdfTitle) ? $pdfTitle : '';
		
		$html = $this->load->view('attendance/print-list', $data, true);
		$pdfFile = create_pdf($html, 'A4-L');

		echo $pdfFile;
	}

	public function ajax_menu_delete()
	{
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('menu_model');
			$status = $this->menu_model->softDeleteMenu($id);
			echo json_encode([
				'status' => 1
			]);
			die;
		}		
	}


	public function ajax_menu_update()
	{
		if($this->input->post()) {
			$input = $this->input->post();
			$this->load->model('menu_model');
			if($this->menu_model->updateMenu($input))
			{
				echo json_encode([
					'status' => 1
				]);
				die;
			}
		}	
	}

	public function ajax_menu_add()
	{
		if($this->input->post()) 
		{
			$data = array(
				'code' 			=> $this->input->post('code'),
				'short_name' 			=> $this->input->post('short_name'),
				'title'  		=> $this->input->post('title'),
				'price'  		=> $this->input->post('price'),
				'qty'  			=> $this->input->post('qty'),
				'extra'  		=> $this->input->post('extra'),
				'working_days'  		=> $this->input->post('working_days'),
				'notes'  		=> $this->input->post('notes'),
				'created_at'  => date('Y-m-d H:i:s')
			);

			$this->load->model('menu_model');
			
			if($this->menu_model->create($data))
			{
				echo json_encode([
					'status' => 1
				]);
				die;
			}
		}

		echo json_encode([
			'status' => 0
		]);
		die;	
	}

	public function ajax_print_menu_list()
	{
		$this->load->model('menu_model');
		$data = array();
		$data['menus'] = $this->menu_model->getAll();
		$data['title'] = "Menu List : " . date('m-d-y H:i:s');
		$html = $this->load->view('menu/print-list', $data, true);
		$pdfFile = create_pdf($html, 'A4-L');

		echo $pdfFile;
	}


	public function ajax_d_customer_delete()
	{
		if($this->input->post())
		{
			$this->load->model('Diwali_model');
			$this->Diwali_model->soft_delete($this->input->post('id'));
			echo json_encode([
			]);
			die();
		}		

		echo json_encode([], 400);
		die();
	}

	public function ajax_d_customer_g_update()
	{
		if($this->input->post())
		{
			$this->load->model('Diwali_model');
			$this->Diwali_model->update_gtype($this->input->post('id'), $this->input->post('gtype'));
			echo json_encode([
			]);
			die();
		}		

		echo json_encode([], 400);
		die();
	}

	public function ajax_d_customer_add()
	{
		if($this->input->post())
		{
			$this->load->model('Diwali_model');
			$this->Diwali_model->create($this->input->post());
			echo json_encode([
			]);
			die();
		}		

		echo json_encode([], 400);
		die();	
	}

	public function add_to_diwali()
	{
		if($this->input->post())
		{
			$input = $this->input->post();
			$this->load->model('Diwali_model');
			$status = $this->Diwali_model->copy_to_diwali($input['cid']);
			if($status)
			{
				echo json_encode([
				]);
				die();
			}
		}		

		echo json_encode([
			'message' => 'Already Exists'
			]);
		die();	
	}

	public function ajax_transporter_add()
	{
		if($this->input->post()) 
		{
			$data = array(
				'title'  				=> $this->input->post('title'),
				'full_address'  		=> $this->input->post('full_address'),
				'contact_number1'  		=> $this->input->post('contact_number1'),
				'contact_number2'  		=> $this->input->post('contact_number2'),
				'google_map'  			=> $this->input->post('google_map'),
				'approx_fare'  			=> $this->input->post('approx_fare'),
				'cities'  			=> $this->input->post('cities'),
			);

			$this->load->model('transport_model');
			
			if($this->transport_model->create($data))
			{
				echo json_encode([
					'status' => 1
				]);
				die;
			}
		}

		echo json_encode([
			'status' => 0
		]);
		die;			
	}

	public function ajax_transport_update()
	{
		if($this->input->post()) {
			$input = $this->input->post();
			$this->load->model('transport_model');
			if($this->transport_model->updateTransport($input))
			{
				echo json_encode([
					'status' => 1
				]);
				die;
			}
		}	
	}


	public function ajax_transporter_delete()
	{
		if($this->input->post()) {
			$id = $this->input->post('id');
			$this->load->model('transport_model');
			$status = $this->transport_model->softDeleteTransporter($id);
			echo json_encode([
				'status' => 1
			]);
			die;
		}		
	}

	public function ajax_print_transporter_list()
	{
		$this->load->model('transport_model');
		$data = array();
		$data['menus'] = $this->transport_model->getAll();
		$data['title'] = "Transporter List : " . date('m-d-y H:i:s');
		$html = $this->load->view('transporter/print-list', $data, true);
		$pdfFile = create_pdf($html, 'A4-L');

		echo $pdfFile;
	}	

	public function createWAestimate()
	{
		$this->load->model('wa_model');
		$saveId = $this->wa_model->create($this->input->post());
		if($saveId)
		{
			echo json_encode(array(
				'status' 	=> true,
				'id'		=> $saveId,
				'message' 	=> 'Estimate saved Successfully.'
			));
			die();			
		}
		echo json_encode(array( 
			'status' 	=> false,
		));
		die;		
	}

	public function getRefDetails()
	{
		$this->load->model('job_model');
		$refData = $this->job_model->getReferenceDetailsById($this->input->post('refId'));
		pr($refData);
	}

	public function getWAById()
	{
		$this->load->model('wa_model');
		$waRecord = $this->wa_model->getById($this->input->post('id'));

		echo json_encode(array(
			'status' => true,
			'result' => $waRecord
		));
		die();
	}

	public function generateWA($waId = null)
	{
		if($waId )
		{
			$this->load->model('wa_model');
			
			$data['waInfo'] 	= $this->wa_model->getById($waId);
			$html 				= $this->load->view('common/wa_pdf.php', $data, true);
			$pdfFile 	= create_pdf($html, 'A5');

			echo json_encode(array(
				'status' => true,
				'link'	 => $pdfFile
			));
			die;
		}

		echo json_encode(array(
			'status' => false,
		));
		die;
	}

	public function ajax_mail_dashboard()
	{
		$this->load->model('job_model');
		$data = array();
		$data['jobs'] = $this->job_model->get_dashboard_details();
		$data['title'] = "Dashboard List : " . date('m-d-y H:i:s');
		$html = $this->load->view('user/mail-list', $data, true);
		$subject = 'Dashboard Job List ' . date('Y-m-d H:i');
		
		sendBulkEmail(['shaishav77@gmail.com'], 'cyberaprintart@gmail.com', $subject, $html);
		
			
		echo json_encode(array(
				'status' => true,
		));
		die;
	}
}