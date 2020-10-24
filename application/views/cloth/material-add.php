<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/cloth/add_material" method="post">
<?php
//	pr($vendors);
?>	
	<div>
		<h3>Add New Material</h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td width="15%" align="right"> <label>Vendor: </label></td>
			<td>
				<select name="vendor_id" id="vendor_id" required="required" class="form-control">
					<option value="">Select Vendor</option>
					<?php
						foreach ($vendors as $vendor) {
					?>
						<option value="<?= $vendor['id'];?>"><?= $vendor['company'];?></option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td width="15%" align="right"> <label>Category: </label></td>
			<td>
				<select name="category" id="category" required="required" class="form-control">
					<option value="">Select Category</option>
					<option value="Plain Material">Plain Material</option>
					<option value="Chex Material">Chex Material</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="15%" align="right"> <label>Material Type: </label></td>
			<td>
				<select name="material_type" id="material_type" required="required" class="form-control">
					<option value="">Select Material</option>
					<option value="Test1">Test1</option>
					<option value="Test2">Test2</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="15%" align="right"><label>Title: </label></td>
			<td>
				<input type="text" name="title" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Invoice Ref: </label></td>
			<td>
				<input type="text" name="invoice_ref" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>GSM: </label></td>
			<td>
				<input type="number" min="0" max="1000" name="gsm" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td width="15%" align="right"> <label>Color: </label></td>
			<td>
				<select name="color" id="color" required="required" class="form-control">
					<option value="">Select Color</option>
					<option value="red">Red</option>
					<option value="blue">Blue</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Total KG: </label></td>
			<td>
				<input type="number" min="0" max="10000" name="total_kg" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Approx Ratio: </label></td>
			<td>
				<input type="number" min="0" max="10000" name="approx_ratio" required="required" class="form-control" value="0">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Total Cost: </label></td>
			<td>
				<input type="number" min="0" name="total_cost" required="required" class="form-control">
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
	var status = confirm("Are You Sure, you want to create new Material?");
	
	if(status == true )
	{
		return true;
	}
	
	return false;
}
</script>
