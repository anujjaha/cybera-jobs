<?php
	/*pr($jobOutInfo, false);
	pr($jobOutDetails);*/
?>
<!-- MOdal BOx for Bills -->
<div id="jobOutModalPopup" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width: 1000px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Out JOB</h4>

      </div>
      <div class="modal-body">

      	<form action="#" method="POST" name="out-job" id="out-job">

      	<div class="text-center">
      		<div class="col-md-2">
      			Location : 
      		</div>
      		<div class="col-md-3">
      			<input class="form-control" type="text" name="location" value="<?=$jobOutInfo->location_name;?>">
      		</div>

      		
      	</div>
      	<br><br>

		<table id="outItem" class="table">
			<tr>
				<td> Size </td>
				<td> LAMINATION </td>
				<td> SIDE </td>
				<td> Qty </td>
				<td> Notes </td>
				<td> Action </td>
			</tr>

			<?php
				$firstDetail = $jobOutDetails[0];
			?>
			<tr id="primary-row">
				<td><input class="form-control" type="text" value="12X18" name="out[size]" value="<?=$firstDetail['out_size'];?>"> </td>
				<td>
					<select name="out[lamination_type]" class="form-control">
						<option <?php echo $firstDetail['out_type'] == 'N/A' ? 'selected="selected"' : '';?>>N/A</option>
						<option <?php echo $firstDetail['out_type'] == 'GLOSS Lamination' ? 'selected="selected"' : '';?>>GLOSS Lamination</option>

						<option <?php echo $firstDetail['out_type'] == 'MATT Lamination' ? 'selected="selected"' : '';?>>MATT Lamination</option>

						<option <?php echo $firstDetail['out_type'] == 'Velvet Lamination' ? 'selected="selected"' : '';?>>Velvet Lamination</option>

						<option <?php echo $firstDetail['out_type'] == 'UV' ? 'selected="selected"' : '';?>>UV</option>

						<option <?php echo $firstDetail['out_type'] == 'Silver Foil' ? 'selected="selected"' : '';?>>Silver Foil</option>

						<option <?php echo $firstDetail['out_type'] == 'Golden Foil' ? 'selected="selected"' : '';?>>Golden Foil</option>
					</select>
				</td>
				<td>
					<select name="out[lamination_side]" class="form-control">
						<option <?php echo $firstDetail['out_side'] == 'SINGLE' ? 'selected="selected"' : '';?>>SINGLE</option>
						<option <?php echo $firstDetail['out_side'] == 'FRONT BACK' ? 'selected="selected"' : '';?>>FRONT BACK</option>
					</select>
				</td>
				<td><input value="<?=$firstDetail['out_qty'];?>" step="1" min="0"  class="form-control" type="number" name="out[qty]"> </td>
				
				<td><textarea  class="form-control" name="out[notes]"><?=$firstDetail['out_notes'];?></textarea></td>
				<td>
					<a href="javascript:void(0);" class="add-new-row">Add</a>
					<a style="display: none;" href="javascript:void(0);" class="remove-new-row">Remove</a>
				</td>
			</tr>
		</table>
		
      </div>
      <div class="modal-footer">
      	<div>
	      	<div class="col-md-2">
	      		Person :
	      	</div>

	      	<div class="col-md-3">
	      		<input class="form-control" type="text" name="person" value="<?=$jobOutInfo->person;?>">
	      	</div>

	      	<div class="col-md-2">
	      		Total :
	      	</div>
	      	
	      	<div class="col-md-3">
	      		<input class="form-control" type="text" name="charges"  value="<?=$jobOutInfo->total;?>">
	      	</div>

	      	<!-- <div class="col-md-2">
	      		<input class="form-control datepicker datetimepicker" value="<?php echo date('d-m-Y');?>" type="text" name="return_time">
	      	</div> -->
      	</div>

      	<br>
      	<hr />
      	<?php
      		if(isset($jobOutInfo) && isset($jobOutInfo->id))
      		{
      	?>
      		<input type="hidden" value="<?= $jobOutInfo->id;?>" name="outId" id="outId">
      	<?php
      		}
      		else
      		{
      	?>	
      		<input type="hidden" value="<?= $token;?>" name="token" id="token">
      	<?php
      		}
      	?>
        <button type="button" class="btn btn-primary" onclick="saveOutStationJob()">Update</button>
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
    	formObj[input.name] = input.value;
    });

    $.ajax({
		 type: "POST",
		 url: "<?php echo site_url();?>/ajax/updateOutStationJob", 
		 data: {
		 	outId: jQuery("#outId").val(),
		 	inputs
		 },
		 dataType: 'JSON',
		 success: 
			function(data)
			{
				if(data.status == true)
				{
					alert("Out Job Updated Successfully.");
					jQuery("#jobOutModalPopup").modal('hide');
				}
			}
	  });
}
</script>