<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />



<?php
/*echo "<pre>";
print_r($books);
die;*/
?>
<h4>Show Estimations</h4>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Customer</th>
		<th>Title</th>
		<th style="width: 50%">Print Details</th>
		<th>Created By</th>
		<th>Created At</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$updatedResult = [];
		foreach($results as $result)
		{ 
		?>
		<tr id="wa_<?php echo $result['id'];?>">
			<td><?php echo $result['id'];?></td>
			<td>
			<a href="javascript:void(0);" class="copyBtn" data-id="<?= $result['id'];?>" 
				data-values="'<?= json_encode($result);?>'">
			<?php echo $result['customer'];?>
			</a></td>
			<td><?php echo $result['title'];?></td>
			<td  style="width: 50%"><?php echo $result['details'];?></td>
			<td><?php echo $result['username'];?></td>
			<td><?php echo $result['created_at'];?></td>
			<td>	
				<button data-id="<?= $result['id'];?>" 
				data-values="'<?= json_encode($result);?>'"
				class="btn btn-sm btn-primary copyBtn">Copy</button>
				|| 
				<a href="javascript:void(0)" data-id="<?= $result['id'];?>" 
				data-values="'<?= json_encode($result);?>'"
				onclick="printWA(<?= $result['id'];?>)"
				class="link">Print</a>
			</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>
<textarea id="resEstimateDataXYZ"></textarea>	

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	bindEditTransporter();

	bindCopyBtn();

	$("#print-transporter-btn").on('click', function(e){
		print_transport_list();
	})
})

function bindCopyBtn()
{
	var all = '<?= str_replace("'", " ", json_encode($results));?>)',
		selId = 0,
		activeItem = {};

	$(".copyBtn").on('click', function(e) {
		selId = $(e.target).attr('data-id');
		getWAById(selId);
	});
}

function getWAById(id)
{
	$.ajax(
	{
    	type: "POST",
    	dataType: 'JSON',
     	url: "<?php echo site_url();?>/ajax/getWAById", 
     	data : { "id" :id },
     	success: function(data)
     	{
     		if(data.status == true)
			{
				actualCopy(data.result);
				return ;
			}
			else
			{
				alert('something went wrong!');
			}
		}
    });	
}


function fillBoxGEstimateDetalis()
{

}

function actualCopy(activeItem)
{
	openPopupBoxGEstimate();

	console.log(activeItem);

	$("#cname").val(activeItem.customer);
	$("#ctitle").val(activeItem.title);
	$("#cjprocess").val(activeItem.process);
	$("#cjprocessType").val(activeItem.procsss_time);
	$("#cjprocessTime").val(activeItem.delivery_time);

	$("#cjSubTotalAmt").val(activeItem.sub_total);
	$("#cjpacking").val(activeItem.pack_forward);
	$("#cjtby").val(activeItem.transport_by);
	$("#cjtbyRs").val(activeItem.transport_cost);

	$("#cjgst").val(activeItem.gst);
	$("#cjTotalAmt").val(activeItem.total);

	$("#cjtPayby").val(activeItem.pay_by);
	$("#cpayment").val(activeItem.payment);
	
	$("#cjexnotes").val(activeItem.extra_notes);
	$("#e_valid_till").val(activeItem.validity_days);
	$("#e_approx_delivery").val(activeItem.approx_delivery_days);
	$("#cnotes").val(activeItem.details);
	$("#cnotes_b").val(activeItem.details_b);

	$("#cjnotes").val((activeItem.job_notes).split(','));

	fillBoxGEstimateDetalis(activeItem);
	return ;

	payment1 = '\n\n *- Payment Terms:' + activeItem.payment + '*';
	cjprocess1 = '\n *- PROCESS: ' + activeItem.process + ' WORKING '+ activeItem.procsss_time + ' ' + ' + Delivery Time Extra' +'*';
	cjpacking1 = '\n *- Packing Forwarding RS. ' + activeItem.pack_forward + '*';
	cjtPayby1 = ' PAID By:' + activeItem.pay_by;
	var cjTotalAmt1 = '';
	var cjexnotes1 = '';
	var cjtby1 = '';
	var cjgst1 = '';
	var cjnotes1 = '';
	

	if(activeItem.transport_cost != '0')
	{
		cjtby1 = '\n *- Transportation By: ' + activeItem.transport_by + ' RS. ' + activeItem.transport_cost + cjtPayby1 +'*';
	}
	else
	{
		cjtby1 = '\n *- Transportation By: ' + activeItem.transport_by + ' ' + cjtPayby1 + '*';
	}

	if(activeItem.gst.toLowerCase() != 'extra')
	{	
		cjgst1 = '\n *- GST: ' + activeItem.gst + '% *';
	}
	else
	{
		cjgst1 = '\n *- GST: EXTRA*';	
	}
		
	
	if(activeItem.job_notes != '0' )
	{
		cjnotes1 = '\n *' + activeItem.job_notes + '*';
	}

	if(activeItem.extra_notes.length > 0 )
	{
		cjexnotes1 = '\n\n *Note:* ' + activeItem.extra_notes;
	}

	if(activeItem.total != '0' )
	{
		cjTotalAmt1 = '\n\n *TOTAL Amount RS. ' + activeItem.total + '*';
	}


	$("#resEstimateDataXYZ").val(
		'*'+ activeItem.customer +'*'+ '\n \n*'+ activeItem.title + '*\n\n'
		+ activeItem.details
		+  '\n'
		+ cjprocess1.toUpperCase() 
		+ cjpacking1.toUpperCase() 
		+ cjtby1.toUpperCase() 
		+ cjgst1.toUpperCase() 
		+ cjTotalAmt1.toUpperCase() 
		+ payment1.toUpperCase() 
		+ cjnotes1.toUpperCase() 
		+ cjexnotes1.toUpperCase()
		+ cnoteTerms.toUpperCase());

		//alert("Estimations Copied Successfully.");


		
}

function bindEditTransporter()
{
	$(".edit-transporter").on('click', function(e)
	{
		edit_transporter(e.target);
	});

	$(".copy-transporter").on('click', function(e)
	{
		copy_transporter(e.target);
	});

	$(".add-new").on('click', function(e)
	{
		add_transporter(e.target);
	})
}
            $(function() {
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                    "iDisplayLength": 50,
                    aaSorting: [[0, 'desc']]
                });
            });

 function delete_transport(id) {
	 var sconfirm = confirm("Do You want to Delete Transporter ?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	 jQuery("#transporter_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_transporter_delete", 
         data : { "id" :id },
         success: 
              function(data){
				  
			 }
          });	
 }

function edit_transporter(element)
{
	var data = JSON.parse($(element).attr('data-details'));
	$("#transportModalPopup").modal('show');

	$("#title").val(data.title);
	$("#full_address").val(data.full_address);
	$("#contact_number1").val(data.contact_number1);
	$("#contact_number2").val(data.contact_number2);
	$("#transport_id").val(data.id);
	$("#google_map").val(data.google_map);
	$("#cities").val(data.cities);
	$("#approx_fare").val(data.approx_fare);
}

function copy_transporter(element)
{
	var data = JSON.parse($(element).attr('data-details'));

	var otherContact = '',
		googleMap 	 = '';

	if(data.contact_number2.length > 0 )
	{
		otherContact = '\n\n' + '*Other Contact:* ' + data.contact_number2;
	}

	console.log(data.google_map);
	if(data.google_map.length > 0 )
	{
		googleMap = '\n\n' + '*Map:* ' + data.google_map;
		console.log('inside');
	}

	$("#copyTransporterData").val(
		'*Name:* ' + data.title
		+ '\n\n' + '*Address:* ' + data.full_address
		+ '\n\n' + '*Contact:* ' + data.contact_number1
		+ otherContact
		+ googleMap
	);
	$("#copyTransporterData").select();
	document.execCommand('copy');
}

function add_transporter()
{
	$("#transporterModalPopupAdd").modal('show');
	$("#add_title").val('');
	$("#add_approx_fare").val('');
	$("#add_cities").val('');
	$("#add_full_address").val('');
	$("#add_contact_number1").val('');
	$("#add_contact_number2").val('');
}

function updateTransport()
{
	$("#transportModalPopup").modal('hide');
	$.ajax(
	{
        type: "POST",
        url: "<?php echo site_url();?>/ajax/ajax_transport_update", 
        data : {
			"title" : 				$("#title").val(),
			"full_address" : 		$("#full_address").val(),
			"contact_number1" : 	$("#contact_number1").val(),
			"contact_number2" : 	$("#contact_number2").val(),
			"google_map" : 			$("#google_map").val(),
			"cities" : 				$("#cities").val(),
			"approx_fare" : 		$("#approx_fare").val(),
			"transport_id" : 		$("#transport_id").val(),
		},
        success: function(data)
        {
        	alert("Transporter Updated Successfully.");
        	window.location.reload();
		}
    });
}


function addTransporter()
{
	$("#transporterModalPopupAdd").modal('hide');
	$.ajax(
	{
        type: "POST",
        url: "<?php echo site_url();?>/ajax/ajax_transporter_add", 
        data : {
			"title" : 				$("#add_title").val(),
			"full_address" : 		$("#add_full_address").val(),
			"contact_number1" : 	$("#add_contact_number1").val(),
			"contact_number2" : 	$("#add_contact_number2").val(),
			"google_map" : 			$("#add_google_map").val(),
			"cities" : 				$("#add_cities").val(),
			"approx_fare" : 		$("#add_approx_fare").val(),
		},
        success: function(data)
        {
        	alert("Transporter Added Successfully.");
        	window.location.reload();
		}
    });
}


function print_transport_list() {

	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_print_transporter_list/",
         data : {
         	'all': 1
         }, 
         success: 
            function(data){
            	window.open(data);
	        }
          });

}


function printWA(id)
{
	console.log(id);
	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/generateWA/"+id,
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
</script>
