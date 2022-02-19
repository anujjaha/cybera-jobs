<h3><center><?php echo $title;?></center></h3>

<table align="center" border="2" style="border: solid 2px black;" width="100%">
<tr>
	<td style="border: solid 1px; width: 10%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Title
	</td>
	<td style="border: solid 1px; width: 55%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Full Address
	</td>
	<td style="border: solid 1px; width: 5%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Contact Number
	</td>
	<td style="border: solid 1px; width: 10%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Other Number
	</td>
</tr>
<?php
foreach($menus as $menu)
{
?>
	<tr>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['title'];?>
	</td>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['full_address'];?>
	</td>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['contact_number1'];?>
	</td>

	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['contact_number2'];?>
	</td>
</tr>
<?php
}
?>
</table>
