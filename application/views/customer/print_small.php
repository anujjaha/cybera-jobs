<style>
    @media print
        {
        body div, body table {display: none;}
        body div#FAQ, body div#FAQ table {display: block;}
        }
td{font-size:9px; font-family:Arial, Helvetica, sans-serif}
.own-address td {
	font-size:12px;
	
}
.customer-address  td{
	font-size:12px;
}
.small-own-address td {
	font-size:7px;
	
}
.small-customer-address  td{
	font-size:8px;
}
#smallprintCourierTickret td {
	font-size:8px;
}

.table-curved {
    border-collapse:separate;
    border: solid #ccc 1px;
    border-radius: 25px;
}
</style>


<!--Small Print Courier Service-->
<div id="smallprintCourierTickret" style="height:5.7in; width:8.5in;  font-family:Arial, Helvetica, sans-serif;">

<table align="center" border="2" width="65%" style="border: 2px solid #000000; border-radius: 10px;">
<tr>
<td>
<table align="center" border="0" width="95%">
	<tr>
		<td>
			<table align="left" width="100%" border="0">
			<tr>
				<td> 
					<span style="font-size:15px;">
						<strong>To, </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td> 
					<span style="font-size:15px; font-weight: bold;  line-height: 95%;">
						<strong><?php echo $customer->companyname ?  $customer->companyname :  $customer->name;?> </strong>
					</span>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" class="small-customer-address" style="font-size:14px;  line-height: 95%;">
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							<?php echo $customer->add1." ".$customer->add2;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							<?php echo $customer->city." ".$customer->state." ".$customer->pin;?>
						</td>
					</tr>
					<tr>
						<td style="font-size:14px;  line-height: 95%;">
							Mobile - <?php echo $customer->mobile;?>
						</td>
					</tr>
					<?php
					if(isset($transporter_info)) {
					?>
					<!--<tr>
						<td style="font-size:14px;  line-height: 95%;">
							Delivery By : <?php echo $transporter_info->name;?>
						</td>
					</tr>-->
					<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		 </td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%">
			<tr>
				<td width="8%">&nbsp;</td>
				<td>
					<table width='100%' align='right' border='0' class="small-own-address">
					<?php
						if(1==1)
						{
					?>
						<tr style="height:5px;">
							<td>&nbsp;</td><td style="font-size:12px;  line-height: 14px;"><strong>From, CYBERA PRINT ART</strong> </td>
						</tr>
						<tr style="height:5px;"><td>&nbsp;</td><td style="font-size:12px;  line-height: 14px;">
						G/3, Samudra Annexe,Nr. Girish Cold Drink Cross Road,
						<br>
						Off C.G. Road, Navrangpura Ahmedabad - 009
						<br>
						Call : 079-26565720 / 26465720 | 9898309897
						<!-- <br>
						<br>
						We will Remain Close during 28th OCT TO 3rd NOV 2019
						<br>
						<strong>Wish you Happy Diwali</strong> -->
						<br>
					</td>
					</tr>
					<?php
						}
					?>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
</div>

<script type="text/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
	jQuery(document).ready(function(){
		setTimeout(function()
		{
			printDiv('smallprintCourierTickret');
		}, 100);	
	})
</script>