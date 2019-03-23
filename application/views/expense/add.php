<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/expense/add" method="post">
	<div>
		<h3>Add Expense For : <?php echo date('d-m-Y');?></h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td align="right"> <label>Category : </label></td>
			<td>
				<select name="category_id"  required="required" class="form-control" id="category_id">
					<option value="1">
						Tea & Coffe
					</option>

					<option value="2">
						Petrol
					</option>

					<option value="3">
						Courier
					</option>

					<option value="4">
						Girish Bhai ( Marketing )
					</option>

					<option value="5">
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
			<td align="right"> <label>Description : </label></td>
			<td> 
				<textarea name="description" class="form-control"></textarea>
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Receipt : </label></td>
			<td>
				<input type="text" name="receipt" value="<?php echo $record->receipt;?>" required="required" class="form-control">
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
