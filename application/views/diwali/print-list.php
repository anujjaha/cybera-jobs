<h3><center><?php echo $title;?></center></h3>

<table align="center" border="2" style="border: solid 2px black;" width="100%">
<tr>
	<td style="border: solid 1px; width: 10%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Code
	</td>
	<td style="border: solid 1px; width: 55%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Menu Name
	</td>
	<td style="border: solid 1px; width: 5%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		QTY
	</td>
	<td style="border: solid 1px; width: 10%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Rate Per Pcs.
	</td>
	<td style="border: solid 1px; width: 10%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Price for Additional Pages
	</td>
	<td style="border: solid 1px; width: 10%; padding: 5px; font-size: 16pt; font-weight: bold;" > 
		Process Time
	</td>
</tr>
<?php
foreach($menus as $menu)
{
?>
	<tr>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['code'];?>
	</td>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['title'];?>
	</td>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['qty'];?>
	</td>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['price'];?>
	</td>

	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['extra'];?>
	</td>
	<td style="border: solid 1px; padding: 5px; font-size: 14pt; font-weight: bold;" > 
		<?php echo $menu['working_days'];?>
	</td>
</tr>
<?php
}
?>
</table>

<ul>
	<li style="font-size: 15px;"><strong>No Guaranty for Lamination / Coating while Folding / Creasing. </strong></li>
	<li style="font-size: 15px;"><strong>Life of Lamination / Coating Depends on Usage of the menu. </strong></li>
	<li style="font-size: 15px;"><strong>Keep this menu out of reach of hot vessel or Hot Surface.</strong></li>
	<li style="font-size: 15px;">Payment terms: 100% Advance.</li>
	<li style="font-size: 15px;">Rates can be changed as per pages & material of menu.</li>
	<li style="font-size: 15px;">Rates are subject to change without any prior notice.</li>
	<li style="font-size: 15px;">Delivery & Transaportation Charges will be extra.</li>
	<li style="font-size: 15px;">Delivery Time Extra.</li>
</ul>
<h3 style="font-size: 24px;">
Email: <a href="mailto:cybera.printart@gmail.com">cybera.printart@gmail.com</a>
</h3>
