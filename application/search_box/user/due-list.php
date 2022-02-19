<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

<div class="row">
	<div class="col-md-6 ">
		<h2>Customer Due List</h2>
	</div>
</div>

<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Company</th>
		<th>Name</th>
		<th>Mobile</th>
		<th>Credit</th>
		<th>Debit</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
	<?php
		$sr = 1;
		$totalCredit = $totalDebit = 0;
		foreach($results as $customer) {


		if(! $customer->id )
		{
			continue;
		}
		$customerBalance = getCustomerRawBalance($customer->id);

		if(! $customerBalance)
		{
			continue;
		}
	
		$balance = round($customerBalance->total_credit - $customerBalance->total_debit, 0);
		if($balance == 0 )		
		{
			continue;
		}

		$debit = $credit = " - ";
		
		if($balance > 0 )
		{
			$credit = $balance;
		}
		else
		{
			$debit = $balance;
		}
		
		$totalCredit 	= $totalCredit + $credit;
		$totalDebit 	= $totalDebit + $debit;
		$customerName 	= $customer->companyname ? $customer->companyname : $customer->name;
	?>
		<tr>
			<td style="border: solid 2px;"> <?php echo $sr;?> </td>
			<td style="border: solid 2px;"> <?php echo $customer->companyname;?> </td>
			<td style="border: solid 2px;"> <?php echo  $customer->name;?> </td>
			<td style="border: solid 2px;"> <?php echo  $customer->mobile;?> </td>
			<td style="border: solid 2px; color: green;"> <?php echo $credit;?> </td>
			<td style="border: solid 2px; color: red;"> <?php echo $debit;?> </td>
			<td>
				<a target="_blank" href="<?php echo site_url();?>/account/account_details/<?php echo $customer->id;?>">View</a>
				||
				<a target="_blank" href="<?php echo site_url();?>/customer/edit/<?php echo $customer->id;?>">Edit</a>
				||
				<a href="javascript:void(0);"
				data-customer="<?php echo $customerName;?>"
				data-mobile="<?php echo $customer->mobile;?>"
				 data-balance="<?php echo $balance;?>" class="remind-amount" data-id="<?php echo $customer->id;?>">Remind</a>
			</td>
		</tr>
	<?php
		$sr++;
		}
	?>
	</tbody>	
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

jQuery(document).on('click', '.remind-amount', function(e)
{
	if(e.target.getAttribute('data-balance') >= 0 )
	{
		alert("NO Due found for " + e.target.getAttribute('data-customer'));
		return ;
	}

	remindSms(e.target.getAttribute('data-customer'), e.target.getAttribute('data-mobile'), e.target.getAttribute('data-balance'));
})


function remindSms(customrName, mobile, balance)
{
	jQuery.ajax(
	{
		type: "POST",
		url: "<?php echo site_url();?>/ajax/send_reminder", 
		data : { 
			customrName: 	customrName,
			mobile: 		mobile,
			balance: 	 	balance
		},
		success: function(data)
		{
			alert("Following Message Sent " + data);
        }
	});
}
</script>


