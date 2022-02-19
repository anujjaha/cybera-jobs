<h3><center><?php echo $title;?></center></h3>

<table align="center" border="2" style="border: solid 2px black;" width="100%">
<tr>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Date
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		J Num
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Name
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Job Name
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Mobile
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Bill Amount
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Due
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Receipt
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		Status
	</td>
</tr>
<?php
foreach($jobs as $job)
{
?>
	<tr>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php echo date('d-m-y',strtotime($job['created']));?> || <?php echo 	date('h:i A',strtotime($job['created']));?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php
				$isShowJobId = true;
				
				if(isset($job['is_hold']) && $job['is_hold'] == 1)
				{
					echo '<span class="red">' .   $job['job_id'] . '</span>';
					echo '<br><span class="red"> Payment </span>';
					$isShowJobId = false;
				}
				else
				{
					echo '<br>';
				}

				if(isset($job['cyb_delivery']) && $job['cyb_delivery'] == 0)
				{
					if($isShowJobId)
					{
						echo '<span class="bold-font">' .   $job['job_id'] . '</span>';
					}
					echo '<br><span class="green"> Delivery </span>';
					$isShowJobId = false;
				}
				else
				{
					echo '<br>';
				}
				
				if($isShowJobId)
				{
					echo $job['job_id'];
				}
				
				if(isset($job['is_pickup']) && $job['is_pickup'] == 1)
				{
					echo '<br><span class="blue"> Pickup </span>';	
				}
				else
				{
					echo '<br>';
				}

				if(isset($job['is_manual']) && $job['is_manual'] == 1)
				{
					echo '<br><span style="color: black; font-weight: bold;"> Complete At </span>';	
				}
			?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php 
			echo $job['companyname'] ? $job['companyname'] : $job['name'] ;
			
			echo $job['ctype'] == 1 ? '<span class="red">[D]</span>' : '<span class="green">[R]</span>';

			if($job['rating'] == 5)
			{
				echo '<br><span style="color: green; font-weight: bold;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 4)
			{
				echo '<br><span style="color: green;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 3)
			{
				echo '<br><span style="color: black;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 2)
			{
				echo '<br><span style="color: red;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if($job['rating'] == 1)
			{
				echo '<br><span style="color: red; font-weight: bold;"> Rating : ' .   $job['rating'] . '</span>';	
			}

			if(isset($job['is_hold']) && $job['is_hold'] == 1)
			{
				echo '<br><span class="red">' .   $job['payment_details'] . '</span>';
			}
			else
			{
				echo '<br>';
			}

			if(isset($job['cyb_delivery']) && $job['cyb_delivery'] == 0)
			{
				echo '<br><span class="bold-font green">' .   $job['delivery_details'] . '</span>';
			}
			else
			{
				echo '<br>';
			}

			
			if(isset($job['revision']) && $job['revision'] == 1)
			{
				?>
			
				
				<br>
				<span class="red">
							Please collect Payment before Job Complete.
				</span>
			<?php }
				
				if(isset($job['is_pickup']) && $job['is_pickup'] == 1)
				{
					echo '<br><span class="blue">'. $job['pickup_details'] .'</span>';
				}
				else
				{
					echo '<br>';
				}

				if(isset($job['is_manual']) && $job['is_manual'] == 1)
				{
					echo '<br><span style="color: black; font-weight: bold;"> '. $job['manual_complete'] .' </span>';	
				}
			?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php 
			echo $job['jobname'];
			if(isset($job['emp_name']))
			{
				echo "<br><br>[ ".$job['emp_name']." ]";
			}

		?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php echo $job['mobile'];?>
			<hr>
			<?php echo $job['jsmsnumber'];
			if(isset($job['emailid']))
			{
				echo '<span style="color: green;">'.$job['emailid'].'</span>';
			}

			
		?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php echo $job['total'];?>
			
			<?php
				if(isset($job['discount']) && $job['discount'] > 0)
				{
					echo '<hr><span class="green"> DISC : ' .$job['discount']. '</span>';
				}
				
					
			?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php
		
			if(getBillStatus($job['job_id']))
			{
				echo '-';
				echo "<br>";
				echo "-------";
				echo "<br>";
				
				$userBalance =  get_acc_balance($job['customer_id']);
				if($userBalance > 0 )
				{
					echo "<span style='color:green;font-weight:bold;'>".$userBalance."</span>";	
				}
				else
				{
					echo "<span style='color:red;font-weight:bold;'>".$userBalance."</span>";	
				}
			}
			else
			{
				
				$user_bal = get_balance($job['customer_id']) ;
				if($user_bal > 0 ) { 
					
					
					$due_amt = $job['due'] - $job['discount'];
					echo $due_amt?$due_amt:"<span style='color:green;font-weight:bold;'>0</span>";	
					
				} else {
					echo "-";
				}
				
					echo "<br>";
					echo "----------";
					echo "<br>";
					
					$userBalance =  get_acc_balance($job['customer_id']);
					if($userBalance > 0 )
					{
						echo "<span style='color:green;font-weight:bold;'>".$userBalance."</span>";	
					}
					else
					{
						echo "<span style='color:red;font-weight:bold;'>".$userBalance."</span>";	
					}
				}	
				?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php echo  str_replace(","," ",$job['receipt'].$job['t_reciept']);?>
			<?php echo  $job['other_payment'];?>
			<?php 
				$showBillNumbers = [];
				$jbBill = '';
				if(!in_array($job['bill_number'], $billNumber))
				{
					$jbBill = str_replace(","," ", $job['bill_number']);
				}
				
				if(!in_array($job['bill_number'], $billNumber))
				{
					$tempBill =  str_replace(",","", $job['t_bill_number']);
					$tempBill =  str_replace(",","", $tempBill);

					if($jbBill == $tempBill)
					{
						echo $jbBill;
					}
					else
					{
						echo $jbBill . ' '.$tempBill;
					}
				}
				else
				{
					echo $jbBill;
				}

				$showBillNumbers = array_unique($showBillNumbers);
			?>
	</td>
	<td style="border: solid 1px; width: 33%; padding: 10px; font-size: 24pt; font-weight: bold;" > 
		<?php
				if($job['jstatus'] == JOB_COMPLETE) {
					echo "<span class='blue'>".$job['jstatus']."</span>";
				} else {
					echo "<span class='red'>".$job['jstatus']."</span>";
				}
				
				echo "</a><br>";
				
				if($job['is_delivered'] == 0 )
				{
					echo  '<span id="jobd-'.$job['job_id'].'" class="red">Un-Delievered</span>';
				}
				else
				{
					 echo " ( Delivered )";
					 echo "<br>" . $job['custom_delivery'];
				}
				?>
	</td>
</tr>
<?php
}
?>

</table>
