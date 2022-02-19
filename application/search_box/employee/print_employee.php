
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
<script type="text/javascript">
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}


</script>
<button class="btn btn-primary" onclick="print_job()">PRINT NOW</button>
<!--<button class="btn btn-primary" onclick="print_cutting()">Cutting Slip</button>-->
<div class="row">
	<div class="col-md-12">
		<h1>Print Employee Details</h1>
	</div>
</div>


<div id="printJobTicket" style="height:8.3in; width:5.8in; font-size:8px; font-family:Arial, Helvetica, sans-serif;">


?>
</div>


</div>
<!--Print Cutting Ticket End-->
<!--Small Print Courier Service End-->

<script>
function print_job() {
	printDiv('printJobTicket');
/*$.ajax({
type: "POST",
url: "<?php echo site_url();?>/jobs/print_job_ticket/"+<?php echo $job_data->id;?>, 
success: 
function(data){
print_cutting();
return true;
}
});*/
}
function print_cutting() {
	printDiv('printCuttingTicket');
/*$.ajax({
type: "POST",
url: "<?php echo site_url();?>/jobs/print_cutting_ticket/"+<?php echo $job_data->id;?>, 
success: 
function(data){
return true;
}
});*/
}

function print_courier_small() {
	printDiv('smallprintCourierTickret');
}
function print_courier() {
	printDiv('printCourierTickret');
	/*$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/jobs/print_courier_ticket/"+<?php echo $job_data->id;?>, 
         success: 
              function(data){
							return true;
			 }
          });*/	
}

function edit_job() {
	window.location.assign("<?php echo site_url();?>/jobs/edit_job/<?php echo $job_data->id;?>");
}

function print_cutting_pdf(id)
{
	jQuery("#printCuttingPdfBtn").attr('disabled', 'disabled');
	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/generaeAjaxCuttingSlip/"+id,
		method: "GET",
		dataType: 'JSON',
		success: function(data)
		{
			if(data.status == true)
			{
				window.open(data.link);
			}
			else
			{
				alert("Unable to Create PDF");
			}
		},
		complete: function(data) {
			jQuery("#printCuttingPdfBtn").removeAttr('disabled');
		}
	});

}
</script>
<div id="editCuttingSlipLive">
<?php
//pr($cutting_info);
	//	pr($job_data);
?>
</div>
