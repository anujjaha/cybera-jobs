<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/attendance/edit" method="post">
	<div>
		<h3>General Attendance : <?php echo $attaendaceInfo->month . ' ' .$attaendaceInfo->year; ?></h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td align="right"> <label>Employee :</label></td>
			<td>
				<?php echo $attaendaceInfo->name; ?>
			</td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Attendance Month : </label></td>
			<td> 
			<p>
				<?php echo $attaendaceInfo->month . ' ' .$attaendaceInfo->year; ?>
			</p>
		</tr>
		<tr>
			<td align="right"> <label>Half Day : </label></td>
			<td> <input type="number" min="0" name="half_day" value="<?php echo $attaendaceInfo->half_day; ?>" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Full Day  : </label></td>
			<td> <input type="number" min="0" name="full_day"  value="<?php echo $attaendaceInfo->full_day; ?>" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Office Late : </label></td>
			<td> <input type="number" min="0" name="office_late"  value="<?php echo $attaendaceInfo->office_late; ?>" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Office Half Day : </label></td>
			<td> <input type="number" min="0" name="office_halfday"  value="<?php echo $attaendaceInfo->office_halfday; ?>" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Half Night : </label></td>
			<td> <input type="number" min="0" name="half_night"  value="<?php echo $attaendaceInfo->half_night; ?>" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Full Night : </label></td>
			<td> <input type="number" min="0" name="full_night"  value="<?php echo $attaendaceInfo->full_night; ?>" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Sunday  : </label></td>
			<td> <input type="text" name="sunday"  value="<?php echo $attaendaceInfo->sunday; ?>" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Notes : </label></td>
			<td> 
				<textarea name="notes" class="form-control" id="notes"><?php echo $attaendaceInfo->notes; ?></textarea>
			</td>
		</tr>

		<tr>
			<td align="right"> <label> Performance : </label></td>
			<td>
				<select name="result">
					<?php
						if(strlen($attaendaceInfo->result) > 2)
						{

							echo "<option>" . $attaendaceInfo->result . "</option>";
						}
					?>
					<option> Out Standing </option>
					<option> Excellent </option>
					<option> Best </option>
					<option> Better </option>
					<option> Good </option>
					<option> Average </option>
					<option> Below Average </option>
					<option> Poor </option>
					<option> Bad </option>
				</select>
			</td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Personal Notes : </label></td>
			<td> 
				<textarea name="personal_notes" class="form-control" id="personal_notes"><?php echo $attaendaceInfo->personal_notes; ?></textarea>
			</td>
		</tr>

		
		<tr>
			<td colspan="5" align="center"> 
				<input type="hidden" name="attendance_id" value="<?php echo $attaendaceInfo->id;?>">
				<input type="submit" name="save" class="btn btn-primary" onclick="return confirmSubmit();" value="Update">
				<input type="reset" name="reset" class="btn btn-primary" value="Reset"> 
			</td>
		</tr>
	</table>
</div>
</form>
<script>
function confirmSubmit()
{
	var status = confirm("Are You Sure You want to Update Details?");
	
	if(status == true )
	{
		return true;
	}
	
	return false;
}
</script>
