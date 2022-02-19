<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>expense/add">
		Add New Expense
	</a>
	</div>
</div>

<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Date</th>
		<th>Category</th>
		<th>Title</th>
		<th>Amount</th>
		<th>Receipt</th>
		<th>Description</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$total = 0;
		foreach($items as $item) 
		{ 
			$total = $total + $item['amount'];
		?>
		<tr id="expense-<?php echo $item['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo  date('d-m-Y', strtotime($item['created_at']));?></td>
		<td><?php echo  getExpenseCategory($item['category_id']);?></td>
		<td><?php echo  $item['title'];?></td>
		<td><?php echo  $item['amount'];?></td>
		<td><?php echo  $item['receipt'];?></td>
		<td><?php echo  $item['description'];?></td>
		<td>
				<a href="<?php echo site_url();?>/expense/edit/<?php echo $item['id'];?>">Edit</a>
		</td>
		</tr>
		<?php $sr++; } ?>
	</tbody>
	<tfoot>
		<tr>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td><?php echo $total;?></td>
			<td>-</td>
			<td></td>
			<td></td>
		</tr>
	</tfoot>
	</table>
	</div>
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

