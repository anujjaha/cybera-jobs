<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script>

$(document).ready(function() {
var oldStart = 0;
$('#example1').dataTable( {
//here is our table defintion
"fnDrawCallback": function (o) {
	if ( o._iDisplayStart != oldStart ) {
	$(".dataTables_scrollBody").scrollTop(0);
	oldStart = o._iDisplayStart;
	}
}
</script>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Special Rates </h3>
	</div><!-- /.box-header -->
	<div class="box-header">
		<span>
			<a class="btn btn-lg btn-success pull-right" href="<?php echo site_url();?>/customer/add_special/">Add New</a>
		</span>
	</div>
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Company Name</th>
		<th>Title</th>
		<th>Quantity</th>
		<th>Rates</th>
		<th>Description</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($rates as $rate) {
		 ?>
		<tr id="tr_<?php echo $rate->rate_id;?>">
		<td><?php echo $sr;?></td>

		<td>
			<?php 
			if(strlen($rate->companyname) > 0)
			{
				echo $rate->companyname;
			}
			else
			{
				echo $rate->name;	
			}
			?>
		</td>
		<td><?php echo $rate->title;?></td>
		<td><?php echo $rate->qty;?></td>
		<td><?php echo $rate->rate;?></td>
		<td><?php echo $rate->rate_description;?></td>
		<td>
			<a href="<?php echo site_url();?>customer/edit_rate/<?php echo $rate->rate_id;?>">Edit</a>
			<a href="javascript:void(0);" onclick="delete_rate(<?php echo $rate->rate_id;?>);">Delete</a>
		</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
            $(function() {
               
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "iDisplayLength": 50
                });
            });
            
function delete_rate(id){
	var status = confirm("Are you Sure, Want to Delete ? ");
	if(status == true) {
		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_delete_rate/"+id, 
         success: 
            function(data) {
				jQuery("#tr_"+id).css('display','none');
			}
          });
    }
}            
</script>


