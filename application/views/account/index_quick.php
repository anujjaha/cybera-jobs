<style>
.red {color:red;font-weight:bold;}
.green {color:green;}
</style>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Customer Account Details</h3>
	</div><!-- /.box-header -->
	<div class="box-header">
		<span><a href="<?php echo site_url();?>/customer/edit/">Add Customer</a></span>
	</div>
	<table>
	<tr>
		<td> Search : </td>
		<td><input type="text" name="search_box" id="search_box" class="form-control" onkeyup="search_filter();" ></td>
		<td>&nbsp;</td>
		<td><span class="btn btn-primary" onclick="clear_filter();">Clear</span></td>
	</tr>
</table>
	
<div id="show_result">
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th><span onclick="sort_filter('companyname','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Company Name
			<span onclick="sort_filter('companyname','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th><span onclick="sort_filter('name','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Customer Name
			<span onclick="sort_filter('name','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('total_debit','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Total Debit
			<span onclick="balance_filter('total_debit','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('total_credit','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Total Credit
			<span onclick="balance_filter('total_credit','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('balance','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Balance
			<span onclick="balance_filter('balance','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
			
		</th>
		<th><span onclick="sort_filter('mobile','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
				Mobile
			<span onclick="sort_filter('mobile','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th><span onclick="sort_filter('emailid','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Email Id
			<span onclick="sort_filter('emailid','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>City</th>
		<th>Status</th>
		<th>Account</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $customer) { ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td>
			<?php echo $customer->companyname;?>
			<hr>
			<span class="green"><?php echo $customer->fix_note;?></span>
		</td>

		<td><?php echo $customer->name;?></td>
		<td><?php echo round($customer->total_debit,2);?></td>
		<td><?php echo $customer->total_credit;?></td>
		<td><?php $balance = round($customer->total_credit - $customer->total_debit,0);

		$customerName = $customer->companyname ? $customer->companyname : $customer->name;
		$show = '<span class="green">'.$balance.'</span>';
			if($balance < 0 ) {
				$show = '<span class="red">'.$balance.'</span>';
			} 
			echo $show;
		?></td>
		<td><?php echo $customer->mobile;?><br><?php echo $customer->officecontact;?></td>
		<td><?php echo $customer->emailid;?></td>
		<td><?php echo $customer->city;?></td>
		<td><?php 
			$status = "Inactive";
				if($customer->status == '1') { $status = "Active"; }
				echo $status;
		?></td>
		<td>
			<a target="_blank" href="<?php echo site_url();?>/account/account_details/<?php echo $customer->id;?>">View</a>
			||
			<a target="_blank" href="<?php echo site_url();?>/customer/edit/<?php echo $customer->id;?>">Edit</a>
			||
			<a href="javascript:void(0);"
			data-customer="<?php echo $customerName;?>"
			data-mobile="<?php echo $customer->mobile;?>"
			 data-balance="<?php echo $balance;?>" class="remind-amount" data-id="<?php echo $customer->id;?>">Remind</a>
			 ||
			 <a target="_blank" href="<?php echo site_url();?>/customer/print_small/<?php echo $customer->id;?>">
			 	<i class="fa fa-2x fa-print" aria-hidden="true"></i>
			 </a>

			 <a href="javascript:void(0);" data-cid="<?php echo $customer->id;?>" class="add-diwali-2021"><i class="fa fa-2x fa-gift"></i></a>
			</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	<tr>
		<td colspan="11" align="center">
			<span class="btn btn-success" onclick="pagination('next');">Next</span>
			<span class="btn btn-success"  onclick="pagination('previous');">Previous</span>
		</td>
	</tr>
	
	</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
</div>	
<input type="hidden" name="offset" id="offset" value="<?php echo $offset;?>">
<script>
function search_filter() {
	var search = $("#search_box").val();
	var sort_by = "id";
	if(search.length > 3 ) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax/", 
			data : { 'search_box' : search, 'limit' :10, 'offset':0,"sort_by":sort_by},
			success: 
            function(data){
                  jQuery("#show_result").html(data);
                  //console.log(data);
            }
		});
	}
}

function sort_filter(value,sort_value) {
	
var search = $("#search_box").val();
	var sort_by = value;
	var sort_value = sort_value;
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax/", 
			data : { 'search_box' : search, 'limit' :10, 'offset':0,"sort_by":sort_by,'sort_value':sort_value},
			success: 
            function(data){
                  jQuery("#show_result").html(data);
                  //console.log(data);
            }
		});
}

function pagination(value) {
	var search = $("#search_box").val();
	var offset = 0;
	var sort_by = "id";
	if(value == "next" ){ 
		offset = parseInt($("#offset").val()) + parseInt(1);
	}
	if(value == "previous") {
		if($("#offset").val() != 0 ) {
			offset = parseInt($("#offset").val()) - parseInt(1);
		}
	}
	if(search.length < 1 ) {
		search = null;
	}
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax/", 
			data : { 'search_box' : search, 'limit' :10, 'offset':offset , 'sort_by':sort_by},
			success: 
            function(data){
                  jQuery("#show_result").html(data);
                  //console.log(data);
            }
		});
}

function balance_filter(sort_by,sort_value) {
var AjaxRunning = false; 
var search = $("#search_box").val();
	var sort_by =sort_by;
	var sort_value = sort_value;
	
	if(!AjaxRunning){
	AjaxRunning = true;
	
	jQuery("#show_result").html('<center><img src="<?php echo base_url('assets/img/ajax-loader1.gif')?>" class="img-circle" alt="Loading"/></center>');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax_balance/", 
			data : { 'search_box' : search, 'limit' :50, 'offset':0,"sort_by":sort_by,'sort_value':sort_value},
			success: 
            function(data){
				
                  jQuery("#show_result").html(data);
                  AjaxRunning=false;
                  //console.log(data);
            },
            async: false,
		
		});
	}
}

function pagination(value) {
	var search = $("#search_box").val();
	var offset = 0;
	var sort_by = "id";
	if(value == "next" ){ 
		offset = parseInt($("#offset").val()) + parseInt(1);
	}
	if(value == "previous") {
		if($("#offset").val() != 0 ) {
			offset = parseInt($("#offset").val()) - parseInt(1);
		}
	}
	
	if(search.length < 1 ) {
		search = null;
	}
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax/", 
			data : { 'search_box' : search, 'limit' :10, 'offset':offset , 'sort_by':sort_by},
			success: 
            function(data){
                  jQuery("#show_result").html(data);
                  //console.log(data);
            }
		});
}



function clear_filter() {
	$("#search_box").val("");
	$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax_clear/", 
			success: 
            function(data){
                  jQuery("#show_result").html(data);
                  //console.log(data);
            }
		});
}

jQuery(document).on('click', '.remind-amount', function(e)
{
	if(e.target.getAttribute('data-balance') >= 0 )
	{
		alert("NO Due found for " + e.target.getAttribute('data-customer'));
		return ;
	}

	remindSms(e.target.getAttribute('data-customer'), e.target.getAttribute('data-mobile'), e.target.getAttribute('data-balance'));
})

jQuery(document).on('click', '.add-diwali-2021', function(e)
{
	addToDiwali2021($(e.target).closest('a').attr('data-cid'));
})

function addToDiwali2021(cid)
{
	jQuery.ajax(
	{
		type: "POST",
		dataType: "JSON",
		url: "<?php echo site_url();?>/ajax/add_to_diwali", 
		data : { 
			'cid': cid,
			'year': '2021'
		},
		success: function(data)
		{
			if(data.message)
			{
				alert(data.message);
			}
			else
			{
				alert("Added to 2021 List");
			}
        }
	});
}


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
