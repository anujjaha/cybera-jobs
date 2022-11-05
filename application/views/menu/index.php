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
<h4>Manage Restaurant Menu</h4>
<!-- <a href="<?php echo site_url();?>/menu/add">Add New Menu</a> -->

<a href="javascript:void(0);" class="add-new">Add New Menu</a>
<button class="btn btn-primary" id="print-menu-btn" style="margin-left: 20px; ">Print Menu</button>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Code</th>
		<th>Short Name</th>
		<th>Menu Name</th>
		<th>Qty</th>
		<th>Rate Per pcs.</th>
		<th>Price for Additonal Pages</th>
		<th>Working Days</th>
		<th>Sequence</th>
		<th>Created At</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($menus as $menu)
		 { 
			?>
		<tr id="book_<?php echo $menu['id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $menu['code'];?></td>
			<td><?php echo $menu['short_name'];?></td>
			<td><?php echo $menu['title'];?></td>
			<td><?php echo $menu['qty'];?></td>
			<td><?php echo $menu['price'];?></td>
			<td><?php echo $menu['extra'];?></td>
			<td><?php echo $menu['working_days'];?></td>
			<td><?php echo $menu['sequence'];?></td>
			<td><?php echo date("d-m-Y H:i A",strtotime($menu['created_at']));?></td>
			<td>
				<a class="btn btn-sm edit-menu" data-details='<?= json_encode($menu);?>' href="javascript:void(0);"> Edit </a>
				||
				<a href="javascript:void(0);" onclick="delete_menu(<?php echo $menu['id'];?>);"> Delete </a>
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

				<div class="form-group">
					<label>Notes</label>
					<textarea class="form-control" name="notes" id="notes" ></textarea>
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
	        <h4 class="modal-title">New Menu</h4>
	      </div>
	      <div class="modal-body">
	      	<form accept="" action="#" method="post">
			<div class="box-body">
				<div class="form-group">
					<label>Code</label>
					<input type="text" class="form-control" name="add_code" id="add_code" placeholder="Code" value="" required="required">
				</div>

				<div class="form-group">
					<label>Short Name</label>
					<input type="text" class="form-control" name="add_short_name" id="add_short_name" placeholder="Add Short Name" value="" required="required">
				</div>

				<div class="form-group">
					<label>Menu Name</label>
					<input type="text" class="form-control" name="add_title" id="add_title" placeholder="Title" value="" required="required">
				</div>

				<div class="form-group">
					<label>Qty</label>
					<input type="number" class="form-control" name="add_qty" id="add_qty" placeholder="Quantity" value="0" step="1" required="required">
				</div>

				<div class="form-group">
					<label>Rate</label>
					<input type="number" class="form-control" name="add_price" id="add_price" placeholder="Price" value="0" step="1" required="required">
				</div>

				<div class="form-group">
					<label>Extra</label>
					<input type="text" class="form-control" name="add_extra" id="add_extra" placeholder="Extra Pages" value="" required="required">
				</div>

				<div class="form-group">
					<label>Working Days</label>
					<input type="text" class="form-control" name="add_working_days" id="add_working_days" placeholder="Working Days" value="" required="required">
				</div>

				<div class="form-group">
					<label>Notes</label>
					<textarea class="form-control" name="add_notes" id="add_notes" placeholder="Note"></textarea>
				</div>

			</div>
			</form>
	      </div>
	      <div class="modal-footer">
			 <button type="button" class="btn btn-primary " onclick="addMenu()">Add New Menu</button>
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	bindEditMenu();

	$("#print-menu-btn").on('click', function(e){
		print_menu_list();
	})
})

function bindEditMenu()
{
	$(".edit-menu").on('click', function(e)
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

 function delete_menu(id) {
	 var sconfirm = confirm("Do You want to Delete Restaurant Menu ?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	 jQuery("#book_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_menu_delete", 
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
	$("#notes").val(data.notes);
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
	$("#add_extra").val('');
	$("#add_notes").val('');
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
			"extra" : 	$("#extra").val(),
			"notes" : 	$("#notes").val(),
			"working_days" : 	$("#working_days").val(),
			"menu_id" : $("#menu_id").val()
		},
        success: function(data)
        {
        	alert("Menu Updated Successfully.");
		}
    });
}


function addMenu()
{
	$("#menuModalPopupAdd").modal('hide');
	$.ajax(
	{
        type: "POST",
        url: "<?php echo site_url();?>/ajax/ajax_menu_add", 
        data : {
			"code" : 	$("#add_code").val(),
			"short_name" : 	$("#add_short_name").val(),
			"title" : 	$("#add_title").val(),
			"qty" : 	$("#add_qty").val(),
			"price" : 	$("#add_price").val(),
			"extra" : 	$("#add_extra").val(),
			"notes" : 	$("#add_notes").val(),
			"working_days" : 	$("#add_working_days").val(),
			"menu_id" : $("#add_menu_id").val()
		},
        success: function(data)
        {
        	alert("Menu Added Successfully.");
        	window.location.reload();
		}
    });
}


function print_menu_list() {

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
</script>
