<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" rel="stylesheet"/>

	<form id="myForm" action="<?php echo site_url();?>/etransaction/add" method="post">
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td align="right"> <label>Select Employee : </label></td>
			<td> 
				<select name="emp_id" id="emp_id" class="form-control" required="required">
					<option value="">Select Employee</option>
					<?php 
					$vhtml = '';
					$all_customer = getAllEmployees(); 

					foreach($all_customer as $customer) 
					{
						$c_name = $customer->name;
					?>
						<option value="<?php echo $customer->id;?>">
							<?php echo $c_name;?>
						</option>
					<?php
					}
					?>
				</select>
			</td>
			
			<td>&nbsp;</td>
			
			<td align="right"> <label>Salary :</label></td>
			<td>
				<select name="is_salary" class="form-control">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Amount Added :</label></td>
			<td>
				<input type="number" name="amount_added" value="0" class="form-control" required="required">
			</td>

			<td>&nbsp;</td>

			<td align="right"> <label>Amount Removed :</label></td>
			<td>
				<input type="number" value="0"  name="amount_removed" class="form-control" required="required">
			</td>
		</tr>
		<tr>
			<td align="right"> <label>Bonus :</label></td>
			<td>
				<select name="is_bonus" class="form-control">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</td>

			<td>&nbsp;</td>
			
			<td align="right"> <label>Penalty :</label></td>
			<td>
				<select name="is_penalty" class="form-control">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</td>			
		</tr>
		<tr>
			<td align="right"> <label>Description  : </label></td>
			<td colspan="4">
				<textarea name="description" class="form-control"></textarea></td>
			</td>
		</tr>

		<tr>
			<td align="right"> <label>Notes  : </label></td>
			<td colspan="4">
				<textarea name="notes" class="form-control"></textarea></td>
			</td>
		</tr>
		<tr>
			<td colspan="5" align="center"> 
				<input type="submit" name="save" class="btn btn-primary" value="Save">
				<input type="reset" name="reset" class="btn btn-primary" value="Reset"> 
			</td>
		</tr>
	</table>
</div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js" type="text/javascript"></script>

<script type="text/javascript">
jQuery(document).ready(function()
{
	bindOnChangeEvent();
    jQuery('#myForm').on('submit', function(e)
    {
        e.preventDefault();

        var validate 	= confirm('Do You want to Save Entry, No Modification Allowed!'),
        	addAmount	= document.querySelector('input[name="amount_added"]'),	
        	removeAmount 	= document.querySelector('input[name="amount_removed"]');	
        if(addAmount.value == 0 && removeAmount.value == 0)
        {	
        	alert("Please Enter either Add or Remove Amount !");
        	return false;
        }
        if(validate)
        {
        	var context = this;

        	setTimeout(function()
        	{
        		context.submit();
        	}, 100);
        }
    });
});

function bindOnChangeEvent()
{
	var addAmount 		= document.querySelector('input[name="amount_added"]'),	
		removeAmount 	= document.querySelector('input[name="amount_removed"]'),	
		salaryStatus 	= document.querySelector('select[name="is_salary"]'),
		bonusStatus  	= document.querySelector('select[name="is_bonus"]'),
		penaltyStatus  	= document.querySelector('select[name="is_penalty"]');

	jQuery(salaryStatus).on('change', function(e)
	{
		if(e.target.value == 1)
		{
			bonusStatus.value = 0;
			penaltyStatus.value = 0;
		}
	})

	jQuery(bonusStatus).on('change', function(e)
	{
		if(e.target.value == 1)
		{
			salaryStatus.value = 0;
			penaltyStatus.value = 0;
		}
	})

	jQuery(penaltyStatus).on('change', function(e)
	{
		if(e.target.value == 1)
		{
			bonusStatus.value = 0;
			salaryStatus.value = 0;
		}	
		
	})
}
</script>