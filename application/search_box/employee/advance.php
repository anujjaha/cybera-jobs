<?php
if(isAdmin())
{
?>
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>employee/add_advance">
		Add New Advance
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
		<th>Salary</th>
		<th>Max Limit</th>
		<th>Advance</th>
		<th>Date</th>
		<th>Notes</th>
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
		<td><?php echo $item['salary'];?></td>
		<td><?php echo $item['max_limit'];?></td>
		<td><?php echo $item['advance'];?></td>
		<td><?php echo date('d-m-Y', strtotime($item['date']));?></td>
		<td><?php echo $item['notes'];?></td>
		
		<td>
			<a href="javascript:void(0);" class="delete-advance" data-id="<?php echo $item['id'];?>">
				Delete
			</a> 
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

                jQuery(".delete-advance").on('click', function(e)
                {
                	var advanceId = e.target.getAttribute('data-id');
                	deleteAdvance(advanceId);
                });
            });
            
function deleteAdvance(id) {
	var status = confirm("Do You want to Delete Advance Entry ?");
	if(status) {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/employee/deleteEmployeeAdvance/", 
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

<?php
}
?>
