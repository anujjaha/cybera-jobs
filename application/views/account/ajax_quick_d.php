<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th width="25%"><span onclick="sort_filter('companyname','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Company Name
			<span onclick="sort_filter('companyname','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th><span onclick="sort_filter('name','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Customer Name
			<span onclick="sort_filter('name','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('total_debit','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Total Debit
			<span onclick="balance_filter('total_debit','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('total_credit','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Total Credit
			<span onclick="balance_filter('total_credit','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('balance','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Balance
			<span onclick="balance_filter('balance','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
			
		</th>
		<th><span onclick="sort_filter('mobile','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Contact
			<span onclick="sort_filter('mobile','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>City</th>
		<th>Status</th>
		<th>Account</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $customer) { 
			//pr($customer);
			$transporters = getAllTransporters($customer->id);
		?>
		<tr>
		<td><?php echo $sr;?></td>
		<td>
			<?php echo $customer->companyname;?>
			<hr>
			<span class="green"><?php echo $customer->fix_note;?></span>
			<?php
				if($customer->is_5_tax == 1 )
				{
					echo  '<br /> <h3 class="green">GST: 5%</h3><br />';
				}

				if(!empty($customer->description))
				{
					$description = explode("- ", $customer->description);
					$description = implode("<br />- ", $description);
				?>	
					<span class="green"><?php echo $description;?></span>
				<?php
				}
				
				if(
					isset($transporters)
					&&
					count($transporters)
				)
				{
					echo '<br />';
					foreach($transporters as $tra)
					{
						if(!empty($tra['name']) && strlen($tra['name']) > 0)
						{
							echo '<li>' . $tra['name'] .'</li>';
						}
					}
				}
			?>
		</td>
		<td><?php echo $customer->name;?></td>
		<td><?php echo round($customer->total_debit,2);?></td>
		<td><?php echo $customer->total_credit;?></td>
		<td><?php $balance = round($customer->total_credit - $customer->total_debit,0);
		$customerName = $customer->companyname ? $customer->companyname : $customer->name;
		$show = '<span class="green">'.$balance.'</span>';
			if($balance < 0 ) {
				$show = '<span class="red">'.$balance.'</span>';
			} 
			echo $show;
		?></td>
		<td>
			<?php echo $customer->mobile;?>
			<?php
			if(!empty($customer->officecontact))
			{
				echo "<br>" . $customer->officecontact;
			}

			if(!empty($customer->emailid))
			{
				echo "<hr />" . $customer->emailid;
			}
			?>
		</td>
		<td><?php echo $customer->city;?></td>
		<td><?php 
			$status = "Inactive";
				if($customer->status == '1') { $status = "Active"; }
				echo $status;
		?></td>
		<td><a target="_blank" href="<?php echo site_url();?>/account/account_details/<?php echo $customer->id;?>">View</a>
		||
			<a target="_blank" href="<?php echo site_url();?>/customer/edit/<?php echo $customer->id;?>">Edit</a>
		||
			<a href="javascript:void(0);"
			data-customer="<?php echo $customerName;?>"
			data-mobile="<?php echo $customer->mobile;?>"
			 data-balance="<?php echo $balance;?>" class="remind-amount" data-id="<?php echo $customer->id;?>">Remind</a>
			 ||
			 <a target="_blank" href="<?php echo site_url();?>/customer/print_small/<?php echo $customer->id;?>">
			 	<i class="fa fa-2x fa-print" aria-hidden="true"></i>
			</a>

			

			</td>
		</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	<tr>
		<td colspan="11" align="center">
			<span class="btn btn-success" onclick="pagination('next');">Next</span>
			<span class="btn btn-success"  onclick="pagination('previous');">Previous</span>
			<input type="hidden" name="offset" id="offset" value="<?php echo $offset;?>">
		</td>
	</tr>
	
	</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->
</div>
