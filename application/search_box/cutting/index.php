<?php
	//pr($jobs);
?>

<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />
<style>
	audio {
		display:none;
	}
</style>
<script>
    $(document).ready(function() {
      $('.fancybox').fancybox({
        'width':900,
        'height':600,
        'autoSize' : false,
    });
});

function show_cutting_details(job_id,sr){
	view_job(sr,job_id);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_cutting_details/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_view").html(data);
            }
          });
}
</script>
<script>
function stopaudio() {
	$('audio').each(function(){
    this.pause(); // Stop playing
    this.currentTime = 0; // Reset time
}); 
}
function startaudio() {
	$('audio').each(function(){
    this.play(); // Stop playing
    this.currentTime = 0; // Reset time
}); 
}
</script>
<audio id="myAudio" controls autostart="true">
<source src="<?php echo CUTTING_MUSIC;?>" type="audio/mpeg">
</audio>
<div class="row">
</div>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>
			Job Id
		</th>
		<th>
			Customer
		</th>
		<th>
			Job Name
		</th>
		<th>Details</th>
		<!--<th>Bill Amount</th>
		<th>Advance</th>
		<th>Due</th>-->
		<th>Date / Time</th>
		</tr>
		</thead>
	<tbody>
		<?php
		/*$ctb = "<table><tr><td>Qty</td><td>Size</td><td>Print</td><td>Lamination</td>
							<td>Binding</td><td>Packing</td><td>Details</td></tr>";
		$job_count = count($jobs);*/
		$sr =1;	
		foreach($jobs as $job) {

			//pr($job);
			$cmaterial = '';
			$cmaterial .= "<table width='100%' border='2' style='margin-bottom: 15px; margin-top: 10px;'>
							<tr>
								<td width='20%' style='font-size: 20px; font-weight: bold;''>Details:</td>
								<td width='70%'  style='font-size: 20px; font-weight: bold;'>".$job['c_details']."</td>
							</tr>

							<tr>
								<td style='font-size: 20px; font-weight: bold;''>Qty:</td>
								<td style='font-size: 20px; font-weight: bold;'>".$job['c_qty']."</td>
							</tr>

							<tr>
								<td style='font-size: 20px; font-weight: bold;'>Size:</td>
								<td style='font-size: 20px; font-weight: bold;'>".$job['c_size']."

								<span style='margin-left: 50px;'>Total Sheets: ".$job['c_sheet_qty']."</span>
								</td>
							</tr>

							<tr>
								<td style='font-size: 20px; font-weight: bold;'>Print:</td>
								<td style='font-size: 20px; font-weight: bold;'>".$job['c_print']."</td>
							</tr>";


					if(strlen($job['c_lamination']) > 1)
					{
						$cmaterial .= "<tr>
								<td style='font-size: 20px; font-weight: bold;'>Lamination</td>
								<td style='font-size: 20px; font-weight: bold;'>".$job['c_lamination']."</td>
							</tr>";
					}

					if(strlen($job['c_binding']) > 1)
					{
						$cmaterial .= "<tr>
								<td style='font-size: 20px; font-weight: bold;'>Binding</td>
								<td style='font-size: 20px; font-weight: bold;'>".$job['c_binding']."</td>
							</tr>";
					}

					if(strlen($job['c_packing']) > 1)
					{
						$cmaterial .= "<tr>
								<td style='font-size: 20px; font-weight: bold;'>Packing</td>
								<td style='font-size: 20px; font-weight: bold;'>".$job['c_packing']."</td>
							</tr>";
					}
			
			$cmaterial .= "</table>";
			
			 ?>
		<tr>
			<td>
			<p id="jview_<?php echo $job['j_id'];?>">
			<?php

				if(in_array($job['j_id'], $view_jobs)) 
				{
					echo $job['j_id'];
				}else { 
					?>
				
				<script>startaudio();</script>	
				 <i class="fa fa-refresh fa-spin fa-4x" onclick="view_job(<?php echo $sr;?>,<?php echo $job['j_id'];?>);"></i><?php } ?>
			</p>
			</td>
		<td>
			<?php echo $job['j_id'];?>
			</td>
		<td>
			<?php echo $job['companyname'] ? $job['companyname']:$job['name'] ;?>
		</td>
		<td>
			<?php echo $job['jobname'];?>
		</td>
		
		<td width="80%">
			<?php echo $cmaterial;?>

		</td>
		<td><?php echo date('h:i a d-M',strtotime($job['created']));?>
			<!-- <br>
			<a href="javascript:void(0);" onclick="quick_update_job_status(<?php echo $sr;?>,<?php echo $job['job_id'];?>,'<?php echo JOB_CUTTING;?>');">
				Cutting
			</a>
			<hr> -->
			<a href="javascript:void(0);" onclick="quick_update_job_status(<?php echo $sr;?>,<?php echo $job['j_id'];?>,'<?php echo JOB_CUTTING_COMPLETED;?>');">
				Cutting-Completed
			</a>
			
			
		</td>
		<!-- <td><?php echo $job['jstatus'];?></td> -->
		
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	<input type="hidden" name="get_job_count" id="get_job_count" value="<?php echo $job_count;?>">
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
                    "iDisplayLength": 50,
                    "bFilter": true,
                    "bSort": false,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                });
            });
            
function update_job_status(id) {
	var value = $( "input:radio[name=jstatus]:checked" ).val();
	 $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/cuttings/update_job_status_cutting/"+id, 
         data:{"j_id":id,"j_status":value},
         success: 
              function(data){
				            $.fancybox.close();
                            location.reload();
			 }
          });
}

function quick_update_job_status(sr,id,value) {
	view_job(sr,id);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/cuttings/update_job_status_cutting/"+id, 
         data:{"j_id":id,"j_status":value},
         success: 
              function(data){
              	alert("Job Updated !");
	                location.reload();
			 }
          });
}

function update_datatable_grid() {
	return ;
		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_cutting_datatable/jstatus/Pending", 
         success: 
            function(data){
				//location.reload();
				jQuery("#job_datatable").html(data);
				$('#example1').dataTable({
						"bPaginate": true,
						"bLengthChange": true,
						"iDisplayLength": 50,
						"bFilter": true,
						"bSort": false,
						"bInfo": true,
						"bAutoWidth": true,
						"bDestroy": true,
					});
				
            }
          });
}

function loadlink() {
		var jcount = jQuery("#cutting_counter").val();

		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_cutting_count/", 
         success: 
            function(data){
            	if(typeof jcount != "undefined" &&  jcount != data) 
            	{
            		jQuery("#cutting_counter").val(data);
					update_datatable_grid();

					setTimeout(function()
					{
						location.reload();
					}, 10000);
				}
				return true;
          }
          });
}
  
loadlink(); 

setInterval(function(){
    loadlink();
}, 10000);

function view_job(sr,id) {
	stopaudio();
	jQuery("#jview_"+id).html(id);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_view", 
         data:{'id':id,'department':'<?php echo $this->session->userdata['department'];?>'},
         success: 
            function(data){
            	console.log('data');
				return true;
          }
          });
}	
</script>
<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>

<input type="hidden" name="cutting_counter" id="cutting_counter" value="<?php echo count($jobs);?>">
