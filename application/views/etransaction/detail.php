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
		<table class="example2 table table-bordered table-striped">
			<tr>
				<td colspan="2" align="center">
					<h4>Employee Details</h4>
				</td>
			</tr>
			<tr>
				<td>Name : <?php echo $employee->name;?></td>
				<td>Mobile : <?php echo $employee->mobile;?></td>
			</tr>
		</table>
		<hr>
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Amount Credited</th>
		<th>Amount Debited</th>
		<th>Self</th>
		<th>Balance</th>
		<th>Salary</th>
		<th>Bonus</th>
		<th>Penalty</th>
		<th>Description</th>
		<th>Notes</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$totalCredit = 0;
		$totalDebit = 0;
		$totalSelf = 0;

		foreach($items as $item) { 
			$totalCredit 	= $totalCredit + $item['amount_added'];
			$totalDebit 	= $totalDebit + $item['amount_removed'];
			$totalSelf 		= $totalSelf + $item['employee_redeem'];
			$lastBalance	= $item['current_balance'];
		?>
		<tr id="emp-<?php echo $item['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo $item['amount_added'];?></td>
		<td><?php echo $item['amount_removed'];?></td>
		<td><?php echo $item['employee_redeem'];?></td>
		<td><?php echo $item['current_balance'];?></td>
		<td align="center">
			<?php
				echo $item['is_salary'] == 1 ? '<span class="success"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>' : '';
			?>
		</td>
		<td align="center">
			<?php
				echo $item['is_bonus'] == 1 ? '<span class="success"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>' : '';
			?>
		</td>
		<td align="center">
			<?php
				echo $item['is_penalty'] == 1 ? '<span class="success"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>' : '';
			?>
		</td>
		<td><?php echo $item['description'];?></td>
		<td><?php echo $item['notes'];?></td>
		</tr>
		<?php $sr++; } ?>
	</tbody>
	<tfoot>
		<td>-</td>
		<td align="center">
			<?php echo $totalCredit;?>
		</td>

		<td align="center">
			<?php echo $totalDebit;?>
		</td>

		<td align="center">
			<?php echo $totalSelf;?>
		</td>
		<td align="center">
				<?php echo $lastBalance;?>
		</td>
		
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
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

