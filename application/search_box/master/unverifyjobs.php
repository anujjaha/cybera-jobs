<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<script>
function direct_verify_job(id) {
	$("#verify_"+id).html("Verified");
	$('div.dataTables_filter input').val("");
	$('div.dataTables_filter input').focus();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_verify/"+id, 
         data:{"job_id":id,"notes":"Verified by Master"},
         success: 
              function(data){
					//location.reload();
					return true;
			 }
          });
}
</script>
<section class="content">

<!-- Main row -->
<div class="row">
<hr>
<!-- Left col -->
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Num</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Job Name</th>
		<th>Mobile</th>
		<th>Bill Amount</th>
		<th>Advance</th>
		<th>Due</th>
		<th>Receipt</th>
		<th>Bill Number</th>
		<th>Verify</th>
		<th>Date / Time</th>
		<th>Status</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($unverify_jobs as $job) { 
			?>
		<tr>
		<td><?php echo $sr;?></td>
		<td>
		<?php
			echo $job['job_id'];
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

			if(isset($job['is_5_gst']) && $job['is_5_gst'] == 1)
			{
				echo '<span style="color: green; font-size: 22px; font-weight:bold;"><br>5%</span>';
			}

			if(isset($job['is_job_invoice']) && $job['is_job_invoice'] == 1)
			{
				echo '<span style="color: green; font-size: 22px; font-weight:bold;"><br>INVOICE</span>';
				echo "<br>" . $job['invoice_details'];
			}
		?>
		</td>
		<!-- <td><?php echo $job['job_id'];?></td> -->
		<td>
			<?php echo $job['companyname'];?>
			<?php 
				echo "<hr />";
				echo isset($job['emailid']) && !empty($job['emailid']) ?  '<span class="green">' . $job['emailid'] .'</span>' : '';
			?>
			
		</td>
		<td><?php echo $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['total'];?></td>
		<td><?php echo $job['advance'];?></td>
		<td><?php echo $job['due']?$job['due']:"<span style='color:green;font-weight:bold;'>0</span>";?>
			<?php	
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
			?>
		</td>
		<td><?php 
		echo str_replace(","," ", $job['t_reciept']);
		 echo $job['receipt'];?></td>
		<td><?php echo $job['bill_number'];?></td>
		<td>
			<?php
			if($job['is_delivered'] == 0 )
			{
				echo "N/A";
			}
			else
			{
		?>
			<span id="verify_<?php echo $job['job_id'];?>">
				<a href="javascript:void(0);" onclick="direct_verify_job(<?php echo $job['job_id'];?>)">Verify</a>
			</span>
			<?php 
				if(isset($job['job_ref_id']) && !empty($job['job_ref_id']))
				{
				?>
					<a style="margin-top: 20px;"	 target="_blank" class="btn btn-sm btn-primary" href="<?php echo site_url();?>/jobs/edit_job/<?php echo $job['job_id'];?>">Edit</a>
					<!-- <button data-id="<?= $job['job_ref_id'];?>" class="btn btn-sm btn-primary getRefDetails">Ref</button> -->
				<?php
				}
			}
		?>
		</td>
		<td><?php echo date('d-m-Y',strtotime($job['created']))
						." - ".
						date('h:i A',strtotime($job['created']));?>
		</td>

				<td>
			<?php
				if($job['jstatus'] == JOB_COMPLETE) {
					echo "<span class='blue'>".$job['jstatus']."</span>";
				} else {
					echo "<span class='red'>".$job['jstatus']."</span>";
				}
				
				echo "</a><br>";
				
				if($job['is_delivered'] == 0 )
				{
					$custmerName = $job['companyname'] ? $job['companyname'] : $job['name'];
					$custmerName = $custmerName . ' | ' . $job['mobile'];
					echo  '<span id="jobd-'.$job['job_id'].'"><a 
					data-value="'.$custmerName.'"
					href="javascript:void(0);" data-id="' .$job['job_id']. '" class="set-delivery red">Un-Delievered</a></span>';
				}
				else
				{
					 echo " ( Delivered )";
					 echo "<br>" . $job['custom_delivery'];
				}
				?>
		</td>
		<td width="85px;"><a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a>
		| 
		<a href="<?php echo site_url();?>/jobs/edit_job/<?php echo $job['job_id'];?>">Edit</a>
		|
		
		<a target="_blank" href="<?php echo site_url();?>/jobs/job_print_with/<?php echo $job['job_id'];?>#editCuttingSlipLive">Q Edit</a>
		|
			<a href="<?php echo site_url();?>/jobs/job_print/<?php echo $job['job_id'];?>">
			Print</a>
		|
		<a href="javascript:void(0);" class="job-review" data-job-name="<?= $job['jobname'];?>" data-customer-id="<?php echo $job['customer_id'];?>" data-customer-mobile="<?= $job['mobile'];?>" data-customer-name="<?= $job['companyname'] ? $job['companyname'] : $job['name'] ;?>" data-job-id="<?php echo $job['job_id'];?>">
			Review
		</a>
		

		|
			<strong><a target="_blank" href="<?php echo site_url();?>/customer/edit/<?php echo $job['customer_id'];?>">Customer</a></strong>

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
</div><!-- /.row (main row) -->

</section>
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
function show_job_details(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_short_details/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_view").html(data);
            }
          });
}

jQuery(document).on('click', ".pin-job", function(e)
{
	pinJob(e.target);
});


jQuery(document).on('click', ".getRefDetails", function(e)
{	
	console.log(e.target);
	$(e.target).attr('data-id');
	showRefDetails($(e.target).attr('data-id'));
});

function showRefDetails(refId)
{
	$.ajax(
    {
     	type: "POST",
     	dataType: 'JSON',
     	data: {
     		refId: refId
     	},
     	url: "<?php echo site_url();?>/ajax/getRefDetails", 
     	success:  function(data)
        {
        	console.log(data);
        }
  });
}

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

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>
