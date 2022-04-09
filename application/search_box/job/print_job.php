<?php
$location = (object)$location;
$pay = '';

if($job_data->party_pay == 2)
{
	$pay = $job_data->party_pay == 1 ? 'PARTY' : 'CYBERA';

	$pay .= ' PAY';
}
//pr($job_data);
?>
<style>
    @media print
        {
        body div, body table {display: none;}
        body div#FAQ, body div#FAQ table {display: block;}
        }
td{font-size:11px; font-family:Arial, Helvetica, sans-serif}
.own-address td {
	font-size:12px;
	
}
.customer-address  td{
	font-size:12px;
}
.small-own-address td {
	font-size:7px;
	
}
.small-customer-address  td{
	font-size:8px;
}
#smallprintCourierTickret td {
	font-size:8px;
}

.table-curved {
    border-collapse:separate;
    border: solid #ccc 1px;
    border-radius: 25px;
}
</style>
<script type="text/javascript">
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}


</script>
<button class="btn btn-primary" onclick="print_job()">PRINT NOW</button>
<?php if($cutting_info) {?>
<span class="btn btn-primary" id="printCuttingPdfBtn" onclick="print_cutting_pdf(<?php echo $job_data->id;?>);">Cutting Slip</span>
 <?php } ?>
<button class="btn btn-primary" onclick="print_courier()">Courier Slip</button>
<button class="btn btn-primary" onclick="print_courier_small()">Small Courier Slip</button>
<?php
	$outside = isOutSide($job_data->id);

	if(isset($outside) && isset($outside->id))
	{
?>
	<button  onclick="printOutJob(<?php echo $job_data->id;?>);" class="btn btn-primary">Out Job</button>
<?php
	}
?>

<button class="btn btn-primary" onclick="edit_job()">Edit Job</button>

<button class="btn btn-primary" onclick="custom_print()">Custom Print</button>

<a href="<?php echo site_url();?>jobs/job_print_with/<?php echo $job_data->id;?>#editCuttingSlipLive">Quick Edit Cutting Slip</a>
<!--<button class="btn btn-primary" onclick="print_cutting()">Cutting Slip</button>-->
<div class="row">
	<div class="col-md-12">
		<h1>Print Job Details</h1>
	</div>
</div>


<?php
	if(strlen($job_data->extra_notes) > 0)
	{
?>
<div class="row">
	<div class="col-md-2 text-bold">
	Extra Notes
	</div>
	<div class="col-md-10">
		<?php echo $job_data->extra_notes;?>
	</div>
</div>
<hr>
<?php } ?>
<div id="printJobTicket" style="height:8.3in; width:5.8in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<?php
$created_info = get_user_by_param('id',$job_data->user_id);
$show_name = $customer_details->companyname ? $customer_details->companyname :$customer_details->name;
$content ='';
$customerTitle = "Name";
if($customer_details->ctype == 1 )
{
	$customerTitle = "Dealer";
}
		 for($j=0; $j<1; $j++)
		 {
			 $mobileNumber = (strlen($job_data->jsmsnumber) > 1 ) ? "-".$job_data->jsmsnumber : '';
			 $mobileNumber = $customer_details->mobile.$mobileNumber;
			$content .= '
				<table align="center" width="90%" border="0" style="border:0px solid;font-size:11px;height:3in;">
				<tr>
				<td width="100%" align="left">
					<table width="100%"  align="left" style="border:1px solid;font-size:11px;">
						<tr>
							<td align="center" style="font-size:12px;" colspan="2">
								<strong>Estimate</strong>
							</td>
						</tr>
						<tr>
							<td style="font-size:12px;">'.$customerTitle.' : <strong>'.$show_name.'</strong>';
							
				if($job_data->is_5_gst == 1)
				{
					$content  .='      (<span style="font-weight: bold;">5%</span>)';
				}
				//Mobile : <strong>'.$mobileNumber.'</strong>
				$content .= '</td><td align="right" style="font-size:12px;"> </td>
						</tr>
						<tr>
						<td  style="font-size:12px;" >Est Id : <strong>'.$job_data->id.'</strong> </td>
							
							<td style="font-size:14px; font-weight: bold;"  align="right">Est date : <strong>'.date('d-m-Y',strtotime($job_data->jdate)).' </strong>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center" style="font-size:12px;">
								Title : <strong>'.$job_data->jobname.'</strong>

							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="100%" align="center" style="border:1px solid; font-size:11px;">
									<tr>
										<td style="font-size:11px;">Sr.</td>
										<td style="font-size:11px;">Details</td>
										<td style="font-size:11px;">Qty</td>
										<td style="font-size:11px;">Rate</td>
										<td><p align="right" style="font-size:11px;">Amount</p></td>
									</tr>';
									 for($i=0;$i<6;$i++) {
										 $j1 = $i+1;
										if(isset($job_details[$i]['id'])){
										$content .= '
										<tr>
											<td style="font-size:11px;"> '.$j1 .'</td>
											<td style="font-size:11px;"> '.$job_details[$i]['jdetails'].'</td>
											<td style="font-size:11px;"> '.$job_details[$i]['jqty'].'</td>
											<td style="font-size:11px;"> '.$job_details[$i]['jrate'].' </td>
											<td style="font-size:11px;" align="right"> '.$job_details[$i]['jamount'].'</td>
										</tr>';
										} else {
											break;
										}
									} 
									$content .= '<tr>
										<td style="font-size:11px;" colspan="2">Receipt Number:'.$job_data->receipt.'</td>
										<td style="font-size:11px;" colspan="2" align="right">Sub Total :</td>
										<td style="font-size:11px;" align="right">'.$job_data->subtotal .'</td>
									</tr>';
									
									
									
									if(isset($job_data->discount) && $job_data->discount > 0 )
									{
										
										
										$content .= '<tr>
											<td style="font-size:11px;" colspan="4" align="right">Discount :</td>
											<td style="font-size:11px;" align="right">'.$job_data->discount.'</td>
										</tr>';
									}

									if(!empty($job_data->tax)) 
									{
										$content .= '<tr>
											<td style="font-size:11px;" colspan="4" align="right">Taxable Amount :</td>
											<td style="font-size:11px;" align="right">'. ($job_data->subtotal - $job_data->discount ) .'</td>
										</tr>';
									}

									if(!empty($job_data->tax)) 
									{
										$content .= '<tr>
											<td style="font-size:11px;" colspan="4" align="right">Tax :</td>
											<td style="font-size:11px;" align="right">'.$job_data->tax.'</td>
										</tr>';
									 } 

									$content .= '<tr>
										<td style="font-size:11px;" colspan="4" align="right">Total :</td>
										<td style="font-size:11px;" align="right">'. $job_data->total.'</td>
									</tr>';
									
									
									
									$content .= '<tr>
										<td style="font-size:11px;" colspan="4" align="right">Advance :</td>
										<td style="font-size:11px;" align="right">'.$job_data->advance.'</td>
									</tr>';
									$due = $job_data->due - $job_data->discount;
									$content .=  '<tr>
										<td style="font-size:11px;" colspan="2">Created by :'.$created_info->nickname.'<br>Operator :'.$job_data->emp_name.'</td>
										<td style="font-size:11px;" colspan="2" align="right">Due :</td>
										<td style="font-size:11px;" align="right">'. $due .'</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align: right; font-size: 16px; font-weight: bold;">
								Total due : '. get_acc_balance($customer_details->id)  .'
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<span style="font-size:11px;">
								<strong>Note :</strong>'.$job_data->notes.'
								</span>
							</td>
						</tr>';

						if($j == 0) {
							$content .= '	
							';
						}
						/*
						// I/we Accept
						$content .= '<tr>
							<td colspan="2">
							<span style="font-size:11px;">
								I/We have checked all content,color,material in the sample print.
								It is acceptable to me/us.
							</span>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								Signature : __________________________
							</td>
						</tr>';*/

				$approxCompletionTime = '';
				$genInvoiceDetails = '';

				if(strlen($job_data->approx_completion) > 2)
				{
					$approxCompletionTime = 'Approximate Completion Time : '. $job_data->approx_completion;
				}

				$genInvoice = $job_data->is_job_invoice == 1 ?  'Generate INVOICE<br>' : '';
				$genInvoiceDetails = '<strong>' . $genInvoice .'</strong>'. $job_data->invoice_details;
				
				
				$content .='<tr>
					<td> '. $approxCompletionTime .'</td>
					<td> '. $genInvoiceDetails .'</td>
				</tr>';

				if($job_data->is_continue == 1)
				{
					$content .='		<tr>
								<td colspan="2" align="center" style="font-size: 16px;">
									<strong>Continue Parcel</strong>
								</td>
							</tr>';					
				}
				$content .=	'</table></td></tr>';
			if($j == 0) {
				$content .= ' <tr><td colspan="2"><br><hr><br></td></tr>';
			}
			$content .= '</table>';
		} 
echo $content;
?>
</div>

<div id="printCuttingTicket" style="height:8.3in; width:5.8in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<!--Print Cutting Ticket-->
<?php
if($cutting_info) { 

if($job_data->is_customer_waiting == 1)
{
	$isWaiting = "<h4>Customer Waiting..</h4>";
}

if($job_data->is_customer_waiting == 2)
{
	$isWaiting = "<h4>Customer is on the Way..</h4>";
}

if($job_data->is_customer_waiting == 3)
{
	$isWaiting = "<h4>Call Customer once Job Finished.</h4>";
}

$pcontent = "";
$pcontent .= '<table align="center" width="90%" align="center" style="border:1px solid;">
			<tr>
				<td align="left" width="50%">'.$customerTitle.' : '.$customer_details->companyname.'</td>
				<td align="right">Date : '.$job_data->jdate.'</td>
			</tr>
			<tr>
				<td align="left">Title : <strong>'.$job_data->jobname.'</strong></td>
				<td align="right">Est Id : <strong>'.$job_data->id.'</strong></td>
			</tr></table>';
$pcontent .='<table align="center" border="2" width="90%" style="border:1px solid;"><tr>';
$sr=1;
foreach($cutting_info as $cutting) {
	$pcontent .= '<td>
				<table align="center" border="2" width="100%" style="border:1px solid;">';
				
				if(!empty($cutting['c_machine'])) {
					$pcontent .= '<tr><td align="right">Machine : </td><td>'.$cutting['c_machine'].'</td></tr>';
				}
				
				if(!empty($cutting['c_material'])) {
					$c_m_label = "Material : ";
					if($cutting['c_material'] == "ROUND CORNER CUTTING") {
							$c_m_label = "";
					}	
					$pcontent .= '<tr><td align="right">'.$c_m_label.'  </td><td>'.$cutting['c_material'].'</td></tr>';
				}
				
				if(!empty($cutting['c_qty'])) {
					$pcontent .= '<tr><td align="right">Quantity : </td><td>'.$cutting['c_qty'].'</td></tr>';
				}
				
				if(!empty($cutting['c_size'])) { 
					$pcontent .= '<tr><td align="right">Size : </td><td>'.$cutting['c_size'].'</td></tr>';
				}
				
				if(!empty($cutting['c_print'])) {
					$pcontent .= '<tr><td align="right">Print : </td><td>'.$cutting['c_print'].'</td></tr>';
				}
				
				if(!empty($cutting['c_sizeinfo']) && strlen($cutting['c_sizeinfo']) > 2 ) { 
					$pcontent .= '<tr><td align="right"><strong>Cutting Details :</strong> </td><td>'.$cutting['c_sizeinfo'].'</td></tr>';
				}
				
							
				if(!empty($cutting['c_corner'])) {
					$pcontent .= '<tr><td align="right"><strong>Corner Cut : </strong></td><td>'.$cutting['c_corner'].'</td></tr>';
				}
				
				if(!empty($cutting['c_cornerdie'])) {
					$pcontent .= '<tr><td align="right"><strong>Corner Die No : </strong></td><td>'.$cutting['c_cornerdie'].'</td></tr>';
				}
				
				if(!empty($cutting['c_rcorner'])) {
					$pcontent .= '<tr><td align="right"><strong>Round Cutting Side : </strong></td><td style="font-size 24px;"><strong>'.$cutting['c_rcorner'].'</strong></td></tr>';
				}
				
				if(!empty($cutting['c_laser'])) {
					$pcontent .= '<tr><td align="right"><strong>Laser Cut : </strong></td><td>'.$cutting['c_laser'].'</td></tr>';
				}
			
				if(!empty($cutting['c_lamination'])) {
					$pcontent .= '<tr><td align="right"><strong>Lamination Details : </strong></td><td>'.$cutting['c_lamination'];
					if(!empty($cutting['c_laminationinfo'])) {
						$pcontent .= '<br>'.$cutting['c_laminationinfo'];
					}
					
					$pcontent .= '</td></tr>';
				}
			
				if(!empty($cutting['c_binding'])) {	
					$pcontent .= '<tr><td align="right"><strong>Binding Details : </strong></td><td>'.$cutting['c_binding'];
					
					if(!empty($cutting['c_bindinginfo'])) {
						$pcontent .= '<br>'.$cutting['c_bindinginfo'];
					}
					$pcontent .= '</td></tr>';
				}
			
				if(!empty($cutting['c_details'])) {
					$pcontent .= '<tr><td colspan="2">Description : <strong>'.$cutting['c_details'].'</strong></td></tr>';
				}
				
				if(!empty($cutting['c_packing'])) {
					$pcontent .= '<tr><td align="right">Packing Details : </td><td>'.$cutting['c_packing'].'</td></tr>';
				}
			
				$pcontent .= '</table> </td>';
				if($sr > 1 && ($sr % 2) ==0) {
					$pcontent .= '</tr><tr>';
				}
				$sr++;
}
$pcontent .= '</tr>';
$pcontent .= '<tr><td>' . $isWaiting . '</td></tr></table>';
echo $pcontent;
}
?>


</div>
<!--Print Cutting Ticket End-->

<!--Print Courier Service-->
<div id="printCourierTickret" style="height:8.3in; width:5.8in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">
<table align="center" border="2" width="85%" style="border: 2px solid #000000; border-radius: 10px;">
<tr>
<td>
<table align="center" border="0" width="100%">
	<tr>
		<td>
			<center>Total Jobs: <strong><?php echo $job_data->sub_jobs . '('. $pay .')';?></strong></center>
		</td>
		<td>
			<center><p><?php echo get_acc_balance($customer_details->id);?> </p></center>
			
		</td>

	</tr>
	<tr>
		<td>
			<table align="left" width="100%" border="0" style="margin-left: 10px; margin-top: 0px; line-height: 15%;">
			<tr>
				<td> 
					<p style="text-align: right; margin-right: 30px;">
					<span style="font-size:14px;">
						<strong>
						<?php
							echo getJobTransporter($job_data->transporter_id);
						?> 
						</strong>
					</span>
					</p>
					<span style="font-size:15px;  line-height: 95%;">
						<strong>To, </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td> 
					<span style="font-size:20px; font-weight: bold; line-height: 95%;">
						<strong><?php echo $customer_details->companyname ?  $customer_details->companyname :  $customer_details->name;?> </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" class="customer-address">
					<tr>
						<td style="font-size:18px; line-height: 95%;">
							<?php echo $location->add1."<br>".$location->add2;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:18px; line-height: 95%;">
							<?php echo $location->city." ".$location->state." ".$location->pin;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:18px; line-height: 95%;">
							Mobile - <?php echo $location->mobile;?>
						</td>
					</tr>
					<?php
					if(isset($transporter_info)) {
					?>
					<!--<tr>
						<td style="font-size:18px; line-height: 95%;">
							Delivery By : <?php echo $transporter_info->name;?>
						</td>
					</tr>-->
					<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		 </td>
	</tr>
	<?php
		if($job_data->is_print_cybera == 1)
		{
			//die('test');
	?>
	<tr>
		<td>
			<table align="center" width="100%">
			<tr>
				<td width="16%">&nbsp;</td>
				<td>
					<table width='100%' align='right' border='0' style="font-size:15px; line-height: 95%;" class="own-address">
					<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
					<tr><td>&nbsp;</td><td><strong>From, </strong></td></tr>
					<tr><td>&nbsp;</td><td><strong>CYBERA PRINT ART</strong> </td></tr>
					<tr><td>&nbsp;</td><td>G/3, Samudra Annexe, Nr. Girish Cold Drinks Cross Road,</td></tr>
					<tr><td>&nbsp;</td><td>Off C.G. Road, Navrangpura, Ahmedabad - 009</td></tr>
					<tr><td>&nbsp;</td><td>Call : 079-26565720 / 26465720</td></tr>
					<tr><td>&nbsp;</td><td>Mobile : 9898309897</td></tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<?php
		}
	?>
</table>

</td>
</tr>

</table>
</div>


<!--Small Print Courier Service-->
<div id="smallprintCourierTickret" style="height:3.5in; width:3.5in;  font-family:Arial, Helvetica, sans-serif;">
<table align="center" border="2" width="65%" style="border: 2px solid #000000; border-radius: 10px;">
<tr>
<td>
<table align="center" border="0" width="95%">
	<tr>
		<td>
			<center><h5>Total Jobs: <?php echo $job_data->sub_jobs . '('. $pay .')';?></h5></center>
		</td>
		<td>
			<center><p><?php echo get_acc_balance($customer_details->id);?> </p></center>
		</td>
	</tr>
	<tr style="margin-top: -15px;">
		<td>
			<table align="left" width="100%" border="0">
			<tr>
				<td> 
					<p style="text-align: right;">
					<span style="font-size:24px;">
						<strong>
						<?php
							echo getJobTransporter($job_data->transporter_id);
						?> 
						</strong>
					</span>
					</p>
					<span style="font-size:15px;  line-height: 45%;">
						<strong>To, </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td> 
					<span style="font-size:15px; font-weight: bold;  line-height: 95%;">
						<strong><?php echo $customer_details->companyname ?  $customer_details->companyname :  $customer_details->name;?> </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" class="small-customer-address" style="font-size:14px;  line-height: 95%;">
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							<?php echo $location->add1." ".$location->add2;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							<?php echo $location->city." ".$location->state." ".$location->pin;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							Mobile - <?php echo $location->mobile;?>
						</td>
					</tr>
					<?php
					if(isset($transporter_info)) {
					?>
					<!--<tr>
						<td style="font-size:14px;  line-height: 95%;">
							Delivery By : <?php echo $transporter_info->name;?>
						</td>
					</tr>-->
					<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		 </td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%">
			<tr>
				<td width="8%">&nbsp;</td>
				<td>
					<table width='100%' align='right' border='0' class="small-own-address">
					<?php
						if($job_data->is_print_cybera == 1)
						{
					?>
						<tr style="height:5px;">
							<td>&nbsp;</td><td style="font-size:12px;  line-height: 14px;"><strong>From, CYBERA PRINT ART</strong> </td>
						</tr>
						<tr style="height:5px;"><td>&nbsp;</td><td style="font-size:12px;  line-height: 14px;">
						G/3, Samudra Annexe,Nr. Girish Cold Drink Cross Road,
						<br>
						Off C.G. Road, Navrangpura Ahmedabad - 009
						<br>
						Call : 079-26565720 / 26465720 | 9898309897</td>
					</tr>
					<?php
						}
					?>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</div>
<!--Small Print Courier Service End-->


<!--Custom Print Service-->
<div id="customPrintPaper" style="height:3.5in; width:3.5in;  font-family:Arial, Helvetica, sans-serif;">
<table align="center" border="2" width="65%" style="border: 2px solid #000000; border-radius: 10px;">
<tr>
<td>
<table align="center" border="0" width="95%">
	<tr>
		<td>
			<span id="customPrintToContainer"></span>
		</td>
	</tr>

	<tr>
		<td style="margin-left: 100px;">
			<span id="customPrintFromContainer"></span>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</div>
<!--Custom Print End-->

<script>
function print_job() {
	printDiv('printJobTicket');
/*$.ajax({
type: "POST",
url: "<?php echo site_url();?>/jobs/print_job_ticket/"+<?php echo $job_data->id;?>, 
success: 
function(data){
print_cutting();
return true;
}
});*/
}
function print_cutting() {
	printDiv('printCuttingTicket');
/*$.ajax({
type: "POST",
url: "<?php echo site_url();?>/jobs/print_cutting_ticket/"+<?php echo $job_data->id;?>, 
success: 
function(data){
return true;
}
});*/
}

function print_courier_small() {
	printDiv('smallprintCourierTickret');
}
function print_courier() {
	printDiv('printCourierTickret');
	/*$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/jobs/print_courier_ticket/"+<?php echo $job_data->id;?>, 
         success: 
              function(data){
							return true;
			 }
          });*/	
}

function edit_job() {
	window.location.assign("<?php echo site_url();?>/jobs/edit_job/<?php echo $job_data->id;?>");
}

function print_cutting_pdf(id)
{
	jQuery("#printCuttingPdfBtn").attr('disabled', 'disabled');
	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/generaeAjaxCuttingSlip/"+id,
		method: "GET",
		dataType: 'JSON',
		success: function(data)
		{
			if(data.status == true)
			{
				window.open(data.link);
			}
			else
			{
				alert("Unable to Create PDF");
			}
		},
		complete: function(data) {
			jQuery("#printCuttingPdfBtn").removeAttr('disabled');
		}
	});

}

function printOutJob(id)
{
	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/generateOutJob/"+id,
		method: "GET",
		dataType: 'JSON',
		success: function(data)
		{
			if(data.status == true)
			{
				window.open(data.link);
			}
			else
			{
				alert("Unable to Create PDF");
			}
		}
	});

}

function custom_print()
{
	jQuery("#customPrintModal").modal('show');
	jQuery("#customTo1").val('');
	// jQuery("#customTo2").val('');
	// jQuery("#customTo3").val('');
	jQuery("#customFrom1").val('');
	// jQuery("#customFrom2").val('');
	// jQuery("#customFrom3").val('');
}

function printCustom()
{
	// jQuery("#customPrintToContainer").html('<strong>To, </strong> <br />' + jQuery("#customTo1").val() + '<br />' + jQuery("#customTo2").val() + '<br />' + jQuery("#customTo3").val());
	// jQuery("#customPrintFromContainer").html('<br /><strong>From, </strong> <br />'+jQuery("#customFrom1").val() + '<br />' +jQuery("#customFrom2").val() + '<br />' +jQuery("#customFrom3").val());
	var customTx = jQuery("#customTx").val();
	var printTx = '';

	if(customTx == '' || customTx == ' ')
	{
		printTx = '';		
	}
	else
	{
		printTx = '<strong><center>' + customTx + '</strong></center>'; 
	}
	// if(customTx == ' ' || customTx = "-")
	// {
	// 	customTx = '';
	// }
	var customTo1 = jQuery("#customTo1").val().replace(/\&/g, '<br />');
	var customFrom1 = jQuery("#customFrom1").val().replace(/\&/g, '<br />');

	jQuery("#customPrintToContainer").html(printTx + '<strong>To, </strong> <br />' + customTo1);
	jQuery("#customPrintFromContainer").html('<p style="margin-left: 40%;"><br /><strong>From, </strong> <br />'+customFrom1+"</p>");	
	jQuery("#customPrintModal").modal('hide');
	printDiv('customPrintPaper');
}
</script>
<div id="editCuttingSlipLive">
<?php
//pr($cutting_info);
	//	pr($job_data);
?>
</div>


<!-- Modal -->
<div class="modal fade" id="customPrintModal" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content">
        <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
         	<h4 class="modal-title">Custom Address</h4>
         	<small>Please add & to start new line</small>
        </div>
        <div class="modal-body">
        	<div class="form-group">
        		<label for="customTox">Transporter: </label>
        		<input required="required" class="form-control" type="text" name="customTx" id="customTx" value="<?= getJobTransporter($job_data->transporter_id); ?>">
        	</div>
        	<div class="form-group">
        		<label for="customTo1">To: </label>
        		<textarea class="form-control" id="customTo1" name="customTo1"></textarea>
        		<!-- <input type="text" id="customTo1" name="customTo1" class="form-control" placeholder="To Party Name" />
        		<br />
        		<input type="text" id="customTo2" name="customTo2" class="form-control"  placeholder="To Address 1"/>
        		<br />
        		<input type="text" id="customTo3" name="customTo3" class="form-control"  placeholder="To Address 2" /> -->
        	</div>

        	<div class="form-group">
        		<label for="customFrom1">From: </label>
        		<textarea class="form-control" id="customFrom1" name="customFrom1"></textarea>
        		<!-- <input type="text" id="customFrom1" name="customFrom1" class="form-control" placeholder="From Party Name"  /> -->
        		<!-- <br />
        		<input type="text" id="customFrom2" name="customFrom2" class="form-control" placeholder="From Address 1"  />
        		<br />
        		<input type="text" id="customFrom3" name="customFrom3" class="form-control" placeholder="From Address 2"/> -->
        	</div>
        </div>
        <div class="modal-footer">
        	<button type="button" class="btn btn-primary" onclick="printCustom();">Print</button>
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>