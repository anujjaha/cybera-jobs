<?php
if(strtolower($this->session->userdata['department']) == "master")
{
	redirect('master/unverifyjobs', 'refresh');
	die;
}
?>
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>jobs/edit">
		Add New Job
	</a>
	</div>
</div>
<style>
	td { font-size: 12px; }
</style>
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>PIN</th>
		<th>Date</th>
		<th>J Num</th>
		<th>Name</th>
		<th>Job Name</th>
		<th>Mobile</th>
		<th>Bill Amount</th>
		<th>Due</th>
		<th>Receipt</th>
		<th>Bill</th>
		<th>Status</th>
		<th>SMS</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$billNumber = [];
		foreach($jobs as $job) { 
			//pr($job);
			?>
		<tr>
		<td><?php echo $sr;?>
		</td>
		<td>
			<?php

				if($job['is_pin'] == 1)
				{
				?>
					<span class="green">PINNED</span>
					<br><br>	
					<a href="javascript:void(0);" class="pin-job">
						<i data-value="0" title="Un Pin" data-id="<?php echo $job['job_id'];?>" class="fa fa-2x fa-thumbs-o-down" aria-hidden="true"></i>
					</a>

				<?php
				}
				else
				{
					echo "<br><br>";
				?>
					<a href="javascript:void(0);" class="pin-job">
						<i data-value="1" title="Pin" data-id="<?php echo $job['job_id'];?>" class="fa fa-2x fa-thumbs-o-up" aria-hidden="true"></i>
					</a>

				<?php
				}
			?>

		</td>
		<td width="60px;">
			<span style="font-size:11px;">
				<?php echo date('d-m-y',strtotime($job['created']));?>
			</span> || 
			<span style="font-size:11px;">
				<?php echo 	date('h:i A',strtotime($job['created']));?>
			</span>
		</td>
		<td width="10px">

				
			<?php
				$isShowJobId = true;
				
				if(isset($job['is_hold']) && $job['is_hold'] == 1)
				{
					echo '<span class="red">' .   $job['job_id'] . '</span>';
					echo '<br><span class="red"> Payment </span>';
					$isShowJobId = false;
				}
				else
				{
					echo '<br>';
				}

				if(isset($job['cyb_delivery']) && $job['cyb_delivery'] == 0)
				{
					if($isShowJobId)
					{
						echo '<span class="bold-font">' .   $job['job_id'] . '</span>';
					}
					echo '<br><span class="green"> Delivery </span>';
					$isShowJobId = false;
				}
				else
				{
					echo '<br>';
				}
				
				if($isShowJobId)
				{
					echo $job['job_id'];
				}
				
				if(isset($job['is_pickup']) && $job['is_pickup'] == 1)
				{
					echo '<br><span class="blue"> Pickup </span>';	
				}
				else
				{
					echo '<br>';
				}

				if(isset($job['is_manual']) && $job['is_manual'] == 1)
				{
					echo '<br><span style="color: black; font-weight: bold;"> Complete At </span>';	
				}
			?>	
		</td>
		<td><?php 
			echo $job['companyname'] ? $job['companyname'] : $job['name'] ;
			
			echo $job['ctype'] == 1 ? '<span class="red">[D]</span>' : '<span class="green">[R]</span>';

			if($job['rating'] == 5)
			{
				echo '<br><span style="color: green; font-weight: bold;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 4)
			{
				echo '<br><span style="color: green;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 3)
			{
				echo '<br><span style="color: black;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 2)
			{
				echo '<br><span style="color: red;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 1)
			{
				echo '<br><span style="color: red; font-weight: bold;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if(isset($job['is_hold']) && $job['is_hold'] == 1)
			{
				echo '<br><span class="red">' .   $job['payment_details'] . '</span>';
			}
			else
			{
				echo '<br>';
			}

			if(isset($job['cyb_delivery']) && $job['cyb_delivery'] == 0)
			{
				echo '<br><span class="bold-font green">' .   $job['delivery_details'] . '</span>';
			}
			else
			{
				echo '<br>';
			}

			
			if(isset($job['revision']) && $job['revision'] == 1)
			{
				?>
			
				
				<br>
				<span class="red">
							Please collect Payment before Job Complete.
				</span>
			<?php }
				
				if(isset($job['is_pickup']) && $job['is_pickup'] == 1)
				{
					echo '<br><span class="blue">'. $job['pickup_details'] .'</span>';
				}
				else
				{
					echo '<br>';
				}

				if(isset($job['is_manual']) && $job['is_manual'] == 1)
				{
					echo '<br><span style="color: black; font-weight: bold;"> '. $job['manual_complete'] .' </span>';	
				}
			?>



		</td>
		<td>

			<?php 
			echo $job['jobname'];
			if(isset($job['emp_name']))
			{
				echo "<br><br>[ ".$job['emp_name']." ]";
			}

		?>
		</td>
		<td><?php echo $job['mobile'];?>
			<hr>
			<?php echo $job['jsmsnumber'];
			if(isset($job['emailid']))
			{
				echo '<span style="color: green;">'.$job['emailid'].'</span>';
			}
		?>

		</td>
		<td><?php echo $job['total'];?>
			
			<?php
				if(isset($job['discount']) && $job['discount'] > 0)
				{
					echo '<hr><span class="green"> DISC : ' .$job['discount']. '</span>';
				}
				
			?>
		</td>
		<td><?php
		
			if(getBillStatus($job['job_id']))
			{
				echo '-';
				echo "<br>";
				echo "-------";
				echo "<br>";
				
				$userBalance =  get_acc_balance($job['customer_id']);
				if($userBalance > 0 )
				{
					echo "<span style='color:green;font-weight:bold;'>".$userBalance."</span>";	
				}
				else
				{
					echo "<span style='color:red;font-weight:bold;'>".$userBalance."</span>";	
				}
			}
			else
			{
				
				$user_bal = get_balance($job['customer_id']) ;
				if($user_bal > 0 ) { 
					
					
					$due_amt = $job['due'] - $job['discount'];
					echo $due_amt?$due_amt:"<span style='color:green;font-weight:bold;'>0</span>";	
					
				} else {
					echo "-";
				}
				
					echo "<br>";
					echo "----------";
					echo "<br>";
					
					$userBalance =  get_acc_balance($job['customer_id']);
					if($userBalance > 0 )
					{
						echo "<span style='color:green;font-weight:bold;'>".$userBalance."</span>";	
					}
					else
					{
						echo "<span style='color:red;font-weight:bold;'>".$userBalance."</span>";	
					}
				}	
				?>
		 </td>
		<td>
			<?php echo  str_replace(","," ",$job['receipt'].$job['t_reciept']);?>
		</td>
		<td>
			<?php 
				$showBillNumbers = [];
				$jbBill = '';
				if(!in_array($job['bill_number'], $billNumber))
				{
					$jbBill = str_replace(","," ", $job['bill_number']);
					//$billNumber[] = $job['bill_number'];
				}
				
				if(!in_array($job['bill_number'], $billNumber))
				{
					$tempBill =  str_replace(",","", $job['t_bill_number']);
					$tempBill =  str_replace(",","", $tempBill);

					if($jbBill == $tempBill)
					{
						echo $jbBill;
					}
					else
					{
						echo $jbBill . ' '.$tempBill;
					}
					//echo str_replace(","," ", $job['t_bill_number']);
					//$billNumber[] = $job['bill_number'];
				}
				else
				{
					echo $jbBill;
				}

				$showBillNumbers = array_unique($showBillNumbers);
				///echo implode(",", $showBillNumbers);
			?>
		</td>
		<td><a class="fancybox" href="#view_job_status" onclick="show_job_status(<?php echo $job['job_id'];?>);">
			<?php
				if($job['jstatus'] == JOB_COMPLETE) {
					echo "<span class='blue'>".$job['jstatus']."</span>";
				} else {
					echo "<span class='red'>".$job['jstatus']."</span>";
				}
				
				echo "</a><br>";
				
				if($job['is_delivered'] == 0 )
				{
					echo  '<span id="jobd-'.$job['job_id'].'"><a href="javascript:void(0);" onclick="setDelievered(' .$job['job_id']. ')" class="red">Un-Delievered</a></span>';
				}
				else
				{
					 echo " ( Delivered )";
					 echo "<br>" . $job['custom_delivery'];
				}
				?>
			
		</td>
		<td>
			<?php 
				echo $job['smscount'];

				echo in_array($job['job_id'], $scheduleIds) ? '<br><i class="fa fa-bell"></i>' : '';
			?>

			<!-- <br>
			<?php
				$custmerName = $job['companyname'] ? $job['companyname'] : $job['name'];
				$sms_text = "Dear ".$result->customer_name." Your Job Num ".$job['job_id']." completed and ready for delivery. Thank You for business with Cybera";
			
				$whatssUpMsg = urlencode($sms_text);
				$whatssUpMsg = str_replace('+', '%20', $whatssUpMsg);
				$url = 'http://api.whatsapp.com/send?phone=91'.$job['mobile'].'&text='.$whatssUpMsg;
			?>
			<a target="_blank" href="<?php echo $url;?>">
				Whatss Up
			</a> -->

		</td>
		<td width="85px;"><a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a>
		| 
		<a href="<?php echo site_url();?>/jobs/edit_job/<?php echo $job['job_id'];?>">Edit</a>
		|
		
		<a target="_blank" href="<?php echo site_url();?>/jobs/job_print_with/<?php echo $job['job_id'];?>#editCuttingSlipLive">Q Edit</a>
		|
			<a href="<?php echo site_url();?>/jobs/job_print/<?php echo $job['job_id'];?>">
			Print</a>

			<?php
				if(isset($job['approx_completion']))
				{
					echo "<hr><strong>".$job['approx_completion']. '</strong>';
				}
			?>
			</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
            $(function() {
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "iDisplayLength": 50,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                });
            });
    
    $(document).ready(function() {
      $('.fancybox').fancybox({
        'width':900,
        'height':600,
        'autoSize' : false,
    });
});
            
function update_status(id,value) {
	var oTable = $('#example1').dataTable();
	 $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/dealer/update_dealer_status/"+id+"/"+value, 
         success: 
              function(data){
				  location.reload();
			 }
          });
}
function show_job_status(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_jobstatus_history/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_status").html(data);
            }
          });
}

function show_job_details(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_details/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_view").html(data);
            }
          });
}
function update_job_status(id, defaultstatus) {
	
	var setDefault = false;
	
	if(defaultstatus)
	{
		setDefault = true;
	}
	var value = $( "input:radio[name=jstatus]:checked" ).val();
	var send_sms = $( "input:radio[name=send_sms]:checked" ).val();
	var is_delivered = $( "input:radio[name=is_delivered]:checked" ).val();
	var is_pickup = $( "input:radio[name=is_pickup]:checked" ).val();
	var is_hold = $( "input:radio[name=is_hold]:checked" ).val();
	var is_manual = $( "input:radio[name=is_manual]:checked" ).val();
	var cyb_delivery = $( "input:radio[name=cyb_delivery]:checked" ).val();
	var bill_number = $( "#bill_number").val();
	var pickup_details = $( "#pickup_details").val();
	var voucher_number = $( "#voucher_number").val();

	var payment_details = $("#payment_details").val();
	var delivery_details = $("#delivery_details").val();
	var manual_complete = $("#manual_complete").val();

	var receipt = $( "#receipt").val();
	
	jQuery("#saveJobStatusBtn").attr('disabled', true);
	
	if(jQuery("#jobStatusTbl") && setDefault == false)
	{
		alert('Job Status Updated');
		jQuery("#jobStatusTbl").hide();
	}
	var params = {"j_id":id, "is_delivered": is_delivered,"j_status":value,"send_sms" : send_sms,"receipt":receipt,"bill_number":bill_number,"voucher_number":voucher_number,
         "is_hold": is_hold,
         "cyb_delivery": cyb_delivery,
         "is_pickup": is_pickup,
         "pickup_details": pickup_details,
         "payment_details": payment_details,
         "delivery_details": delivery_details,
         "manual_complete": manual_complete,
		 "is_manual": is_manual
     };	

    console.log(params);

	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/prints/update_job_status/"+id, 
         data: params,
         success: 
              function(data){
				  console.log(data);
				  if(setDefault)
				  {
					$.fancybox.close();
                    location.reload();
				  }
							
			 }
          });
}

function save_shipping(jid) {
	var c_name,d_number;
	c_name = $("#courier_name").val();
	d_number = $("#docket_number").val();
	if(c_name.length > 0 ) 
	{
		
	jQuery("#saveShippingBtn").hide();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/save_courier/"+jid, 
         data:{"courier_name":c_name,"docket_number":d_number},
         success: 
              function(data)
              {
				$.fancybox.close();
                location.reload();
			 }
          });
	}
	else
	{
		$("#courier_name").focus();
		alert("Courier Name is missig !");
	}
}

jQuery(document).on('click', ".fancybox-close", function()
{
	location.reload();
});

$(document).keyup(function(e) 
{
     if (e.keyCode == 27)
     {
		 location.reload();
    }
});


function setDelievered(jobId)
{
	var customDelivery = prompt("Who pick the Job or Transporter Name?", "Customer");

	jQuery.ajax(
	{
		url: "<?php echo site_url();?>/ajax/delieveredJobSuccess",
		method: 'POST',
		dataType: 'JSON',
		data: {
			jobId: jobId,
			customDelivery: customDelivery
		},
		success: function(data)
		{
			if(data.status == true)
			{
				jQuery("#jobd-"+jobId).html("( Delivered )");
			}
		},
		error: function(data)
		{
			alert("Something Went Wrong !");
		}
	});
}
</script>
<div id="view_job_status" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_status"></div>
</div>
</div>

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>


<script>
if(jQuery("#customer"))
{
	jQuery("#customer").on('change', function()
	{
		var userId = jQuery("#customer").val();

	    $.ajax(
	    {
	     	type: "POST",
	     	dataType: 'JSON',
	     	url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userId, 
	     	success: 
	        function(data)
	        {
				jQuery("#sms_mobile").val(data.mobile);
	        }
	  });


	});
}

jQuery(document).on('click', ".pin-job", function(e)
{
	pinJob(e.target);
});

function pinJob(element)
{
	var jobId = element.getAttribute('data-id'),
		isPin = element.getAttribute('data-value'),
		msg   = isPin == 1 ? "Job Pinned Successfully" : "Job Un Pinned Successfully";

	if(jobId)
	{
		$.ajax(
	    {
	     	type: "POST",
	     	dataType: 'JSON',
	     	data: {
	     		jobId: jobId,
	     		isPin: isPin
	     	},
	     	url: "<?php echo site_url();?>/ajax/pinJob", 
	     	success:  function(data)
	        {
	        	if(data.status == true)
	        	{

	        		swal("Yeah!", msg, "success");
	        		location.reload();
	        		return;
	        	}

	        	swal("OH!", "Please Try Again ", "error");
	        }
	  });
	}

}
</script>


