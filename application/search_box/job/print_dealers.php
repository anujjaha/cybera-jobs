<h3><center>Dealer List</center></h3>
<table align="center" border="2" style="border: solid 2px black;" width="100%">
<tr>
<?php
	$sr = 0;
	foreach($data as $value) {
?>
	
		<td style="border: solid 1px; width: 33%; padding: 10px;" > 
			<span style="width: 150px;">
				Company Name :
			</span>
			<?php echo $value->companyname;?>
			<br>
			<span style="width: 150px;">
				Contact Name :
			</span>
			<?php echo $value->name;?>
			<br>
			<span style="width: 150px;">
				Mobile :
			</span> <?php echo $value->mobile;?>

			<?php 
			echo strlen($value->officecontact) > 2 ?  '|' . $value->officecontact : '';?>

			<br>
			<span style="width: 150px;">
				Address :
			</span> <?php echo $value->add1;?>
			<br>
			<span style="width: 150px;">
				
			</span> 
			<?php echo $value->add2;?>
			<span style="width: 150px;">
				City : 
			</span> <?php echo $value->city;?>
			 <span style="width: 150px;">
				State : 
			</span> <?php echo $value->state;?> 
			<br>
			<span style="width: 50px;">
				Pin Code :
			</span> <?php echo $value->pin;?>
		</td>
<?php
	$sr++;
	if(($sr % 3) == 0)
	{
		?>
		</tr><tr>
		<?php
	}
	}
?>
</table>