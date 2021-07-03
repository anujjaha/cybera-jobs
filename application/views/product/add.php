<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/product/add" method="post">
	<div>
		<h3>Product Transaction ON : <?php echo date('d-m-Y');?></h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td width="250" align="right"> <label>Select Product Category : </label></td>
			<td>
				<select name="product_id" class="form-control" required="required">
					<option value="">Select Product</option>
				<?php
				 	$productCategories = getGProductCategory();

				 	foreach($productCategories as $productCategory)
				 	{
				 	?>
				 		<option value="<?= trim($productCategory->id);?>"><?= trim($productCategory->title);?></option>
				 	<?php
				 	}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Quantity : </label></td>
			<td>
				<input type="text" name="qty" value="0" required="required" class="form-control">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Stock In: </label></td>
			<td>
				<select name="stock_in" class="form-control" required="required"> 
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Stock Out: </label></td>
			<td>
				<select name="stock_out" class="form-control" required="required">  
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Price : </label></td>
			<td>
				<input type="text" name="price" value="0" required="required" class="form-control">
			</td>
		</tr>
		

		<tr>
			<td align="right"> <label>Is Damage: </label></td>
			<td>
				<select name="is_damage" class="form-control" required="required"> 
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Is Gift: </label></td>
			<td>
			<select name="is_gift" class="form-control" required="required"> 
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Is Sample: </label></td>
			<td>
			<select name="is_sample" class="form-control" required="required"> 
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
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
	var status = confirm("Are You Sure ?");
	
	if(status == true )
	{
		return true;
	}
	
	return false;
}
</script>
