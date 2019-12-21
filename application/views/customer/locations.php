<?php
//pr($locations);
?>
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />


<div class="row" style="margin-bottom: 10px;">

<div class="col-md-6 ">
	<a href="javascript:void(0);" id="addNewLocation">
		Add New Location
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
		<th>Name</th>
		<th>Mobile</th>
		<th>Email</th>
		<th>Add1</th>
		<th>Add2</th>
		<th>City</th>
		<th>State</th>
		<th>PIN</th>
		<th>Default</th>
		<th>Created At</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($locations as $location)
		{ 
		?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $location['location_name'];?></td>
		<td><?php echo $location['mobile'];?></td>
		<td><?php echo $location['email'];?></td>
		<td><?php echo $location['add1'];?></td>
		<td><?php echo $location['add2'];?></td>
		<td><?php echo $location['city'];?></td>
		<td><?php echo $location['state'];?></td>
		<td><?php echo $location['pin'];?></td>
		<td><?php echo $location['is_default'] == 1 ? "Yes" : "-";?></td>
		<td><?php echo date('m-d-Y', strtotime($location['created_at']));?></td>
		<td>
			<?php
				if($location['is_default'] != 1)
				{
			?>
			<a href="javascript:void(0);" class="set-default" data-id="<?php echo $location['id'];?>">
				Set Default
			</a>
			||
			<?php 
				}
			?>
			<a href="javascript:void(0);"  class="delete-add" data-id="<?php echo $location['id'];?>">
				Delete
			</a>
		</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	<input type="hidden" name="customerId" id="customerId" value="<?php echo $customer->id;?>">
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


jQuery('#addNewLocation').on('click', function()
{
	jQuery("#locationModalBox").modal('show');
	resetPopUpBox();
});


jQuery(document).on('click', '#save-address', function()
{
	saveAddress();
})


jQuery('.set-default').on('click', function(event)
{
	setDefaultAddress(event.target.getAttribute('data-id'));
})

jQuery('.delete-add').on('click', function(event)
{
	deleteAddress(event.target.getAttribute('data-id'));
})

function resetPopUpBox()
{
	document.getElementById('name').value 		= '';
	document.getElementById('mobile').value 	= '';
	document.getElementById('email').value 		= '';
	document.getElementById('add1').value 		= '';
	document.getElementById('add2').value 		= '';
	document.getElementById('city').value 		= '';
	document.getElementById('state').value 		= '';
	document.getElementById('pin').value 		= '';
}

function saveAddress(element)
{
	var customerId  = document.getElementById('customerId').value,
		name 		= document.getElementById('name').value,
		mobile 		= document.getElementById('mobile').value,
		email 		= document.getElementById('email').value,
		add1 		= document.getElementById('add1').value,
		add2 		= document.getElementById('add2').value,
		city		= document.getElementById('city').value,
		state 		= document.getElementById('state').value,
		pin 		= document.getElementById('pin').value;


		$.ajax(
	    {
	     	type: "POST",
	     	dataType: 'JSON',
	     	data: {
	     		customerId: customerId,
	     		name: 		name,
	     		mobile: 	mobile,
	     		email: 		email,
	     		add1: 		add1,
	     		add1: 		add2,
	     		city: 		city,
				state: 		state,
				pin: 		pin
	     	},
	     	url: "<?php echo site_url();?>ajax/saveCustomerLocation", 
	     	success:  function(data)
	        {
	        	if(data.status == true)
	        	{
	        		swal("Yeah!", "Location Saved Successfully!", "success");
	        		jQuery("#locationModalBox").modal('hide');

	        		location.reload();
	        		return;
	        	}

	        	jQuery("#locationModalBox").modal('hide');
	        	swal("Oh!", "Please Try Again ", "error");
	        }
	  });
}

function setDefaultAddress(addressId)
{
	var customerId = document.getElementById('customerId').value;

	$.ajax({
         type: "POST",
         dataType: 'JSON',
         url: "<?php echo site_url();?>/ajax/setDefaultAddress",
         data : {
         	customerId: customerId,
         	addressId: 	addressId
         }, 
         success: 
            function(data)
            {
            	console.log(data);
            	if(data.status == true)
            	{
            		swal("Yeah!", "Location set Default Successfully!", "success");
            			
            		setTimeout(function()
            		{
            			location.reload();
            		}, 1000);
            		return;
            	}

            	swal("Oh!", "Please Try Again ", "error");	
	        }
         });

}

function deleteAddress(addressId)
{
	var customerId = document.getElementById('customerId').value;

	$.ajax({
         type: "POST",
         dataType: 'JSON',
         url: "<?php echo site_url();?>/ajax/deleteAddress",
         data : {
         	customerId: customerId,
         	addressId: 	addressId
         }, 
         success: 
            function(data)
            {
            	if(data.status == true)
            	{
            		swal("Yeah!", "Location deleted Successfully!", "success");
            			
            		setTimeout(function()
            		{
            			location.reload();
            		}, 1000);
            		
            		return;
            	}

            	swal("Oh!", "Please Try Again ", "error");	
	        }
         });

}
</script>





<!-- Modal -->
  <div class="modal fade" id="locationModalBox" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Location</h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="form-group col-md-6">
        			<label>Location Name : </label>
        			<input type="text" class="form-control" name="name" id="name" required="required">
        		</div>

        		<div class="form-group col-md-6">
        			<label>Moblie/Phone : </label>
        			<input type="text" class="form-control" name="mobile" id="mobile" required="required">
        		</div>

        		<div class="form-group col-md-6">
        			<label>Email : </label>
        			<input type="email" class="form-control" name="email" id="email">
        		</div>
        			
        		<div class="form-group col-md-6">
        			<label>Address 1 : </label>
        			<input type="text" class="form-control" name="add1" id="add1" required="required">
        		</div>

        		<div class="form-group col-md-6">
        			<label>Address 2 : </label>
        			<input type="text" class="form-control" name="add2" id="add2">
        		</div>

        		<div class="form-group col-md-6">
        			<label>City : </label>
        			<input type="text" class="form-control" name="city" id="city" required="required">
        		</div>

        		<div class="form-group col-md-6">
        			<label>State : </label>
        			<input type="text" class="form-control" name="state" id="state" required="required">
        		</div>

        		<div class="form-group col-md-6">
        			<label>PIN : </label>
        			<input type="text" class="form-control" name="pin" id="pin">
        		</div>

        	</div>
        </div>
        <div class="modal-footer">
        	
        	<button type="button" class="btn btn-info" id="save-address">Save</button>
         	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>