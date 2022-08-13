<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />


<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<h4>Manage Diwali</h4>
<!-- <a href="<?php echo site_url();?>/menu/add">Add New Menu</a> -->

<a href="javascript:void(0);" class="add-new">Add New Customer</a>
<!-- <button class="btn btn-primary" id="print-d-customer-btn" style="margin-left: 20px; ">Print List</button> -->
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Type</th>
		<th>Name</th>
		<th>Company Name</th>
		<th>Mobile</th>
		<th>Email</th>
		<th>Address</th>
		<th>Year Total</th>
		<th>Total</th>
		<th>Details</th>
		<th>GTYPE</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $item)
		 { 
			?>
		<tr id="dcustomer_<?php echo $item['id'];?>">
			<td><?php echo $sr;?></td>
			<td>
				<?php 
					switch($item['ctype'])
					{
						case 1:
							echo "Dealer";
						break;

						case 0:
							echo "Regular";
						break;

						case 3:
							echo "Relation";
						break;
					}
				?>
			</td>
			<td><?php echo $item['name'];?></td>
			<td><?php echo $item['companyname'];?></td>
			<td><?php echo $item['mobile'];?></td>
			<td><?php echo $item['email'];?></td>
			<td><?php echo $item['add1'] . ' '. $item['add2'] . ' '.$item['city'];?></td>
			<td><?php echo 0;?></td>
			<td><?php echo 0;?></td>
			<td><?php echo $item['description'];?></td>
			<td>
				<select data-details='<?= json_encode($item);?>' class="form-control customer-gtype-change" name="gtype_<?= $item['id'];?>" id="gtype_<?= $item['id'];?>">
					<option>Select</option>
					<option <?= $item['gtype'] == 'A' ? 'selected="selected"' : '';?> >A</option>
					<option <?= $item['gtype'] == 'B' ? 'selected="selected"' : '';?> >B</option>
					<option <?= $item['gtype'] == 'C' ? 'selected="selected"' : '';?> >C</option>
				</select>
				<!-- <label>
					<input  class="customer-gtype" type="radio" name="gtype" value="A">A
				</label>
				<label>
					<input  <?= $item['gtype'] == 'B' ? 'selected="selected"' : '';?> data-details='<?= json_encode($item);?>' class="customer-gtype" type="radio" name="gtype" value="B">B
				</label>
				<label>
					<input  <?= $item['gtype'] == 'C' ? 'selected="selected"' : '';?> data-details='<?= json_encode($item);?>' class="customer-gtype" type="radio" name="gtype" value="C">C
				</label> -->
			</td>
			<td>
				<!-- <a class="btn btn-sm edit-d-customer" data-details='<?= json_encode($item);?>' href="javascript:void(0);"> Edit </a>
				|| -->
				<a href="javascript:void(0);" onclick="delete_customer(<?php echo $item['id'];?>);"> Delete </a>
			</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>

	<!-- MOdal BOx for Bills -->
	<div id="menuModalPopup" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Update Menu</h4>
	      </div>
	      <div class="modal-body">
	      	<form accept="" action="#" method="post">
			<div class="box-body">
				<div class="form-group">
					<label>Code</label>
					<input type="text" class="form-control" name="code" id="code" placeholder="Code" value="" required="required">
				</div>

				<div class="form-group">
					<label>Short Name</label>
					<input type="text" class="form-control" name="short_name" id="short_name" placeholder="Short Name" value="" required="required">
				</div>

				<div class="form-group">
					<label>Menu Name</label>
					<input type="text" class="form-control" name="title" id="title" placeholder="Title" value="" required="required">
				</div>

				<div class="form-group">
					<label>Qty</label>
					<input type="number" class="form-control" name="qty" id="qty" placeholder="Quantity" value="0" step="1" required="required">
				</div>

				<div class="form-group">
					<label>Rate</label>
					<input type="number" class="form-control" name="price" id="price" placeholder="Price" value="0" step="1" required="required">
				</div>

				<div class="form-group">
					<label>Extra</label>
					<input type="text" class="form-control" name="extra" id="extra" placeholder="Extra Pages" value="" required="required">
				</div>

				<div class="form-group">
					<label>Working Days</label>
					<input type="text" class="form-control" name="working_days" id="working_days" placeholder="Working Days" value="" required="required">
				</div>
			</div>
				<input type="hidden" name="menu_id" id="menu_id">
			</form>
	      </div>
	      <div class="modal-footer">
			 <button type="button" class="btn btn-primary " onclick="updateMenu()">Update</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

	<!-- MOdal BOx for Bills -->
	<div id="menuModalPopupAdd" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add New Customer</h4>
	      </div>
	      <div class="modal-body">
	      	<form accept="" action="#" method="post">
			<div class="box-body">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="add_name" id="add_name" placeholder="Name" value="">
				</div>

				<div class="form-group">
					<label>Company Name</label>
					<input type="text" class="form-control" name="add_companyname" id="add_companyname" placeholder="Company Name" value="">
				</div>

				<div class="form-group">
					<label>Mobile</label>
					<input type="text" class="form-control" name="add_mobile" id="add_mobile" placeholder="Mobile" value="" required="required">
				</div>

				<div class="form-group">
					<label>Email</label>
					<input type="text" class="form-control" name="add_email" id="add_email" placeholder="Email" value="">
				</div>

				<div class="form-group">
					<label>Address 1</label>
					<input type="text" class="form-control" name="add_add1" id="add_add1" placeholder="Address" value="">
				</div>

				<div class="form-group">
					<label>Address 2</label>
					<input type="text" class="form-control" name="add_add2" id="add_add2" placeholder="Address Other" value="">
				</div>

				<div class="form-group">
					<label>City</label>
					<input type="text" class="form-control" name="add_city" id="add_city" placeholder="Add City" value="">
				</div>

				<div class="form-group">
					<label>State</label>
					<input type="text" class="form-control" name="add_state" id="add_state" placeholder="State" value="">
				</div>

				<div class="form-group">
					<label>POST Code</label>
					<input type="text" class="form-control" name="add_pin" id="add_pin" placeholder="POST Code" value="">
				</div>

				<div class="form-group">
					<label>Type</label>
					<select class="form-control" id="add_ctype" name="add_ctype">
						<option value="0">Regular</option>
						<option value="1">Dealer</option>
						<option value="3">Relation</option>
					</select>
				</div>

				<div class="form-group">
					<label>G Type</label>
					<select  class="form-control" id="add_gtype" name="add_gtype">
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
					</select>
				</div>

				<div class="form-group">
					<label>Notes</label>
					<textarea class="form-control" name="add_notes" id="add_notes"></textarea>
				</div>
			</div>
			</form>
	      </div>
	      <div class="modal-footer">
			 <button type="button" class="btn btn-primary " onclick="addNewCustomer()">Add New Customer</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	bindEditDCustomer();
	bindUpdateGType();

	$("#print-d-customer-btn").on('click', function(e){
		print_d_customer_list();
	})
})

function bindUpdateGType()
{
	$('.customer-gtype-change').on('change', function(e)
	{
		var customerId = JSON.parse($(e.target).attr('data-details')).id;
		update_g_customer(customerId, e.target.value);
	});
}

function bindEditDCustomer()
{
	$(".edit-d-customer").on('click', function(e)
	{
		edit_menu(e.target);
	});

	$(".add-new").on('click', function(e)
	{
		add_menu(e.target);
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

function delete_customer(id) {
	 var sconfirm = confirm("Do You want to Remove Customer ?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	
	jQuery("#dcustomer_"+id).remove();

	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_d_customer_delete", 
         data : { "id" :id },
         success: 
              function(data){
				  
			 }
          });	
 }

function edit_menu(element)
{
	var data = JSON.parse($(element).attr('data-details'));
	$("#menuModalPopup").modal('show');

	$("#code").val(data.code);
	$("#short_name").val(data.short_name);
	$("#title").val(data.title);
	$("#qty").val(data.qty);
	$("#price").val(data.price);
	$("#extra").val(data.extra);
	$("#menu_id").val(data.id);
	$("#working_days").val(data.working_days);
}

function add_menu()
{
	$("#menuModalPopupAdd").modal('show');
	$("#add_code").val('');
	$("#add_short_name").val('');
	$("#add_title").val('');
	$("#add_qty").val('');
	$("#add_price").val('');
	$("#add_price").val('');
	$("#add_extra").val('');
	$("#add_working_days").val('');
	$("#add_menu_id").val('');
}

function updateMenu()
{
	$("#menuModalPopup").modal('hide');
	$.ajax(
	{
        type: "POST",
        url: "<?php echo site_url();?>/ajax/ajax_menu_update", 
        data : {
			"code" : 	$("#code").val(),
			"short_name" : 	$("#short_name").val(),
			"title" : 	$("#title").val(),
			"qty" : 	$("#qty").val(),
			"price" : 	$("#price").val(),
			"price" : 	$("#price").val(),
			"extra" : 	$("#extra").val(),
			"working_days" : 	$("#working_days").val(),
			"menu_id" : $("#menu_id").val()
		},
        success: function(data)
        {
        	alert("Menu Updated Successfully.");
		}
    });
}


function addNewCustomer()
{
	$("#menuModalPopupAdd").modal('hide');
	$.ajax(
	{
        type: "POST",
        url: "<?php echo site_url();?>/ajax/ajax_d_customer_add", 
        data : {
			"name": 		$("#add_name").val(),
			"companyname": 		$("#add_companyname").val(),
			"mobile": 		$("#add_mobile").val(),
			"email": 		$("#add_email").val(),
			"add1": 		$("#add_add1").val(),
			"add2": 		$("#add_add2").val(),
			"city": 		$("#add_city").val(),
			"state": 		$("#add_state").val(),
			"pin": 			$("#add_pin").val(),
			"ctype": 		$("#add_ctype").val(),
			"gtype": 		$("#add_gtype").val(),
			"notes": 		$("#add_notes").val(),
		},
        success: function(data)
        {
        	toastr.success('Customer added.', 'Success.')
        	//window.location.reload();
		}
    });
}


function print_d_customer_list() {

	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_print_menu_list/",
         data : {
         	'all': 1
         }, 
         success: 
            function(data){
            	window.open(data);
	        }
          });

}

function update_g_customer(id, gtype) {
	 $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_d_customer_g_update", 
         data : { 
        	"id" :id,
         	"gtype":gtype
     	},
        success: function(data)
            {
				toastr.success('Customer details updated.', 'Success.')
			}
        });	
 }
</script>


