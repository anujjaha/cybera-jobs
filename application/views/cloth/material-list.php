<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<h4><?= $title;?></h4>
<a href="<?php echo site_url();?>cloth/add_material">Add New Material</a>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
			<th>Sr</th>
			<th>Category</th>
			<th>Title</th>
			<th>Material Type</th>
			<th>GSM</th>
			<th>Color</th>
			<th>Collar Type</th>
			<th>KG</th>
			<th>Cost</th>
			<th>Ratio</th>
			<th>Paid</th>
			<th>Notes</th>
			<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr = 1;	
		foreach($materials as $material)
		{ 
			//pr($mask);
		?>
		<tr id="task_<?php echo $material['id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $material['category'];?></td>
			<td><?php echo $material['title'];?></td>
			<td><?php echo $material['material_type'];?></td>
			<td><?php echo $material['gsm'];?></td>
			<td><?php echo $material['color'];?></td>
			<td><?php echo $material['collar_type'];?></td>
			<td><?php echo $material['total_kg'];?></td>
			<td><?php echo $material['total_cost'];?></td>
			<td><?php echo $material['approx_ratio'];?></td>
			<td><?php echo $material['paid_by'];?></td>
			<td><?php echo $material['notes'];?></td>
			<td>
				<a href="<?= site_url();?>cloth/delete_material/<?= $material['id'];?>">	
					Delete
				</a>
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
