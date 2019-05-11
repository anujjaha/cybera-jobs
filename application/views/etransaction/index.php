<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>etransaction/add">
		Add New Transaction
	</a>
	</div>
</div>

<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Name</th>
		<th>Mobile</th>
		<th>Total Credited</th>
		<th>Total Debited</th>
		<th>Current Balance</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($items as $item) { 
			?>
		<tr id="emp-<?php echo $item['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo $item['name'];?></td>
		<td><?php echo $item['mobile'];?></td>
		<td><?php echo $item['creditBalance'];?></td>
		<td><?php echo $item['debitBalance'];?></td>
		<td><?php 
			echo $item['creditBalance'] - $item['debitBalance'];
			?></td>
		<td>
			<a href="<?php echo site_url();?>etransaction/view/<?php echo $item['emp_id'];?>">View All</a>
		</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
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
            
function deleteEmployee(id) {
	var status = confirm("Do You want to Delete Employee ?");
	if(status) {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/employee/deleteEmployee/", 
         data:{'id':id},
         dataType: 'JSON',
         success: function(data)
         {	
			 if(data.status == true)
			  {
				 jQuery("#emp-" + id).hide();
			  }
		}
          });
    }
}
</script>

