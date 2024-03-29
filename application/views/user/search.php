
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<?php if(empty($search)) {
		echo "<h1>No Result Found</h1>";
		return true;
}?>
	<h3>
		Search Result For : "<?php echo $search;?>"
	</h3>
	</div>
</div>


<div class="box">
	<h3>Customers</h3>
		
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Mobile</th>
		<th>Office Contact</th>
		<th>Emailid</th>
		<th>Address-1</th>
		<th>City</th>
		<th>Created</th>
		<th>Edit</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $customer) { 
			if($customer['ctype'] == '1') { continue;}
			?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $customer['companyname'];?></td>
		<td><?php echo $customer['name'];?></td>
		<td><?php echo $customer['mobile'];?></td>
		<td><?php echo $customer['officecontact'];?></td>
		<td><?php echo $customer['emailid'];?></td>
		<td><?php echo $customer['add1']." ".$customer['add2'];?></td>
		<td><?php echo $customer['city'];?></td>
		<td><?php echo date('h:i A', strtotime($customer['created']));?></td>
		<td><a href="<?php echo site_url();?>/customer/edit/<?php echo $customer['id'];?>">Edit</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div>
</div>




<div class="box">
	<h3>Jobs</h3>
	<div class="box-body table-responsive">
		<table id="example3" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Num</th>
		<th>Customer Name</th>
		<th>Job Name</th>
		<th>Mobile</th>
		<th>Bill Amount</th>
		<th>Advance</th>
		<th>Date / Time</th>
		<th>Status</th>
		<th>Receipt</th>
		<th>Bill Number</th>
		<th>Due</th>
		<th>Status</th>
		<th>SMS</th>
		<th>View</th>
		<th>Edit</th>
		<th>Edit</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($job_data as $job) {
			 ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['companyname'] ? $job['companyname'] : $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['total'];?></td>
		<td><?php echo $job['advance'];?></td>
		<td><?php echo date('h:i a d-M-Y',strtotime($job['created']));?></td>
		<td><?php echo $job['jstatus'];?></td>
		<td><?php echo $job['receipt'];?></td>
		<td><?php echo $job['bill_number'];?></td>
		<td>
			<?php
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
				
				?>
		</td>
		<td><a class="fancybox" href="#view_job_status" onclick="show_job_status(<?php echo $job['job_id'];?>);">
			<?php
				if($job['jstatus'] == JOB_COMPLETE) {
					echo "<span class='blue'>".$job['jstatus']."</span>";
				} else {
					echo "<span class='red'>".$job['jstatus']."</span>";
				}
				?>
			</a>
		</td>
		<td><?php echo $job['smscount'];?></td>
		<td>
		<a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a>
		</td>
		<td><a href="<?php echo site_url();?>/jobs/edit_job/<?php echo $job['job_id'];?>">Edit</a></td>
		<td><a href="<?php echo site_url();?>/jobs/job_print/<?php echo $job['job_id'];?>">Print</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	
	<div class="box">
	<h3>Job Details</h3>
		
		<div class="box-body table-responsive">
		<table id="example4" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Type</th>
		<th>Job Details</th>
		<th>Qty</th>
		<th>Rate</th>
		<th>Sub Total</th>
		<th>View</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($job_details as $jdetails) {  ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $jdetails['jtype'];?></td>
		<td><?php echo $jdetails['jdetails'];?></td>
		<td><?php echo $jdetails['jqty'];?></td>
		<td><?php echo $jdetails['jrate'];?></td>
		<td><?php echo $jdetails['jamount'];?></td>
		<td><a href="<?php echo site_url();?>/jobs/view/<?php echo $jdetails['job_id'];?>">View</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div>
</div>



<div class="box">
	<h3>Dealers</h3>
		
		<div class="box-body table-responsive">
		<table id="example2" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Dealer Code</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Mobile</th>
		<th>Office Contact</th>
		<th>Emailid</th>
		<th>Address-1</th>
		<th>City</th>
		<th>Created</th>
		<th>Edit</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($dealers as $customer) { 
			if($customer['ctype'] == '0') { continue;}
			?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $customer['dealercode'];?></td>
		<td><?php echo $customer['companyname'];?></td>
		<td><?php echo $customer['name'];?></td>
		<td><?php echo $customer['mobile'];?></td>
		<td><?php echo $customer['officecontact'];?></td>
		<td><?php echo $customer['emailid'];?></td>
		<td><?php echo $customer['add1']." ".$customer['add2'];?></td>
		<td><?php echo $customer['city'];?></td>
		<td><?php echo date('h:i A', strtotime($customer['created']));?></td>
		<td><a href="<?php echo site_url();?>/dealer/edit/<?php echo $customer['id'];?>">Edit</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div>
</div>


	
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
            $(function() {
                $('#example2').dataTable({
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
            $(function() {
                $('#example3').dataTable({
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
            $(function() {
                $('#example4').dataTable({
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
function update_job_status(id, defaultstatus) {
	
	var setDefault = false;
	
	if(defaultstatus)
	{
		setDefault = true;
	}
	var value = $( "input:radio[name=jstatus]:checked" ).val();
	var send_sms = $( "input:radio[name=send_sms]:checked" ).val();
	var is_delivered = $( "input:radio[name=is_delivered]:checked" ).val();
	var bill_number = $( "#bill_number").val();
	var voucher_number = $( "#voucher_number").val();
	var receipt = $( "#receipt").val();
	
	jQuery("#saveJobStatusBtn").attr('disabled', true);
	
	if(jQuery("#jobStatusTbl") && setDefault == false)
	{
		alert('Job Status Updated');
		jQuery("#jobStatusTbl").hide();
	}
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/prints/update_job_status/"+id, 
         data:{"j_id":id, "is_delivered": is_delivered,"j_status":value,"send_sms" : send_sms,"receipt":receipt,"bill_number":bill_number,"voucher_number":voucher_number},
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
        </script>

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>
