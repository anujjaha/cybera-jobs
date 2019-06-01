<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/insurance/add" method="post">
	<div>
		<h3>Add Insurance On : <?php echo date('d-m-Y');?></h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td align="right"> <label>Select Employee : </label></td>
			<td>
				<?php echo getEmployeeSelectBoxForAttendance();?>
			</td>
		</tr>
		<tr>

			<td align="right"> <label>Insurance Type : </label></td>
			<td>
				<select name="insurance_type"  required="required" class="form-control" id="insurance_type">
					<option value="Car">
						Car
					</option>

					<option value="Machine">
						Machine
					</option>

					<option value="Employee Life">
						Employee Life
					</option>

					<option value="Employee Mediclaim">
						Employee Mediclaim
					</option>

					<option value="Office / Asset">
						Office / Asset
					</option>

					<option value="Vehicle">
						Vehicle
					</option>

					<option value="General">
						General
					</option>
				</select>
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Title : </label></td>
			<td>
				<input type="text" name="title" value="<?php echo $record->title;?>" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Amount : </label></td>
			<td> <input type="number" min="0" name="amount" min="0" step="1" value="0" required="required" class="form-control"> </td>
		</tr>

		<tr>
			<td align="right"> <label>Company : </label></td>
			<td>
				<input type="text" name="company" value="<?php echo $record->company;?>" required="required" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Interval ( Renewal ) : </label></td>
			<td>
				<input type="number" min="0" step="1" name="interval" value="<?php echo $record->interval;?>" required="required" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Policy Start Date : </label></td>
			<td>
				<input type="text" name="renewal_date" value="<?php echo isset($record->renewal_date) ? $record->renewal_date : date('m/d/Y');?>" required="required" class="form-control date-picker">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Description : </label></td>
			<td> 
				<textarea name="description" class="form-control"></textarea>
			</td>
		</tr>

		
		<tr>
			<td colspan="5" align="center"> 
				<input type="submit" name="save" class="btn btn-primary" onclick="return confirmSubmit();" value="Save">
				<input type="reset" name="reset" class="btn btn-primary" value="Reset"> 
			</td>
		</tr>
	</table>
</div>
</form>
<script>

jQuery(document).ready(function()
{
	jQuery('#date-picker').datepicker();
});
function confirmSubmit()
{
	var status = confirm("Are You Sure ?");
	
	if(status == true )
	{
		return true;
	}
	
	return false;
}
</script>
