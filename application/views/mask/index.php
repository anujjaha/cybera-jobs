<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<h4> Mask List</h4>
<a href="<?php echo site_url();?>mask/add">Add New Mask</a>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Title</th>
		<th>Stock IN</th>
		<th>Stock Out</th>
		<th>Damange</th>
		<th>Gift</th>
		<th>Sample</th>
		<th>In Hand</th>
		<th>Created At</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($masks as $mask) { 
			//pr($mask);
			?>
		<tr id="task_<?php echo $mask['id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $mask['name'];?></td>
			<td>
				<a href="<?= site_url();?>mask/in/<?= urlencode(str_replace(" ", "_2_", $mask['name']));?>">
					<?php echo $mask['totalInQty'];?>
				</a>
			<td>
				<a href="<?= site_url();?>user/mask/<?= str_replace(" ", "_2_", $mask['name']);?>">
					<?php echo $mask['totalOutQty'];?>
				</a>
			</td>
			<td><?php echo $mask['totalDamage'];?></td>
			<td><?php echo $mask['totalGift'];?></td>
			<td><?php echo $mask['totalSample'];?></td>
			<td>
				<?php 
					$inHand = $mask['totalInQty'] - $mask['totalOutQty'] - $mask['totalDamage'] - $mask['totalGift'] - $mask['totalSample'];
					if($inHand > 0)
					{
						echo '<span class="green">'. $inHand .'</span>';
					}
					else
					{
						echo '<span class="red">'. $inHand .'</span>';
					}
				?>
			</td>
			<td><?php echo date("d-m-Y H:i A",strtotime($mask['created_at']));?></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->

	<hr />
	<h2>Mask STOK In List</h2>
	<div class="box">
		<div class="box-body table-responsive" id="job_datatable">
			<table id="example2" class="example1 table table-bordered table-striped">
			<thead>
			<tr>
			<th>Sr</th>
			<th>Name</th>
			<th>Qty</th>
			<th>Price</th>
			<th>Created By</th>
			<th>Notes</th>
			<th>Created At</th>
			<th>Action</th>
			</tr>
			</thead>
		<tbody>
			<?php
			$sr =1;	
			foreach($allMasks as $mask) { 
				//pr($mask);
				?>
			<tr id="mask_<?php echo $mask['id'];?>">
				<td><?php echo $sr;?></td>
				<td><?php echo $mask['name'];?></td>
				<td><?php echo $mask['qty'];?></td>
				<td><?php echo $mask['price'];?></td>
				<td><?php echo $mask['nickname'];?></td>
				<td><?php echo $mask['notes'];?></td>
				<td><?php echo date("d-m-Y H:i A",strtotime($mask['created_at']));?></td>
				<td>
					<a href="javascript:void(0);" onclick="delete_mask(<?php echo $mask['id'];?>);"> Delete </a>
				</td>
			</tr>
			<?php $sr++; } ?>
		</tfoot>
		</table>
		</div><!-- /.box-body -->
		</div><!-- /.box -->



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
