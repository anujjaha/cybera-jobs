<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>

<?php
$this->load->helper('form');
 echo form_open('customer/save_special');?>

 <link href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" rel="stylesheet"/>
<div class="col-md-12">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Add Special Rates </h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Customer Name</label>
			<?php
				$cusomters = get_all_customers();
			?>
			<select required="required" id="customer_id"  name="customer_id" class="form-control">
			<option value="">Select Customer</option>
			<?php
				foreach($cusomters as $customer)
				{
			?>
				<option value="<?php echo $customer->id;?>">
					<?php
						if(isset($customer->companyname) && strlen($customer->companyname) > 0)
						{
							echo $customer->companyname;
						}
						else
						{
							echo $customer->name;
						}
					?>
				</option>
			<?php
				}
			?>
				
			</select>
		</div>
		<div class="form-group">
			<label>Job Title</label>
			<input type="text" class="form-control" name="title" required="required"  placeholder="Title">
		</div>

		<div class="form-group">
			<label>Quantity</label>
			<input type="text" class="form-control" name="qty" required="required"  placeholder="Quantity">
		</div>
		
		<div class="form-group">
			<label>Rate</label>
			<input type="text" class="form-control" name="rate" required="required" placeholder="Rate">
		</div>

		<div class="form-group">
			<label>Description</label>
			<textarea class="form-control" name="description"></textarea>
		</div>
		
		<div class="form-group">
			<input type="submit" name="save" value="Save" class="btn btn-lg btn-primary">
		</div>

	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

</form>

<script type="text/javascript">
	
	jQuery(document).ready(function()
	{
		setTimeout(function()
		{
			jQuery("#customer_id").select2({
			 	allowClear:true,
			 	placeholder: 'Select Customer'
			});
		}, 1000);
	});
</script>