<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script>

$(document).ready(function() {
var oldStart = 0;
$('#example1').dataTable( {
//here is our table defintion
"fnDrawCallback": function (o) {
	if ( o._iDisplayStart != oldStart ) {
	$(".dataTables_scrollBody").scrollTop(0);
	oldStart = o._iDisplayStart;
	}
}
</script>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Customer Details</h3>
	</div><!-- /.box-header -->
	<div class="box-header">
		<span><a href="<?php echo site_url();?>/customer/edit/">Add Customer</a></span>
	</div>
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Total Amount</th>
		<th>Due</th>
		<th>Mobile</th>
		<th>Contact</th>
		<th>Email Id</th>
		<th>City</th>
		<th>Status</th>
		<th>Switch To Dealer</th>
		<th>Switch To Voucher</th>
		<th>Created</th>
		<th>Observation</th>
		<th>Block</th>
		<th>View</th>
		<th>Edit</th>
		<th>Delete</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $customer) { ?>
		<tr id="tr_<?php echo $customer->id;?>">
		<td><?php echo $sr;?></td>
		<td><?php echo $customer->companyname;?></td>
		<td><?php echo $customer->name;?></td>
		<td><?php echo $customer->total_amount;?></td>
		<td><?php echo $customer->due;?></td>
		<td><?php echo $customer->mobile;?></td>
		<td><?php echo $customer->officecontact;?></td>
		<td><?php echo $customer->emailid;?></td>
		<td><?php echo $customer->city;?></td>
		<td><?php 
			$status = "Inactive";
				if($customer->status == '1') { $status = "Active"; }
				echo $status;
		?></td>
		<td id="setDealer-<?php echo $customer->id;?>">
			<a href="javascript:void(0);" onclick="switch_customer(<?php echo $customer->id;?>,1);">Set Dealer</a>
		</td>
		<td id="setVoucher-<?php echo $customer->id;?>">
			<a href="javascript:void(0);" onclick="switch_customer(<?php echo $customer->id;?>,2);">Set Voucher</a>
		</td>
		<td><?php echo date('h:i A', strtotime($customer->created));?></td>
		<td>
			<div id="revisionContainer-<?php echo $customer->id;?>">
			<?php 
				if($customer->under_revision == 1)
				{
					echo "<span class='red'>Yes</span>";
					echo "<br><a onclick='resetCustomerRevisionStatus(" . $customer->id .", 0)' href='javascript:void(0);' class='btn btn-xs btn-primary'>Normal</a>";
				}
				else
				{
					echo "<span class='green'>No</span>";
					echo "<br><a onclick='resetCustomerRevisionStatus(" . $customer->id .", 1)' href='javascript:void(0);' class='btn btn-xs btn-danger'>Under Revision</a>";
				}
			?>
			</div>
		</td>
		<td>
			<div id="blockContainer-<?php echo $customer->id;?>">
			<?php 
				if($customer->is_block == 1)
				{
					echo "<span class='red'>Yes</span>";
					echo "<br><a onclick='resetCustomerBlockStatus(" . $customer->id .", 0)' href='javascript:void(0);' class='btn btn-xs btn-primary'>UnBlock</a>";
				}
				else
				{
					echo "<span class='green'>No</span>";
					echo "<br><a onclick='resetCustomerBlockStatus(" . $customer->id .", 1)' href='javascript:void(0);' class='btn btn-xs btn-danger'>Block</a>";
				}
			?>
			</div>
		</td>
		<td>
			<a class="fancybox" href="#view_customer_info" onclick="show_customer(<?php echo $customer->id;?>,0);">
				View
			</a>
			<a class="fancybox" href="#view_customer_info" onclick="show_customer(<?php echo $customer->id;?>,1);">
				Print
			</a>
		</td>
		<td><a href="<?php echo site_url();?>/customer/edit/<?php echo $customer->id;?>">Edit</a></td>
		
		<td><a href="javascript:void(0);" onclick="delete_customer(<?php echo $customer->id;?>);">Delete</a></td>
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
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "iDisplayLength": 50
                });
            });
            
function switch_customer(id,type){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_switch_customer/"+id+"/"+type, 
         success: 
            function(data){
				jQuery("#setDealer-" + id).html("Updated");
				jQuery("#setVoucher-" + id).html("Updated");
				//location.reload();
            }
          });
}            
function delete_customer(id){
	var status = confirm("Are you Sure, Want to Delete ? ");
	if(status == true) {
		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_delete/"+id, 
         success: 
            function(data) {
				jQuery("#tr_"+id).css('display','none');
			}
          });
    }
}            
</script>


<script>
function resetCustomerBlockStatus(id, block)
{
	$.ajax({
         type: "POST",
         data: {
         	customerId: id,
         	block: block
         },
         dataType: 'JSON',
         url: "<?php echo site_url();?>/ajax/resetCustomerBlockStatus", 
         success: 
            function(data)
            {
            	if(data.status == true)
            	{
            		swal("Awesome!", data.message, "success");
            		jQuery("#blockContainer-"+ id).html('Processing');
            		return ;
            	}

            	swal("Oh Crap!", data.message, "error");
            	jQuery("#blockContainer-"+ id).html('Processing');
            }
         });
}

function resetCustomerRevisionStatus(id, revision)
{
	$.ajax({
         type: "POST",
         data: {
         	customerId: id,
         	revision: revision
         },
         dataType: 'JSON',
         url: "<?php echo site_url();?>/ajax/resetCustomerRevisionStatus", 
         success: 
            function(data)
            {
            	if(data.status == true)
            	{
            		swal("Awesome!", data.message, "success");
            		jQuery("#revisionContainer-"+ id).html('Processing');
            		return ;
            	}

            	swal("Oh Crap!", data.message, "error");
            	jQuery("#revisionContainer-"+ id).html('Processing');
            }
         });
}

function show_customer(id,option) {
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_view_customer/"+id+"/"+option, 
         success: 
            function(data){
				
				if(option == 1 ) {
					window.open(data);
				} else {
					jQuery("#c_data").html(data);
			  }
            }
          });
}
</script>
<div id="view_customer_info" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="c_data"></div>
</div>
</div>
