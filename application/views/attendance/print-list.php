<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<h3><?php $title;?></h3>
			</div>
		</div>
	</div>
</div>
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
			<thead>
				<tr>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Sr</th>
				<th width="10%" style="border: 2px solid black; padding: 2px;">Name</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">W. Days</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Present</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Leave <br />Full Day</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Half Day</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Going Out <br />(Office Hours)</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Late <br /> Reached</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Before 10:00</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Stay After Office Time</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Half Night</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Full Night</th>
				<th width="5%" style="border: 2px solid black; padding: 2px;">Sunday</th>
				<th width="20%" style="border: 2px solid black; padding: 2px;">Notes</th>
				<th width="20%" style="border: 2px solid black; padding: 2px;">Sign</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sr =1;	
				foreach($items as $item) { 
					if(!isset($item['name']) || strlen($item['name']) < 2 )
						continue;
					?>
				<tr id="emp-<?php echo $item['id'];?>">
				<td style="border: 1px solid black; padding: 1px;"><?php echo $sr;?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['name'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['working_days'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['working_days'] - $item['full_day'] - ( $item['half_day'] / 2);?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['full_day'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['half_day'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['office_halfday'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['office_late'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['before_10'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['after_office_hrs'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['half_night'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['full_night'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['sunday'];?></td>
				<td style="border: 1px solid black; padding: 1px;"><?php echo $item['notes'];?></td>
				<td style="border: 1px solid black; padding: 1px;"> &nbsp;&nbsp;&nbsp;&nbsp; </td>
				</tr>
			<?php $sr++; } ?>
			</tbody>
		</table>
	</div>
</div>



