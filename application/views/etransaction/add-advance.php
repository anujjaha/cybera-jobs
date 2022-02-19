<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/employee/add_advance" method="post">
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
			
			<td align="right"> <label>Advance Amount : </label></td>
			<td> <input type="number" min="0" name="advance" value="0" required="required" class="form-control"> </td>
		</tr>

		<tr>
			<td  align="right"> <label>Notes :</label></td>
			<td colspan="4" align="right">
				<textarea class="form-control" name="notes"></textarea>
			</td>
		</tr>
		
		<tr>
			<td colspan="5">
				<div id="salaryInfo"></div>
				<div id="salaryAdvanceInfo"></div>
				<div id="maxSalary"></div>
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
	jQuery("#emp_id").on('change', function(e)
	{
		var empId = e.target.value;
		getEmployeeSalaryDetails(empId);
		
	});
});

function getEmployeeSalaryAdvanceDetails(empId, salary)
{
	$.ajax({
        type: "POST",
        url: "<?php echo site_url();?>/employee/getEmployeeAdvance/", 
        data:{'empId': empId},
        dataType: 'JSON',
        success: function(data)
        {	
        	if(data.status == true)
        	{
        		var advanceHtml = advanceTemplate(data.data, salary);
        		jQuery("#salaryAdvanceInfo").html(advanceHtml);
        	}
		}
    });
	
}

function getEmployeeSalaryDetails(empId)
{
	$.ajax({
        type: "POST",
        url: "<?php echo site_url();?>/employee/getEmployeeSalaryDetails/", 
        data:{'empId': empId},
        dataType: 'JSON',
        success: function(data)
        {	
        	if(data.status == true)
        	{
        		var salaryHtml = salaryTemplate(data.data);
        		jQuery("#salaryInfo").html(salaryHtml);

        		getEmployeeSalaryAdvanceDetails(empId, data.data);
        	}
		}
    });
	
}

function salaryTemplate(salary)
{
	return '<div class="row"><div class="col-md-3">Salary:'+ salary['salary'] +'</div>\
			<div class="col-md-3">Max Limit: '+ salary['max_limit'] +'</div>\
			</div>';
}

function advanceTemplate(advanceList, salary)
{
	if(advanceList.length > 0)
	{
		var html 			= '<div class="row">',
			totalAdvance 	= 0;

		for(var i = 0; i < advanceList.length; i++)
		{
			html += '<div class="col-md-4">Advance : '+ advanceList[i].advance +' </div>';
			html += '<div class="col-md-4">Notes : '+ advanceList[i].notes +' </div>';
			html += '<div class="col-md-4">Created At : '+ advanceList[i].created_at +' </div>';

			totalAdvance = parseFloat(totalAdvance) + parseFloat(advanceList[i].advance);
		}

		html += "</div>";

		var maxPossibleAdvance = salary['max_limit'] - totalAdvance;

		var htmlData = '<br><hr><div class="col-md-6">Total Advance :'+ totalAdvance + '</div><div class="col-md-6">Max Possible Advance : ' + maxPossibleAdvance+'</div>';

		jQuery("#maxSalary").html(htmlData);

		return html;
	}

	else
	{
		return '<span>No Advance History Found!</span>';
	}
}

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

