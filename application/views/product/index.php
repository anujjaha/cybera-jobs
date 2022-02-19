<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<h4>Products</h4>
<a href="<?php echo site_url();?>/product/add">Manage Products</a>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
			<th>Sr</th>
			<th>Title</th>
			<th>Available QTY</th>
			<th>Delete</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($products as $product) { 
			?>
		<tr id="product_<?php echo $product['id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $product['product_title'];?></td>
			<td><?php echo $product['qty'];?></td>
			<td>
				<a href="javascript:void(0);" onclick="delete_product(<?php echo $product['id'];?>);"> Delete </a>
			</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div>
	</div>
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
            });
 function delete_product(id) {
	 var sconfirm = confirm("Do You want to Delete Product?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	 jQuery("#task_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_task_delete", 
         data : { "id" :id },
         success: 
              function(data){
				  
			 }
          });	
 }
 </script>
