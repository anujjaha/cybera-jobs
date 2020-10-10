<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<h4><?= $title;?></h4>
<a href="<?php echo site_url();?>cloth/add_vendor">Add New Vendor</a>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
			<th>Sr</th>
			<th>GSTN</th>
			<th>Company</th>
			<th>Name</th>
			<th>Mobile</th>
			<th>Contact</th>
			<th>Address</th>
			<th>Pincode</th>
			<th>Notes</th>
			<th>Status</th>
			<th>Created At</th>
			<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr = 1;	
		foreach($vendors as $vendor)
		{ 
			//pr($mask);
		?>
		<tr id="task_<?php echo $vendor['id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $vendor['gstn'];?></td>
			<td><?php echo $vendor['company'];?></td>
			<td><?php echo $vendor['name'];?></td>
			<td><?php echo $vendor['mobile'];?></td>
			<td><?php echo $vendor['contact'];?></td>
			<td><?php echo $vendor['address_1'] . ' '. $vendor['address_2'] . ' ' . $vendor['city'] . ' ' . $vendor['state']  ;?></td>
			<td><?php echo $vendor['zip'];?></td>
			<td><?php echo $vendor['notes'];?></td>
			<td><?php echo $vendor['status'] == 1 ? 'Active' : 'Blocked';?></td>
			<td><?php echo date("d-m-Y H:i A",strtotime($vendor['created_at']));?></td>
			<td>
				<?php
					if($vendor['status'] == 1)
					{
				?>
					<a href="<?= site_url();?>cloth/vendor_block/<?= $vendor['id'];?>">	
						Block
					</a>
				<?php
					}
					else
					{
				?>
					<a href="<?= site_url();?>cloth/vendor_unblock/<?= $vendor['id'];?>">	
						Un Block
					</a>
				<?php
					}
				?>
			</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
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
                    "bDestroy": true,
                    "iDisplayLength": 50
                });

                $('#example2').dataTable({
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
 function delete_task(id) {
	 var sconfirm = confirm("Do You want to Delete Mask ?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	 jQuery("#task_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_mask_delete", 
         data : { "id" :id },
         success: 
              function(data){
				  
			 }
          });	
 }

 function delete_mask(id) {
	 var sconfirm = confirm("Are you sure, you want to Delete Mask In Qty?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	 jQuery("#mask_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_mask_delete", 
         dataType: 'JSON',
         data : { "id" :id },
         success: 
            function(data)
            {
				if(data.status == true)		  
				{
					alert("Backup created and Mask QTY Removed");
				}
				else{
					alert("Something went wrong, unable to delete");
				}

			}
          });	
 }
 </script>
