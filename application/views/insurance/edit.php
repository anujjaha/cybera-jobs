<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/insurance/edit" method="post">
	<div>
		<h3>Edit Insurance</h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<?php
			if(1==1)
			{
		?>
		<tr>
			<td align="right"> <label>Employee : </label></td>
			<td>
				<?php 
				echo getEmployeeSelectBoxForAttendance();?>
			</td>
		</tr>
		<?php
			}
		?>
		<tr>

			<td align="right"> <label>Insurance Type : </label></td>
			<td>
				<select name="insurance_type"  required="required" class="form-control" id="insurance_type">
					<option <?php echo $record->insurance_type == "Car" ? 'selected="selected"' : '';?> value="Car">
						Car
					</option>

					<option  <?php echo $record->insurance_type == "Machine" ? 'selected="selected"' : '';?> value="Machine">
						Machine
					</option>

					<option  <?php echo $record->insurance_type == "Employee Life" ? 'selected="selected"' : '';?> value="Employee Life">
						Employee Life
					</option>

					<option  <?php echo $record->insurance_type == "Employee Mediclaim" ? 'selected="selected"' : '';?> value="Employee Mediclaim">
						Employee Mediclaim
					</option>

					<option  <?php echo $record->insurance_type == "Office / Asset" ? 'selected="selected"' : '';?> value="Office / Asset">
						Office / Asset
					</option>

					<option  <?php echo $record->insurance_type == "Vehicle" ? 'selected="selected"' : '';?> value="Vehicle">
						Vehicle
					</option>

					<option  <?php echo $record->insurance_type == "General" ? 'selected="selected"' : '';?> value="General">
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
			<td> <input type="number" min="0" name="amount" min="0" step="1" required="required" class="form-control" value="<?php echo $record->amount;?>">  </td>
		</tr>

		<tr>
			<td align="right"> <label>Company : </label></td>
			<td>
				<input type="text" name="company" value="<?php echo $record->company;?>" required="required" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Insurance By : </label></td>
			<td>
				<input type="text" name="insurance_by" value="<?php echo $record->insurance_by;?>" class="form-control">
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
				<textarea name="description" class="form-control"><?php echo $record->description;?></textarea>
			</td>
		</tr>

		
		<tr>
			<td colspan="5" align="center"> 
				<input type="hidden" name="insurance_id" value="<?php echo $record->id;?>">
				<input type="submit" name="save" class="btn btn-primary" onclick="return confirmSubmit();" value="Save">
				<input type="reset" name="reset" class="btn btn-primary" value="Reset"> 
			</td>
		</tr>
	</table>
</div>
</form>
<script>

function confirmSubmit()
{
	var status = confirm("Do you want to Update Details ?");
	
	if(status == true )
	{
		return true;
	}
	
	return false;
}
</script>
