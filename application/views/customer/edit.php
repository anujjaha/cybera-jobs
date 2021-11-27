<?php
$this->load->helper('form');
 echo form_open('customer/edit');?>
 <div class="row">
 	<div class="col-md-12">
 		<a class="btn btn-info" href="<?php echo site_url();?>/customer/addresses/<?php echo $dealer_info->id;?>">Manage Addresses ( <?php echo count($locations);?> )</a>
 	</div>
 </div>
 <div class="clearfix"></div>
 <hr>
<div class="col-md-6">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Personal Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Company Name</label>
			<input type="text" class="form-control" name="companyname"  value="<?php if(!empty($dealer_info->companyname)){echo $dealer_info->companyname;}?>" placeholder="Company Name">
		</div>
		<div class="form-group">
			<label>Customer Name</label>
			<input type="text" class="form-control" name="name" value="<?php if(!empty($dealer_info->name)){echo $dealer_info->name;}?>" placeholder="Customer Name">
		</div>
		<div class="form-group">
			<label>Outside Customer</label>
			<select name="outside" class="form-control" id="outside">
				<option <?php if(isset($dealer_info->outside) && $dealer_info->outside == 1) echo 'selected="selected"';?> value="1"> Yes </option>
				<option <?php if(isset($dealer_info->outside) && $dealer_info->outside == 0) echo 'selected="selected"';?> value="0"> No </option>
			</select>
		</div>
		<div class="form-group">
			<label>Contact Number</label>
			<input type="text" class="form-control" name="mobile" value="<?php if(!empty($dealer_info->mobile)){echo $dealer_info->mobile;}?>" placeholder="Mobile Number">
		</div>
		
		<div class="form-group">
			<label>Other Contact Number</label>
			<input type="text" class="form-control" name="officecontact" value="<?php if(!empty($dealer_info->officecontact)){echo $dealer_info->officecontact;}?>" placeholder="Other Number">
		</div>
		<div class="form-group">
			<label>Email Id</label>
			<input type="text" class="form-control" name="emailid" value="<?php if(!empty($dealer_info->emailid)){echo $dealer_info->emailid;}?>" placeholder="Email Id">
		</div>
		<div class="form-group">
			<label>Other Email Id</label>
			<input type="text" class="form-control" name="emailid2" value="<?php if(!empty($dealer_info->emailid2)){echo $dealer_info->emailid2;}?>" placeholder="Email Id">
		</div>

		<div class="form-group">
			<?php
				$customerSel = $dealer_info->ctype == '0' || $dealer_info->ctype == '2' ? 'selected="selected"' : '';
				$dealerSel = $dealer_info->ctype == '1' ? 'selected="selected"' : '';
				
			?>
			<label>Customer Type</label>
			<select class="form-control" name="ctype">
				<option <?php echo $customerSel; ?> value="0">  Retailer </option>
				<option  <?php echo $dealerSel; ?> value="1">  Dealer </option>
			</select>
		</div>
		
		<div class="form-group">
			<label>Extra Charge</label>
			<input type="text" class="form-control" name="extra_amount" value="<?php echo $dealer_info->extra_amount;?>" placeholder="Extra Amount">
		</div>

		<div class="form-group">
			<label>Marketing Mail Allow</label>
			<select name="is_mail"  id="is_mail" class="form-control">
				<option <?php $dealer_info->is_mail == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php $dealer_info->is_mail == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
			</select>
		</div>

		<div class="form-group">
			<label>Star Rating</label>
			<select name="customer_star_rate"  id="customer_star_rate" class="form-control">
				<option <?php $dealer_info->customer_star_rate == 0 ? 'selected="selected"' : ''; ?> value="0">
				0</option>
				<option <?php $dealer_info->customer_star_rate == 1 ? 'selected="selected"' : ''; ?> value="1">
				1</option>

				<option <?php $dealer_info->customer_star_rate == 2 ? 'selected="selected"' : ''; ?> value="1">
				2</option>

				<option <?php $dealer_info->customer_star_rate == 3 ? 'selected="selected"' : ''; ?> value="1">
				3</option>

				<option <?php $dealer_info->customer_star_rate == 4 ? 'selected="selected"' : ''; ?> value="1">
				4</option>

				<option <?php $dealer_info->customer_star_rate == 5 ? 'selected="selected"' : ''; ?> value="5">
				5</option>
			</select>
		</div>


		<div class="form-group">
			<label>Message</label>
			<input type="text" class="form-control" name="fix_note" value="<?php echo $dealer_info->fix_note;?>" placeholder="Fix Note">
		</div>

		<div class="form-group">
			<label>Notes about Customer</label>

			<textarea class="form-control" name="description"><?php echo  isset($dealer_info->description) ? $dealer_info->description : '' ?></textarea>
		</div>

		<div class="form-group">
			<label>Referral Customer</label>
			<select class="form-control" name="referral_customer_id" id="referral_customer_id">
				<option value="0">
					Please Select Reference Customer
				</option>
				<?php

					foreach(get_all_customers() as $customer)
					{
						$selected = '';
						if(isset($dealer_info) && $dealer_info->referral_customer_id == $customer->id)
						{
							$selected = 'selected="selected"';
						}
				?>
					<option <?php echo $selected;?> value="<?php echo $customer->id;?>">
						<?php echo !empty($customer->companyname) ? $customer->companyname : $customer->name;?>
					</option>
				<?php
					}
				?>
				
			</select>
		</div>

	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

<div class="col-md-6">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Address Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Address Line 1</label>
			<input type="text" class="form-control" name="add1" value="<?php if(!empty($dealer_info->add1)){echo $dealer_info->add1;}?>" placeholder="Address">
		</div>
		<div class="form-group">
			<label>Address Line 2</label>
			<input type="text" class="form-control" name="add2" value="<?php if(!empty($dealer_info->add2)){echo $dealer_info->add2;}?>" placeholder="Address">
		</div>
		<div class="form-group">
			<label>City</label>
			<input type="text" class="form-control" name="city" value="<?php if(!empty($dealer_info->city)){echo $dealer_info->city;}else{ echo"Ahmedabad";}?>" placeholder="City">
		</div>
		<div class="form-group">
			<label>State</label>
			<input type="text" class="form-control" name="state" value="<?php if(!empty($dealer_info->state)){echo $dealer_info->state;}else { echo "Gujarat";}?>" placeholder="State">
		</div>
		<div class="form-group">
			<label>Pin</label>
			<input type="text" class="form-control" name="pin" value="<?php if(!empty($dealer_info->pin)){echo $dealer_info->pin;}?>" placeholder="Pincode">
		</div>

		

		<div class="form-group">
			<label>Under Obvervation</label>
			<select name="under_revision"  id="under_revision" class="form-control">
				<option <?php $dealer_info->under_revision == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php $dealer_info->under_revision == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
				
			</select>
		</div>

		<div class="form-group">
			<label>Block Customer</label>
			<select name="is_block" id="is_block" class="form-control">
				<option value="0">No </option>
				<option  value="1">Yes </option>
				
			</select>
		</div>

		
		<div class="form-group">
			<label>Customer Reviews</label>

			<textarea class="form-control" name="customer_reviews"><?php echo  isset($dealer_info->customer_reviews) ? $dealer_info->customer_reviews : '' ?></textarea>
		</div>

		<div class="form-group">
			<label>Job Mail Active</label>
			<select name="is_job_mail"  id="is_job_mail" class="form-control">
				<option <?php $dealer_info->is_job_mail == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php $dealer_info->is_job_mail == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
			</select>
		</div>
		<div class="form-group">
			<label>Tax 5% </label>
			<select name="is_5_tax"  id="is_5_tax" class="form-control">
				<option <?php $dealer_info->is_5_tax == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php $dealer_info->is_5_tax == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
			</select>
		</div>

		<div class="form-group">
			<label>Is Invoice</label>
			<select name="is_invoice"  id="is_invoice" class="form-control">
				<option <?php $dealer_info->is_invoice == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php $dealer_info->is_invoice == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
			</select>
		</div>

		<div class="form-group">
			<label>Is Print Cybera</label>
			<select name="is_print_cybera"  id="is_print_cybera" class="form-control">
				<option <?php $dealer_info->is_print_cybera == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php $dealer_info->is_print_cybera == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
			</select>
		</div>

		<div class="form-group">
			<label>Party Transport Pay</label>
			<select name="is_party_pay"  id="is_party_pay" class="form-control">
				<option <?php echo $dealer_info->is_party_pay == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php echo $dealer_info->is_party_pay == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
			</select>
		</div>

		<div class="form-group">
			<label>Include Daily Mail</label>
			<select name="is_daily_mail"  id="is_daily_mail" class="form-control">
				<option <?php echo $dealer_info->is_daily_mail == 0 ? 'selected="selected"' : ''; ?> value="0">No </option>
				<option <?php echo $dealer_info->is_daily_mail == 1 ? 'selected="selected"' : ''; ?> value="1">Yes </option>
			</select>
		</div>

	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

<div class="col-md-6">
	<div class="box box-warning">
		<div class="box-header">
			<h3 class="box-title">Trasnporter Details</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<?php
				$transporters = getAllTransporters($dealer_info->id);
				$j = 0;

				if(isset($transporters) && count($transporters))
				{
					foreach($transporters as $transporter)	
					{
					?>
						<div class="form-group">
							<label>Transpoter Name :</label>
							<input type="text" class="form-control" name="transporter_name[]" value="<?php echo $transporter['name'];?>" placeholder="Transporter Name">
						</div>
					<?php
						$j++;
					}

					for($i = $j; $i < 5; $i++)
					{
					?>
						<div class="form-group">
							<label>Transpoter Name :</label>
							<input type="text" class="form-control" name="transporter_name[]" value="" placeholder="Transporter Name">
						</div>
					<?php
					}
				}
				else
				{
					for($i = 0; $i < 5; $i++)
					{
					?>
						<div class="form-group">
							<label>Transpoter Name :</label>
							<input type="text" class="form-control" name="transporter_name[]" value="" placeholder="Transporter Name">
						</div>
					<?php
					}
				}
				//pr($transporters);

			 //pr($transporter_info->name);
			?>
			<!--<div class="form-group">
				<label>Transporter Contact Person:</label>
				<input type="text" class="form-control" name="transporter_contact_person" value="<?php if(isset($transporter_info->contact_person)){echo $transporter_info->contact_person;}?>" placeholder="Transporter Contact Person Name">
			</div>
			
			<div class="form-group">
				<label>Transporter Contact Number:</label>
				<input type="text" class="form-control" name="transporter_contact_number" value="<?php if(isset($transporter_info->contact_number)){echo $transporter_info->contact_number;}?>" placeholder="Transporter Contact Number">
			</div>
			
			<div class="form-group">
				<label>Transporter Location:</label>
				<input type="text" class="form-control" name="transporter_location" value="<?php if(isset($transporter_info->location)){echo $transporter_info->location;}?>" placeholder="Transporter Location">
			</div>-->
			
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="form-group">
			<input type="hidden" name="customer_id" value="<?php if(!empty($dealer_info->id)){echo $dealer_info->id;}?>">
			<input type="hidden" name="transporter_id" value="<?php if(isset($transporter_info->id)){echo $transporter_info->id;}?>">
			<input type="submit" name="save" value="Save" class="btn btn-primary">
		</div>
</div>
</form>


<script type="text/javascript">
	
	jQuery("#is_block").val(<?php echo $dealer_info->is_block;?>);
	jQuery("#under_revision").val(<?php echo $dealer_info->under_revision;?>);
	jQuery("#is_mail").val(<?php echo $dealer_info->is_mail;?>);
	jQuery("#is_job_mail").val(<?php echo $dealer_info->is_job_mail;?>);
	jQuery("#is_5_tax").val(<?php echo $dealer_info->is_5_tax;?>);
	jQuery("#is_invoice").val(<?php echo $dealer_info->is_invoice;?>);
</script>