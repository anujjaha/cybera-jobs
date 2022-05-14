
<!-- MOdal BOx for Bills -->
<div id="jobOutModalPopup" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width: 1000px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Out JOB</h4>

      </div>
      <div class="modal-body">

      	<form action="#" method="POST" name="out-job" id="out-job">

      	<div class="text-center">
      		<div class="col-md-2">
      			Job Name : 
      		</div>
      		<div class="col-md-3">
      			<input class="form-control" type="text" name="location" value="Out Job - <?= date('Y-m-d H:i:s');?>">
      		</div>

      		
      	</div>
      	<br><br>

		<table id="outItem" class="table">
			<tr>
				<td width="20%"> Location </td>
				<td width="10%"> Size </td>
				<td width="10%"> LAMINATION </td>
				<td width="10%"> SIDE </td>
				<td width="10%"> Qty </td>
				<td width="30%"> Notes </td>
				<td width="10%"> Action </td>
			</tr>

			<tr id="primary-row">
				<td><input class="form-control" type="text" value="SHALVIK" name="out[out_location]"> </td>
				<td><input class="form-control" type="text" value="12X18" name="out[size]"> </td>
				<td>
					<select name="out[lamination_type]" class="form-control">
						<option>N/A</option>
						<option>GLOSS Lamination</option>
						<option>MATT Lamination</option>
						<option>Velvet Lamination</option>
						<option>UV</option>
						<option>Silver Foil</option>
						<option>Golden Foil</option>
					</select>
				</td>
				<td>
					<select name="out[lamination_side]" class="form-control">
						<option>SINGLE</option>
						<option>FRONT BACK</option>
					</select>
				</td>
				<td><input value="0" step="1" min="0"  class="form-control" type="number" name="out[qty]"> </td>
				
				<td><textarea  class="form-control" name="out[notes]"></textarea></td>
				<td>
					<a href="javascript:void(0);" class="add-new-row">Add</a>
					<a style="display: none;" href="javascript:void(0);" class="remove-new-row">Remove</a>
				</td>
			</tr>
		</table>
		<input type="hidden" name="outJobId" id="outJobId" value="<?php echo isset($job_data) && !empty($job_data->id) ? $job_data->id : '0';?>">

		<input type="hidden" name="outJobCustomerId" id="outJobCustomerId" value="<?php echo isset($job_data) && !empty($job_data->customer_id) ? $job_data->customer_id : '0';?>">
		<input type="hidden" name="token" id="token" value="<?php echo $token;?>">
		</form>
      </div>
      <div class="modal-footer">
      	<div>
	      	<div class="col-md-2">
	      		Person :
	      	</div>

	      	<div class="col-md-3">
	      		<input class="form-control" type="text" name="person">
	      	</div>

	      	<div class="col-md-2">
	      		Total :
	      	</div>
	      	
	      	<div class="col-md-3">
	      		<input class="form-control" type="text" name="charges">
	      	</div>

	      	<!-- <div class="col-md-2">
	      		<input class="form-control datepicker datetimepicker" value="<?php echo date('d-m-Y');?>" type="text" name="return_time">
	      	</div> -->
      	</div>

      	<br>
      	<hr />

		<input type="hidden" value="<?= $token;?>" name="token" id="token">
        <button type="button" class="btn btn-primary" onclick="saveOutStationJob()">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
	</div>
</div>

<script type="text/javascript">
	jQuery(".add-new-row").on('click', function()
	{
		jQuery("#primary-row").clone().appendTo("#outItem");
		jQuery("#outItem tr").last().find('a').first().html('');
		jQuery("#outItem tr").last().find('a').last().css('display', 'block');
		jQuery("#outItem tr").last().find('input').val('');
		jQuery("#outItem tr").last().find('textarea').val('');
	});

	jQuery(document).on('click', '.remove-new-row', function(e)
	{
		jQuery(e.target).closest('tr').remove();
	})

function saveOutStationJob()
{
	var params = $('#out-job').serialize();

	var formObj = {};
 	var inputs = $('#out-job').serializeArray();
 	$.each(inputs, function (i, input) {
    	console.log(i);
    	console.log(input);
        formObj[input.name] = input.value;
    });

    if(jQuery("#outJobId").val().toString() === "0")
    {
    	var setURL = "<?php echo site_url();?>/ajax/createOutStationJob";
    }
    else
    {
    	var setURL = "<?php echo site_url();?>/ajax/updateOutStationJob";
    }

    console.log(inputs);

	$.ajax({
		 type: "POST",
		 url: "<?php echo site_url();?>/ajax/createOutStationJob", 
		 data: {
		 	inputs
		 },
		 dataType: 'JSON',
		 success: 
			function(data)
			{
				if(data.status == true)
				{
					jQuery("#jobOutModalPopup").modal('hide');
				}
			}
	  });
}

</script>