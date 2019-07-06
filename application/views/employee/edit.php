<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/employee/edit" method="post">

	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td align="right"> <label>Name : </label></td>
			<td> <input type="text" name="name" value="<?php echo $employeeInfo->name;?>" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Department :</label></td>
			<td>
				<select name="department" class="form-control">
					<option><?php echo $employeeInfo->department;?></option>
					<option>Receiption</option>
					<option>Account</option>
					<option>Printing</option>
					<option>Designing</option>
					<option>Cutting</option>
					<option>Xerox</option>
					<option>Binding</option>
					<option>Technical</option>
					<option>Marketing</option>
					<option>Support</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Salary : </label></td>
			<td> <input type="number" name="salary" value="<?php echo $employeeInfo->salary;?>" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Max Limit  : </label></td>
			<td> <input type="number" name="max_limit" required="required" value="<?php echo $employeeInfo->max_limit;?>" class="form-control"> </td>
		</tr>

		<tr>
			<td align="right"> <label>Mobile : </label></td>
			<td> <input type="text" name="mobile" value="<?php echo $employeeInfo->mobile;?>" required="required" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Email Id  : </label></td>
			<td> <input type="text" name="emailid" required="required" value="<?php echo $employeeInfo->emailid;?>" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Blood Group : </label></td>
			<td> <input type="text" name="bgroup" required="required" value="<?php echo $employeeInfo->bgroup;?>" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Birth Date  : </label></td>
			<td> <input type="text" name="birthdate" required="required" value="<?php echo $employeeInfo->birthdate;?>" class="form-control datepicker"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Join Date  : </label></td>
			<td> <input type="text" name="join_date" required="required" value="<?php echo $employeeInfo->join_date;?>" class="form-control datepicker"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Marriege Status : </label></td>
			<td> 
				<select name="mrg_status" class="form-control">
					<option><?php echo $employeeInfo->mrg_status;?></option>
					<option>Single</option>
					<option>Married</option>
					<option>Other</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Alter Contact Name : </label></td>
			<td> <input type="text" name="altercontactname" required="required" value="<?php echo $employeeInfo->altercontactname;?>" class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Alter Contact Number  : </label></td>
			<td> <input type="text" name="altercontactnumber" required="required" value="<?php echo $employeeInfo->altercontactnumber;?>" class="form-control"> </td>
		</tr>
		
		<tr>
			<td align="right"> <label> Aadhar Card No.  : </label></td>
			<td> <input type="text" name="aadharcard" value="<?php echo $employeeInfo->aadharcard;?>"  class="form-control"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Address : </label></td>
			<td colspan="4"> <textarea name="address" class="form-control"><?php echo $employeeInfo->address;?></textarea>  </td>
		</tr>

		<tr>
			<td align="right"> <label> Resignation Date.  : </label></td>
			<td> <input type="text" name="resignation_date" value="<?php echo $employeeInfo->resignation_date;?>"  class="form-control datepicker"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Resignation Details: </label></td>
			<td colspan="4"> <textarea name="resignation_details" class="form-control"><?php echo $employeeInfo->resignation_details;?></textarea>  </td>
		</tr>

		<tr>
			<td align="right"> <label> Last Date  : </label></td>
			<td> <input type="text" name="last_date" value="<?php echo $employeeInfo->last_date;?>"  class="form-control datepicker"> </td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Resignation Notes: </label></td>
			<td colspan="4"> <textarea name="resignation_notes" class="form-control"><?php echo $employeeInfo->resignation_notes;?></textarea>  </td>
		</tr>

		<tr>
			<td align="right"> <label> Active: </label></td>
			<td> 
				<select name="is_active" class="form-control">
					<option <?php echo $employeeInfo->is_active == 1 ? 'selected' : '';?>  value="1"> Yes </option>	
					<option  <?php echo $employeeInfo->is_active == 0 ? 'selected' : '';?> value="0"> NO </option>	
				</select>
			</td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label> Status  : </label></td>
			<td colspan="4"> 
			<select name="status" class="form-control">
				<option <?php echo $employeeInfo->status == 1 ? 'selected' : '';?>  value="1"> Yes </option>	
				<option  <?php echo $employeeInfo->status == 0 ? 'selected' : '';?> value="0"> NO </option>	
			</select>
			</td>
		</tr>
		
		<tr>
			<td colspan="5" align="center"> 
				<input type="hidden" name="employeeId" value="<?php echo $employeeInfo->id;?>">
				<input type="submit" name="save" class="btn btn-primary" value="Save">
				<input type="reset" name="reset" class="btn btn-primary" value="Reset"> 
			</td>
		</tr>
	</table>
</div>
</form>
