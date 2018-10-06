<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<hr>
	<div>
		<h3> Attendance For <?php echo $employeeInfo->name;?></h3>
	</div>
	</div>
</div>
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Month / Year</th>
		<th>Half Day</th>
		<th>Full Day</th>
		<th>Late</th>
		<th>Office Half Day</th>
		<th>Half Night</th>
		<th>Full Night</th>
		<th>Sunday</th>
		<th>Notes</th>
		<th>Performance</th>
		<th>Remarks</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$sunday = $fullNight = $halfNight = $officehalfDay = $officeLate = $fullDay = $halfDay = 0;
			foreach($items as $item) 
			{ 
				$sunday 		= $sunday + $item['sunday'];
				$fullNight 		= $fullNight + $item['full_night'];
				$halfNight 		= $halfNight + $item['half_night'];
				$officehalfDay 	= $officehalfDay + $item['office_halfday'];
				$officeLate 	= $officeLate + $item['office_late'];
				$fullDay 		= $fullDay + $item['full_day'];
				$halfDay 		= $halfDay +  $item['half_day'];
		?>
		<tr id="emp-<?php echo $item['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo $item['month']. ' ' . $item['year'];?></td>
		<td><?php echo $item['half_day'];?></td>
		<td><?php echo $item['full_day'];?></td>
		<td><?php echo $item['office_late'];?></td>
		<td><?php echo $item['office_halfday'];?></td>
		<td><?php echo $item['half_night'];?></td>
		<td><?php echo $item['full_night'];?></td>
		<td><?php echo $item['sunday'];?></td>
		<td><?php echo $item['notes'];?></td>
		<td><?php echo $item['result'];?></td>
		<td><?php echo $item['personal_notes'];?></td>
		</tr>
		<?php $sr++; } ?>
		<tr>
		 	<td><?php echo $sr; ?></td>
			<td>-</td>
			<td><?php echo $halfDay;?></td>
			<td><?php echo $fullDay;?></td>
			<td><?php echo $officeLate;?></td>
			<td><?php echo $officehalfDay;?></td>
			<td><?php echo $halfNight;?></td>
			<td><?php echo $fullNight;?></td>
			<td><?php echo $sunday;?></td>
			<td> - </td>
			<td> - </td>
			<td> - </td>
		</tr>
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

