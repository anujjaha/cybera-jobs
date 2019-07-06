<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/attendance/add" method="post">
	<div>
		<h3>General Attendance : <?php //echo date('F - Y', strtotime('Last Month'));?></h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td align="right"> <label>Employee :</label></td>
			<td>
				<?php 
				echo getEmployeeSelectBox();
				//echo getEmployeeSelectBoxForAttendance(date('F', strtotime('Last Month')), date('Y', strtotime('Last Month')));?>
			</td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Attendance Month : </label></td>
			<td> 
			<p>
				<select name="year" style="width: 50%; float: right;" class="form-control">
					<option><?php echo date('Y', strtotime('Last Month'));?></option>
					<option>2016</option>
					<option><?php echo date('Y');?></option>
				</select>
				
				<select name="month" style="width: 50%;"  class="form-control">
					<?php
					/*<option> January </option>
					<option> February </option>
					<option> March </option>
					<option> April </option>
					<option> May </option>
					<option> June </option>
					<option> July </option>
					<option> August </option>
					<option> September </option>
					<option> Octomber </option>
					<option> November </option>
					<option> December </option> */?>
					<option><?php echo date('F', strtotime('Last Month'));?></option>
					<option><?php echo date('F', strtotime('-2 Month'));?></option>

					<option><?php echo date('F', strtotime('-3 Month'));?></option>

					<option><?php echo date('F');?></option>
				</select>
			</p>
		</tr>
		<tr>
			<td align="right"> <label>Half Day : </label></td>
			<td> 
				<div class="form-group">
					<div class="col-md-6">
						<input type="number" min="0" name="half_day" value="0" required="required" class="form-control"> 
					</div>

					<div class="col-md-2">
						Marks:
					</div>
					<div class="col-md-4">
						<input type="number" min="0" max="10" name="half_leave_mark" value="0" required="required" class="form-control">
					</div> 
				</div>
			</td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Full Day  : </label></td>
			<td>
				<div class="form-group">
				 	<div class="col-md-6">
				 		<input type="number" min="0" name="full_day"  value="0" required="required" class="form-control"> 
				 	</div>

				 	<div class="col-md-2">
				 		Marks:
				 	</div>
				 	<div class="col-md-4">
				 		<input type="number" min="0" max="10" name="full_leave_mark" value="0" required="required" class="form-control">
				 	</div> 
			 	</div>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Office Late : </label></td>
			<td> 

				<div class="form-group">
				 	<div class="col-md-6">
						<input type="number" min="0" name="office_late"  value="0" required="required" class="form-control">
				 	</div>

				 	<div class="col-md-2">
				 		Marks:
				 	</div>
				 	<div class="col-md-4">
				 		<input type="number" min="0" max="10" name="full_leave_mark" value="0" required="required" class="form-control">
				 	</div> 
			 	</div>

			</td>
			<td>&nbsp;</td>
			
			<td align="right"> <label>Office Half Day : </label></td>
			<td> <input type="number" min="0" name="office_halfday"  value="0" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Half Night : </label></td>
			<td> <input type="number" min="0" name="half_night"  value="0" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Full Night : </label></td>
			<td> <input type="number" min="0" name="full_night"  value="0" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Sunday  : </label></td>
			<td> <input type="text" name="sunday"  value="0" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Notes : </label></td>
			<td> 
				<textarea name="notes" class="form-control" id="notes"></textarea>
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Effeciency Marks  : </label></td>
			<td> <input type="number" name="effieciency_mark" min="0" max="10" value="0" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Withdrawal Marks : </label></td>
			<td> 
				<input type="number" name="withdraw_mark" min="0" max="10" value="0" required="required" class="form-control">	
			</td>
		</tr>

		<tr>
			<td  colspan="3" align="right"> <label>Working Days  : </label></td>
			<td> <input type="number" name="working_days" min="0" max="32" value="0" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
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
