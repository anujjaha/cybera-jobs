<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>cloth/add_vendor" method="post">
	<div>
		<h3>Add New Vendor</h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td width="15%" align="right"> <label>Company : </label></td>
			<td>
				<input type="text" name="company" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td width="15%" align="right"> <label>GSTN : </label></td>
			<td>
				<input type="text" name="gstn" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Owner Name : </label></td>
			<td>
				<input type="text" name="name" required="required" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Mobile : </label></td>
			<td>
				<input type="text" name="mobile" required="required" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Other Contact : </label></td>
			<td>
				<input type="text" name="contact" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Address 1 : </label></td>
			<td>
				<input type="text" name="address_1" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Address 2 : </label></td>
			<td>
				<input type="text" name="address_2" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>City : </label></td>
			<td>
				<input type="text" name="city" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>State : </label></td>
			<td>
				<input type="text" name="state" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Pincode : </label></td>
			<td>
				<input type="text" name="zip" class="form-control">
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Description : </label></td>
			<td> 
				<textarea name="notes" class="form-control"></textarea>
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

function confirmSubmit()
{
	var status = confirm("Are You Sure, you want to create new Vendor?");
	
	if(status == true )
	{
		return true;
	}
	
	return false;
}
</script>
