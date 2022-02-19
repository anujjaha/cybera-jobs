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
<h4>Manage Transporters</h4>
<!-- <a href="<?php echo site_url();?>/menu/add">Add New Menu</a> -->

<a href="javascript:void(0);" class="add-new">Add New Transport</a>
<button class="btn btn-primary" id="print-transporter-btn" style="margin-left: 20px; ">Print Transport</button>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Title</th>
		<th>Full Address</th>
		<th>Contact 1</th>
		<th>Contact 2</th>
		<th>Approx Fare</th>
		<th>Cities</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($results as $result)
		 { 
			?>
		<tr id="transporter_<?php echo $result['id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $result['title'];?></td>
			<td><?php echo $result['full_address'];?></td>
			<td><?php echo $result['contact_number1'];?></td>
			<td><?php echo $result['contact_number2'];?></td>
			<td><?php echo $result['approx_fare'];?></td>
			<td><?php echo $result['cities'];?></td>
			<td>
				<a class="btn btn-sm copy-transporter" data-details='<?= json_encode($result);?>' href="javascript:void(0);"> Copy </a>
				||
				<a class="btn btn-sm edit-transporter" data-details='<?= json_encode($result);?>' href="javascript:void(0);"> Edit </a>
				||
				<a href="javascript:void(0);" onclick="delete_transport(<?php echo $result['id'];?>);"> Delete </a>
			</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>
	<textarea id="copyTransporterData" name="copyTransporterData"></textarea>
	<!-- MOdal BOx for Bills -->
	<div id="transportModalPopup" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Update Transport</h4>
	      </div>
	      <div class="modal-body">
	      	<form accept="" action="#" method="post">
			<div class="box-body">
				<div class="form-group">
					<label>Title</label>
					<input type="text" class="form-control" name="title" id="title" placeholder="title" value="" required="required">
				</div>

				<div class="form-group">
					<label>Full Address</label>
					<input type="text" class="form-control" name="full_address" id="full_address" placeholder="Full Address" value="">
				</div>

				<div class="form-group">
					<label>Contact</label>
					<input type="text" class="form-control" name="contact_number1" id="contact_number1" placeholder="Contact" value="">
				</div>

				<div class="form-group">
					<label>Other Contact</label>
					<input type="text" class="form-control" name="contact_number2" id="contact_number2" placeholder="Other Contact" value="">
				</div>

				<div class="form-group">
					<label>Google Map</label>
					<input type="text" class="form-control" name="google_map" id="google_map" placeholder="Google Map Link" value="">
				</div>

				<div class="form-group">
					<label>Approx Fare</label>
					<input type="text" class="form-control" name="approx_fare" id="approx_fare" placeholder="Approx Fare" value="">
				</div>

				<div class="form-group">
					<label>Cities</label>
					<textarea class="form-control" name="cities" id="cities"></textarea>
				</div>
			</div>
				<input type="hidden" name="transport_id" id="transport_id">
			</form>
	      </div>
	      <div class="modal-footer">
			 <button type="button" class="btn btn-primary " onclick="updateTransport()">Update</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

	<!-- MOdal BOx for Bills -->
	<div id="transporterModalPopupAdd" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">New Transporter</h4>
	      </div>
	      <div class="modal-body">
	      	<form accept="" action="#" method="post">
			<div class="box-body">
				<div class="form-group">
					<label>Title</label>
					<input type="text" class="form-control" name="add_title" id="add_title" placeholder="Title" value="" required="required">
				</div>

				<div class="form-group">
					<label>Full Address</label>
					<textarea class="form-control" name="add_full_address" id="add_full_address" required="required"></textarea>
				</div>

				<div class="form-group">
					<label>Contact Number1</label>
					<input type="text" class="form-control" name="add_contact_number1" id="add_contact_number1" placeholder="Contact Number" value="" required="required">
				</div>

				<div class="form-group">
					<label>Other Contact</label>
					<input type="text" class="form-control" name="add_contact_number2" id="add_contact_number2" placeholder="Other Contact" value="">
				</div>

				<div class="form-group">
					<label>Google MAP</label>
					<input type="text" class="form-control" name="add_google_map" id="add_google_map" placeholder="Google Map" value="">
				</div>

				<div class="form-group">
					<label>Approx Fare</label>
					<input type="text" class="form-control" name="add_approx_fare" id="add_approx_fare" placeholder="Approx Fare" value="">
				</div>

				<div class="form-group">
					<label>Cities</label>
					<textarea class="form-control" name="add_cities" id="add_cities"></textarea>
				</div>
			</div>
			</form>
	      </div>
	      <div class="modal-footer">
			 <button type="button" class="btn btn-primary " onclick="addTransporter()">Add New Transporter</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	bindEditTransporter();

	$("#print-transporter-btn").on('click', function(e){
		print_transport_list();
	})
})

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
                    "iDisplayLength": 50
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
</script>
