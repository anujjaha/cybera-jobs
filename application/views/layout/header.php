<?php
$showSidebard = true;

if($this->session->userdata['department'] == 'new')
{
    $showSidebard = false;    
}

?>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>


<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery.datetimepicker.css" media="screen" />


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<style type="text/css">



.ui-autocomplete {
	position: absolute;
	z-index: 10000000;
	font-size: 18px;
	font-weight: bolder;
	height: 200px;
	overflow-y: scroll;
	overflow-x: hidden;
	background-color: #e4e2e2;
}


.ui-menu .ui-menu-item a{
    height: 12px;
    font-size: 14px;
    color: black;
}

.mt-20 {
	margin-top: 20px;
}

.w75 {
	width: 75% !important;
}

.d-none {
	display: none;
}
</style>



<?php
	if(!isset($_SESSION['transporters_data']))
	{
		$_SESSION['transporters_data'] = getCurrentTransporters();	
	}

	if(!isset($_SESSION['customer_names_data']))
	{
		$_SESSION['customer_names_data'] = getCustomerTitlesOnly();	
	}

	if(!isset($_SESSION['sticker_estimate_titles']))
	{
		$_SESSION['sticker_estimate_titles'] = getEstimateTitles();	
	}



	
?>
<script>
function show_calculator()
	{
		window.open('<?php echo base_url();?>calc.html','Calculator','width=360,height=320,left=775,top=50')
	}


window.setInterval(function(){
  //check_notifications();
}, 10000);

function check_notifications() 
{
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/check_notifications/", 
		 success: 
            function(data){
				if(data == 'Please Check Delivery Jobs !')
				{
					alert(data);
					return;
				}
				if(data != 0) {
					alert('New Notifiction');
					show_notifications(data);
				}
			}
          });
}

function show_notifications(data) {
	jQuery("#notification_div").html(data);

	$('.datepicker').datetimepicker({
		dayOfWeekStart : 1,
		lang:'en',
		disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
		step:10
	});  
	

	$.fancybox({
                'href': '#notification_div'
	});

	jQuery("#setSnooze").on('click', function()
	{
		var reScheduleId = jQuery(this).attr('data-id');

		if(reScheduleId != 0)
		{
			jQuery.ajax(
			{
	        	type: 		"POST",
	        	dataType: 	'JSON',
	         	url: 		"<?php echo site_url();?>/ajax/reschedule_timer/", 
	         	data: {
	         		id: reScheduleId,
	         		value: jQuery("#re_reminder_time").val()
	         	},
	         success: 
	            function(data)
	            {
	            	if(data.status == true)
	            	{
	            		alert("Reschedule Reminder To : "+jQuery("#re_reminder_time").val()+" Successfully Done.");
						$.fancybox.close();

						return;
	            	}
	            	alert("Reschedule Reminder To : "+jQuery("#re_reminder_time").val()+" Successfully Done.");
	            	//alert("Something Went Wrong !");
	            }
	        });
		}
	});
}
var currentLoginUserFName = "<?= explode(" ", $_SESSION['username'])[0];?>";

if(currentLoginUserFName == "Master")
{
	currentLoginUserFName = 'Shaishav';
}
var menuTerms1 = `\n*Please Note:*
- No Guaranty for Lamination / Coating in the menu.
- Life of Lamination / Coating Depends on Usage of the menu.
- Keep this menu out of reach of hot vessel or Hot Surface. \n`;

var menuTerms2 = `
Thank You\n
`+ currentLoginUserFName.toUpperCase() + `\n\nCYBERA PRINT ART \n
Please Feel Free to call for more clarifications`.toUpperCase();
var resMenus = JSON.parse('<?= json_encode(getAllMenu());?>');

var cnoteTerms = `\n\nThank You\n`+ currentLoginUserFName.toUpperCase() +`\n\n
CYBERA PRINT ART \n\n
Please Feel Free to call for more clarifications`.toUpperCase();

function copyCNotesNow()
{
	var payment = '';
	var cjnotes = '';
	var cjexnotes = '';

	var cjprocess = '';
	var cjpacking = '';
	var cjtby = '';
	var cjtbyRs = $("#cjtbyRs").val();
	var cjprocessTime = '';
	var cjtPayby = '';

	var cjgst = '';
	var cjprocessType = '';
	var cjTotalAmt = '';
	var cjSubTotalAmt = '';
	var eValidTill = '';
	var eApproxDeli  = '';

	if($("#e_valid_till").val().toString() != "0" && $("#e_valid_till").val() > 0)
	{
		eValidTill = '\n\n *Estimate Validity:* ' + $("#e_valid_till").val() + ' working day/s ';
	}

	if($("#e_approx_delivery").val().toString() != "0" && $("#e_approx_delivery").val() > 0)
	{
		eApproxDeli = '\n\n *Approx Delivery :* ' + $("#e_approx_delivery").val() + ' working day/s ';
	}
	
	if($("#cpayment").val() != '0' )
	{
		payment = '\n\n *- Payment Terms:' + $("#cpayment").val() + '*';
	}

	if($("#cjprocessTime").val() != '0')
	{
		cjprocessTime = ' + Delivery Time Extra';
	}

	if($("#cjprocess").val() != '0' )
	{
		cjprocessType = $("#cjprocessType").val();
		cjprocess = '\n *- PROCESS: ' + $("#cjprocess").val() + ' WORKING '+ cjprocessType + cjprocessTime +'*';
		 
	}

	if($("#cjpacking").val() != '0' )
	{
		cjpacking = '\n *- Packing Forwarding RS. ' + $("#cjpacking").val() + '*';
	}

	if($("#cjtPayby").val() != '0')
	{
		cjtPayby = ' PAID By:' + $("#cjtPayby").val();
	}

	if($("#cjtby").val() != '0')
	{
		cjtby = '\n *- Transportation By: ' + $("#cjtby").val() + '*';
	}

	if($("#cjtbyRs").val() != '0')
	{	
		cjtby += ' *RS. ' +$("#cjtbyRs").val() + cjtPayby +'*';
	}
	/*else
	{
		cjtby = '\n *- Transportation By: ' + $("#cjtby").val() + ' ' + cjtPayby + '*';
	}*/

	if($("#cjgst").val() != '0' && $("#cjgst").val() != 'Extra')
	{
		var showGSTAmt = parseFloat($("#cjgstHide").val());

		console.log('showGSTAmt', showGSTAmt);

		if(showGSTAmt.toString().length > 0 && showGSTAmt > 0)
		{
			
			cjgst = '\n *- GST: ' + $("#cjgst").val() + '% : RS. '+showGSTAmt+'*';
		}
		else
		{
			$("#gstLabel").html('');
			cjgst = '\n *- GST: ' + $("#cjgst").val() + '% EXTRA*';	
		}
		
	}
	if($("#cjgst").val() == 'Extra' )
	{
		cjgst = '\n *- GST: EXTRA*';
	}

	if($("#cjnotes").val() != '0' )
	{
		var tempcjnotes = '';
		for(var jx = 0; jx < $("#cjnotes").val().length; jx++)
		{
			tempcjnotes = tempcjnotes + '\n *' + $("#cjnotes").val()[jx] + '*';
		}
		cjnotes = tempcjnotes;
	}

	if($("#cjexnotes").val().length > 0 )
	{
		cjexnotes = '\n\n *Note:* ' + $("#cjexnotes").val();
	}

	if($("#cjTotalAmt").val() != '0' )
	{
		cjTotalAmt = '\n\n *TOTAL Amount RS. ' + $("#cjTotalAmt").val() + '*\n';
	}


	if($("#cjtby").val().length == 0)
	{
		cjtby = '';
	}

	saveWAestimate();

	$("#resEstimateData").val(
	'*'+ $("#cname").val() +'*'+ '\n \n*'+ $("#ctitle").val() + '*\n\n'
	+ $("#cnotes").val()
	+  '\n'
	+ cjprocess.toUpperCase() 
	+ cjpacking.toUpperCase() 
	+ cjtby.toUpperCase() 
	+ cjgst.toUpperCase() 
	+ cjTotalAmt.toUpperCase() 
	+ payment.toUpperCase() 
	+ cjnotes.toUpperCase() 
	+ cjexnotes.toUpperCase()
	+ eApproxDeli.toUpperCase()
	+ cnoteTerms.toUpperCase()
	+ eValidTill.toUpperCase()
	);
}


function copySNotesNow()
{
	var payment = '';
	var cjnotes = '';
	var cjexnotes = '';

	var cjprocessX = '';
	var cjpacking = '';
	var cjtby = '';
	var cjtbyRs = $("#pcjtbyRs").val();
	var cjprocessTime = '';
	var cjtPayby = '';

	var cjgst = '';
	var cjprocessType = '';
	var cjTotalAmt = '';
	var cjSubTotalAmt = '';
	var eValidTill = '';
	if($("#pe_valid_till").val() > 0)
	{
		eValidTill = '\n\n *Estimate Validity:* ' + $("#pe_valid_till").val() + ' working day/s ';

	}
	
	if($("#pcpayment").val() != '0' )
	{
		payment = '\n\n *- Payment Terms:' + $("#pcpayment").val() + '*';
	}

	if($("#pcjprocessTime").val() != '0')
	{
		cjprocessTime = ' + Delivery Time Extra';
	}

	if($("#pcjprocess").val() != '0' )
	{
		cjprocessType = $("#pcjprocessType").val();
		cjprocessX = '\n *- PROCESS: ' + $("#pcjprocess").val() + ' WORKING '+ cjprocessType + ' ' + cjprocessTime +'*';
	}

	if($("#pcjpacking").val() != '0' )
	{
		cjpacking = '\n *- Packing Forwarding RS. ' + $("#pcjpacking").val() + '*';
	}

	if($("#pcjtPayby").val() != '0')
	{
		cjtPayby = ' PAID By:' + $("#pcjtPayby").val();
	}

	if($("#pcjtby").val() != '0' )
	{
		cjtby = '\n *- Transportation By: ' + $("#pcjtby").val() + '*';
	}
	if($("#pcjtbyRs").val() != '0')
	{
		cjtby += '* RS. ' +$("#pcjtbyRs").val() + cjtPayby +'*';
	}
	/*else
	{
		cjtby = '\n *- Transportation By: ' + $("#pcjtby").val() + ' ' + cjtPayby + '*';
	}*/

	if($("#pcjgst").val() != '0' && $("#pcjgst").val() != 'Extra')
	{
		var showGSTAmt = parseFloat($("#pcjgstHide").val());

		console.log('showGSTAmt', showGSTAmt);

		if(showGSTAmt.toString().length > 0 && showGSTAmt > 0)
		{
			
			cjgst = '\n *- GST: ' + $("#pcjgst").val() + '% : RS. '+showGSTAmt+'*';
		}
		else
		{
			$("#pgstLabel").html('');
			cjgst = '\n *- GST: ' + $("#pcjgst").val() + '% EXTRA*';	
		}
		
	}
	if($("#pcjgst").val() == 'Extra' )
	{
		cjgst = '\n *- GST: EXTRA*';
	}

	if($("#pcjnotes").val() != '0' )
	{
		var tempcjnotes = '';
		for(var jx = 0; jx < $("#pcjnotes").val().length; jx++)
		{
			tempcjnotes = tempcjnotes + '\n *' + $("#pcjnotes").val()[jx] + '*';
		}
		cjnotes = tempcjnotes;
	}

	if($("#pcjexnotes").val().length > 0 )
	{
		cjexnotes = '\n\n *Note:* ' + $("#pcjexnotes").val();
	}

	if($("#pcjTotalAmt").val() != '0' )
	{
		cjTotalAmt = '\n\n *TOTAL Amount RS. ' + $("#pcjTotalAmt").val() + '*\n';
	}


	if($("#pcjtby").val().length == 0)
	{
		cjtby = '';
	}
	var pNotes = getParkingNotes();
	

	$("#presEstimateData").val(
	'*'+ $("#pcname").val() +'*'+ '\n \n*'+ $("#pctitle").val() + '*\n\n'
	+ pNotes +
	+ cjprocessX.toUpperCase() 
	+ cjpacking.toUpperCase() 
	+ cjtby.toUpperCase() 
	+ cjgst.toUpperCase() 
	+ cjTotalAmt.toUpperCase() 
	+ payment.toUpperCase() 
	+ cjnotes.toUpperCase() 
	+ cjexnotes.toUpperCase()
	+ eValidTill.toUpperCase()
	+ cnoteTerms.toUpperCase());

	$("#presEstimateData").val($("#presEstimateData").val().replace('NaN', ' '));
	saveSAestimate(pNotes);/*
	$("#presEstimateData").select();
	document.execCommand('copy');*/
}

function saveSAestimate(jnotes)
{
    $.ajax({
       	type: "POST",
       	dataType: "JSON",
        url: "<?php echo site_url();?>/ajax/createWAestimate/", 
        data: {
        	"customer"		: $("#pcname").val(),
        	"e_type"		: 2,
			"title"			: $("#pctitle").val(),
			"process"		: $("#pcjprocess").val(),
			"procsss_time"	: $("#pcjprocessType").val(),
			"delivery_time"	: $("#pcjprocessTime").val(),
			"pack_forward"	: $("#pcjpacking").val(),
			"transport_by"	: $("#pcjtby").val(),
			"transport_cost": $("#pcjtbyRs").val(),
			"sub_total"		: $("#pcjSubTotalAmt").val(),
			"gst"			: $("#pcjgst").val(),
			"total"			: $("#pcjTotalAmt").val(),
			"pay_by"		: $("#pcjtPayby").val(),
			"payment"		: $("#pcpayment").val(),
			"job_notes"		: $("#pcjnotes").val(),
			"extra_notes"	: $("#pcjexnotes").val(),
			"details"		: jnotes,
		},
        success: function(data) {
        	console.log(data);
        	if(data.status == true)
        	{
        		var oldVal = $("#presEstimateData").val();

        		$("#presEstimateData").val(oldVal + '\n\n*EST-ID-'+ data.id + '*');
        		$("#presEstimateData").select();
				document.execCommand('copy');	
        	}
        	else
        	{
        		console.log('out side');
        		$("#presEstimateData").select();
				document.execCommand('copy');
        	}
		}
    });
}
function saveWAestimate()
{
	var showB = $("#cnotes_b").val(),
		printB = '',
		gPay   = '',
		payTm  = '';

	if(showB.length > 0 && showB != '' && $("#cnotes_b_show").val() == 'Yes')
	{
		printB = '\n' + showB;
	}


	if($("#e_p_g_pay").is(':checked'))
	{
		gPay = '\n' + 'Google/Phone Pay: 9898618697';
	}
	else
	{
		gPay = '';	
	}
	
	if($("#e_pay_tm").is(':checked'))
	{
		payTm = '\n' + 'PayTm (walet): 9898309897';
	}
	else
	{
		payTm = '';
	}

    $.ajax({
       	type: "POST",
       	dataType: "JSON",
        url: "<?php echo site_url();?>/ajax/createWAestimate/", 
        data: {
        	"customer"		: $("#cname").val(),
			"title"			: $("#ctitle").val(),
			"process"		: $("#cjprocess").val(),
			"procsss_time"	: $("#cjprocessType").val(),
			"delivery_time"	: $("#cjprocessTime").val(),
			"pack_forward"	: $("#cjpacking").val(),
			"transport_by"	: $("#cjtby").val(),
			"transport_cost": $("#cjtbyRs").val(),
			"sub_total"		: $("#cjSubTotalAmt").val(),
			"gst"			: $("#cjgst").val(),
			"total"			: $("#cjTotalAmt").val(),
			"pay_by"		: $("#cjtPayby").val(),
			"payment"		: $("#cpayment").val(),
			"job_notes"		: $("#cjnotes").val(),
			"extra_notes"	: $("#cjexnotes").val(),
			"details"		: $("#cnotes").val(),
			"details_b"		: $("#cnotes_b").val(),
			"validity_days" : $("#e_valid_till").val(),
			"approx_delivery_days" : $("#e_approx_delivery").val(),
		},
        success: function(data) {
        	console.log(data);
        	if(data.status == true)
        	{
        		var oldVal = $("#resEstimateData").val();

        		$("#resEstimateData").val(oldVal + printB + '\n\n*EST-ID-'+ data.id + '*'+ gPay +payTm);
        		$("#resEstimateData").select();
				document.execCommand('copy');	
        	}
        	else
        	{
        		console.log('out side');
        		$("#resEstimateData").select();
				document.execCommand('copy');
        	}
		}
    });
}

function getParkingNotes()
{
	var sr = 1;
	var html = '';
	var wheeler = '';
	var selWheeler = '';

	for(var i =0;i< $('input[name="wdetails"]').length; i++ )
	{
		wheeler = $($("[name='wheeler[]']")[i]).val();

		switch(wheeler)
		{
			case '2':
				selWheeler = '2 Wheeler';
			break;

			case '4':
				selWheeler = '4 Wheeler';
			break;

			case '6':
				selWheeler = '4 Wheeler ( 2 sided )';
			break;

			default:
				selWheeler = '2 Wheeler';
			break;
		}
		
		html += '*' +selWheeler + '*\n';
			html +=  $($("[name='corner_type[]']")[i]).val() + ' - ' + $($("[name='corner[]']")[i]).val() + ' - ' + $($('input[name="wdetails"]')[i]).val() + ' - ' + $($("[name='design[]']")[i]).val() + '\n';

			html +=  '\n*Qty : ' +  $($("[name='p_qty[]']")[i]).val() + 'PCS @ RS. '+ parseFloat($($("[name='p_rate[]']")[i]).val()).toFixed(2) +'*';

			html += '\n\n';
		sr++;
	}
	
	return html.toUpperCase();
}

function openPopupBoxRestuarant()
{
	$("#resMenuManager").modal('show');
	$("#resMenuClientName").val('');
	$('#resMenuOptionsPopUp').empty();
	$('#resMenuOptionsPopUp').append(`<option>Select Code</option>`);
	var shortName = '';
	for(i in resMenus)
	{
		$('#resMenuOptionsPopUp').append(`<option value="`+resMenus[i].code+`">`+resMenus[i].code +` (`+ resMenus[i].short_name +` )</option>`);
	}
}

function openPopupBoxGEstimate()
{
	$("#generalEstimate").modal('show');
	$("#cname").focus();
	
	$( "#cjtby" ).autocomplete({
      source: (<?= $_SESSION['transporters_data'];?>),
      	messages: {
        	noResults: '',
        	results: function() {}
    	}
    });

    $( "#cname" ).autocomplete({
      source: (<?= $_SESSION['customer_names_data'];?>),
      	messages: {
        	noResults: '',
        	results: function() {}
    	}
    });

    $( "#ctitle" ).autocomplete({
      source: (<?= $_SESSION['estimate_title_data'];?>),
      	messages: {
        	noResults: '',
        	results: function() {}
    	}
    });

    $("#cname").val('');
	$("#ctitle").val('');
	$("#cnotes").val('');
	$("#cnotes_b").val('');

	$("#cpayment").val('0');
	$("#cjnotes").val('0');
	
	$("#cjprocess").val('0');
	$("#cjprocessType").val('0');
	$("#cjpacking").val('0');
	$("#cjtby").val('0');
	$("#cjgst").val('0');
	$("#cjTotalAmt").val('0');

	
	$("#resEstimateData").val('');
}

function openPopupBoxPEstimate()
{
	$("#parkingEstimate").modal('show');
	$( "#pcjtby" ).autocomplete({
      source: (<?= $_SESSION['transporters_data'];?>),
      	messages: {
        	noResults: '',
        	results: function() {}
    	}
    });

    $("#pcname").focus();

    $( "#pcname" ).autocomplete({
      source: (<?= $_SESSION['customer_names_data'];?>),
      	messages: {
        	noResults: '',
        	results: function() {}
    	}
    });

    $( "#pctitle" ).autocomplete({
      source: (<?= $_SESSION['sticker_estimate_titles'];?>),
      	messages: {
        	noResults: '',
        	results: function() {}
    	}
    });

    

	$("#pcname").val('');
	$("#pctitle").val('');
	$("#pcnotes").val('');

	$("#pcpayment").val('0');
	$("#pcjnotes").val('0');
	
	$("#pcjprocess").val('0');
	$("#pcjprocessType").val('0');
	$("#pcjpacking").val('0');
	$("#pcjtby").val('0');
	$("#pcjgst").val('0');
	$("#pcjTotalAmt").val('0');

	
	$("#presEstimateData").val('');
}

function showResMenuOptToVal()
{
	var partyName   = $("#resMenuClientName").val();
	var preFix 		= '*' + partyName + '* \n \n*MENU ESTIMATE*\n\n'.toUpperCase();
	//var processTime = 'PROCESS: __ WORKING Day/s + Delivery Time Extra';
	var processTime = '';


	var rProcess 			= $("#rProcess").val();
	var rProcessTime 		= $("#rProcessTime").val();
	var rDeliveryTime 		= $("#rDeliveryTime").val();
	var rTransportBy 		= $("#rTransportBy").val();
	var rTransportByRs 		= $("#rTransportByRs").val();
	var rTransportPfrwd		= $("#rTransportPfrwd").val();
	var rGst 				= $("#rGst").val();
	var rPayBy 				= $("#rPayBy").val();
	var rPayment 			= $("#rPayment").val();
	var rEstimateValidity 	= $("#rEstimateValidity").val();
	var rEstimateExnotes	= '';
	var rEstimateNote 		= '';
	var extraMsg 			= '\n';
	var estimateValMsg		= '';

	if($("#rEstimateExnotes").val().length > 0 )
	{
		rEstimateExnotes = '*Note:* ' + $("#rEstimateExnotes").val();
	}

	
	if($("#rEstimateNote").val() != '0' )
	{
		var tempcjnotes = '';
		for(var jx = 0; jx < $("#rEstimateNote").val().length; jx++)
		{
			tempcjnotes = tempcjnotes + '\n *' + $("#rEstimateNote").val()[jx] + '*';
		}
		rEstimateNote = tempcjnotes;
	}

	

	if(rProcess != 0)
	{
		extraMsg += '*- PROCESS: ' + rProcess + ' WORKING ' + rProcessTime;

		if(rDeliveryTime != 0)
		{
			extraMsg += ' DELIVERY TIME EXTRA';
		}

		extraMsg += '*\n';
	}

	if($("#rTransportPfrwd").val() != '0' )
	{
		extraMsg += '*- Packing Forwarding RS. ' + $("#rTransportPfrwd").val() + '*\n';
	}

	if(rTransportBy != 0)
	{
		
		extraMsg += '*- TRANSPORTATION BY: '+ rTransportBy;

		if(rTransportByRs != 0)
		{
			extraMsg += '  RS. ' + rTransportByRs;
		}

		if(rPayBy != 0)
		{
			extraMsg += ' PAID BY: ' + rPayBy;
		}
		
		extraMsg += '*\n';
	}

	

	if(rGst != 0 )
	{
		if(rGst == 'Extra')
		{
			extraMsg += '*- GST: Extra*';	
		}
		else
		{
			extraMsg += '*- GST: '+ rGst + '%*';	
		}
		extraMsg += '\n';
	}

	if(rPayment != 0 )
	{
		extraMsg += '*- PAYMENT TERMS:100% ADVANCE* \n';	
	}

	if(rEstimateValidity != '')
	{
		estimateValMsg += '\n\nESTIMATE VALIDITY: '+ rEstimateValidity +' WORKING DAY/S \n';	
	}

	var buildMenu = '';
	var selectedOptions = $("#resMenuOptionsPopUp").val();
	for(i in resMenus)
	{
		if(1==1)
		{
			for(var j = 0; j < selectedOptions.length; j++)
			{
				if(selectedOptions[j] == resMenus[i].code)
				{
					buildMenu += ('*Code '+resMenus[i].code +':* '+resMenus[i].title + '\n'+ resMenus[i].qty + ' PCS @ RS.' + resMenus[i].price + ' PER PC + GST'+ '\n' + resMenus[i].extra).toUpperCase() + '\n\n';
				}		
			}
			

			// $("#resMenuOptionsPopUpVal").val(( preFix + '*Code '+resMenus[i].code +':* '+resMenus[i].title + '\n'+ resMenus[i].qty + ' PCS @ RS.' + resMenus[i].price + ' PER PC + GST').toUpperCase());


			// $("#resMenuOptionsPopUpValWith").val((preFix + '*Code '+resMenus[i].code +':* '+resMenus[i].title + '\n\n'+ resMenus[i].qty + ' PCS @ RS.' + resMenus[i].price + ' PER PC + GST' + '\n'+ extraMsg.toUpperCase()+ '\n' + rEstimateExnotes + '\n' + rEstimateNote + '\n' + menuTerms).toUpperCase() );

			
		}

		 $("#resMenuOptionsPopUpValWith").val((preFix +  buildMenu + '\n'+ extraMsg.toUpperCase()+ '\n' + rEstimateExnotes + '\n' + rEstimateNote + '\n' + menuTerms1 +  estimateValMsg + menuTerms2 ).toUpperCase());

		$("#resMenuOptionsPopUpExtra").html(resMenus[i].extra);

		$("#resMenuOptionsPopUpValWith").select();
		document.execCommand('copy');
	}
}

function estimateCalcTotal()
{
	var gst = $("#cjgst").val();
	var forwarding = parseFloat($("#cjpacking").val());
	var subTotal = parseFloat($("#cjSubTotalAmt").val());
	var transportRs = parseFloat($("#cjtbyRs").val());
	var finalTotal =  parseFloat(forwarding) + parseFloat(subTotal) + parseFloat(transportRs);

	$("#cjgstHide").val(0);
	$("#gstLabel").html('');
	if(gst != 0 && gst != 'Extra')
	{
		gst = parseFloat(gst);
		var gstValue = parseFloat(finalTotal * (parseFloat(gst)/100)).toFixed(2);

		$("#gstLabel").html('RS. '+ gstValue);
		$("#cjgstHide").val(parseFloat(gstValue));

		finalTotal = parseFloat(finalTotal) + parseFloat(gstValue);
	}
	
	$("#cjTotalAmt").val(finalTotal);
	console.log('estimateCalcTotal', finalTotal);
}

function estimateCalcRTotal()
{
	console.log('estimateCalcRTotal');
}

function estimateCalcPTotal()
{
	var gst = $("#pcjgst").val();
	var forwarding = parseFloat($("#pcjpacking").val());
	var subTotal = parseFloat($("#pcjSubTotalAmt").val());
	var transportRs = parseFloat($("#pcjtbyRs").val());
	var finalTotal =  parseFloat(forwarding) + parseFloat(subTotal) + parseFloat(transportRs);

	$("#pcjgstHide").val(0);
	$("#pgstLabel").html('');
	if(gst != 0 && gst != 'Extra')
	{
		gst = parseFloat(gst);
		var gstValue = parseFloat(finalTotal * (parseFloat(gst)/100)).toFixed(2);

		$("#pgstLabel").html('RS. '+ gstValue);
		$("#pcjgstHide").val(parseFloat(gstValue));

		finalTotal = parseFloat(finalTotal) + parseFloat(gstValue);
	}
	
	$("#pcjTotalAmt").val(finalTotal);
	console.log('estimateCalcpTotal', finalTotal);
}
</script>
    <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url();?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
               Cybera Print Art
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle collapsed-box" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">

                    <ul class="nav navbar-nav">
                    	<?php
                    		if($showSidebard)
                    		{
                    	?>
                    		<li class="dropdown messages-menu">
								<a href="#sms_address" class="fancybox">
                                <i class="fa fa-dashboard"></i> <span>Send Address</span>
                            </a>
							</li>

							<li class="dropdown messages-menu">
								<a href="<?php echo base_url().'employee/index'?>">
									Employee
								</a>
							</li>

							<li class="dropdown messages-menu">
								<a href="<?php echo base_url().'employee/overview'?>">
									Overview
								</a>
							</li>

							<li class="dropdown messages-menu">
								<a href="<?php echo base_url().'insurance/index'?>">
									Insurance
								</a>
							</li>
							<li class="dropdown messages-menu">
								<a href="<?php echo base_url().'cdirectory/index'?>">l
									Directory
								</a>
							</li>
							<!-- <li class="dropdown messages-menu">
								<a href="#schedule" class="fancybox">
									Schedule Job
								</a>
							</li> -->
                    	<?php
                    		}
                    	?>
						
						<!-- <li class="dropdown messages-menu">
							<a href="#show_calculator" onclick="show_calculator();">
								Calculator
							</a>
						</li> -->
						<!-- <li class="dropdown messages-menu">
							<a href="#hfancy_box_demo" class="fancybox">
								Cybera Estimation
							</a>
						</li>
						<li class="dropdown messages-menu">
							<a href="#estimation_details" class="fancybox">
								SMS Estimatation
							</a>
						</li> -->
						

						<?php
							if($showSidebard)
							{
						?>
							<!-- <li class="dropdown messages-menu">
								<a href="<?php echo base_url().'estimation/index'?>">
									Email Estimation
								</a>
							</li> -->
							<li class="dropdown messages-menu">
								<a href="<?php echo base_url().'cashier'?>">
									Cashier
								</a>
							</li>

							<li class="dropdown messages-menu">
								<a href="<?php echo base_url().'transporter'?>">
									Transporter
								</a>
							</li>
						<?php
							}
						?>
						
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo base_url('assets/img/avatar04.png')?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                        
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata['username'];?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <?php $profile = $this->session->userdata['profile_pic'];?>
                                    <img src="<?php echo base_url('assets/users/'.$profile)?>" class="img-circle" alt="User Image" />
                                    <p>
                                    <?php echo $this->session->userdata['username'];?> - 
                                    <?php echo $this->session->userdata['department'];?>
                                       
                                        <small>Cybera Team Member</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!--<li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <!--<div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>-->
                                    <div class="pull-right">
                                        <a href="<?php echo base_url();?>user/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
<div id="estimation_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
	
    <div id="create_estimate">
    <?php $all_customer = get_all_customers(); ?>
    <center>
		<a href="javascript:void(0);" onclick="show_calculator();" class="btn btn-success btn-lg">Calculator</a>
    </center>
    <ul class="tabs" data-persist="true">
            <li><a href="#regular_customers">Regular Customers</a></li>
            <li><a href="#new_customers">New Customer</a></li>
            <!-- <li><a href="#send_address">Cybera Address</a></li> -->
    </ul>
    <div class="tabcontents">
		<div id="regular_customers">
			<table align="center" border="2" width="80%">
				<tr>
					<td align="right"> Select Customer :</td>
					<td> 
						<select class="form-control estimate-customer-select" name="customer" id="customer" onchange="show_sms_mobile_address();">
							<option value="0" selected="selected">Select Customer</option>
							<?php
							foreach($all_customer as $customer) {
								$c_name = $customer->companyname;
								if(empty($c_name)) {
									$c_name = $customer->name;
								}
								echo "<option value='".$customer->id."'>".$c_name."</option>";
							}
							?>
						</select>
						</td>
				</tr>
				<tr>
					<td align="right">Contact Number:</td>
					<td><input type="text" id="sms_mobile" name="sms_mobile"></td>
				</tr>
				<tr>
					<td align="right">Message:</td>
					<td><textarea id="sms_message" name="sms_message" cols="80" rows="6"></textarea>
						Characters : <span id="charCount">0</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="hidden" id="customer_email" name="customer_email">
						<input type="hidden" name="sms_customer_name" id="sms_customer_name">
						<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="create_estimation();">
					</td>
				</tr>
			</table>
		</div>
		<div id="new_customers">
			<table align="center" border="2" width="80%">
				<tr>
					<td align="right">Customer Name :</td>
					<td> 
						<input type="text" name="n_sms_customer_name" id="n_sms_customer_name" style="width:500px;">
					</td>
				</tr>
				<tr>
					<td align="right">Contact Number:</td>
					<td><input type="text" id="n_sms_mobile" name="n_sms_mobile" style="width:500px;"></td>
				</tr>
				<tr>
					<td align="right">Email Id:</td>
					<td>
						<input type="text" style="width:500px;" id="n_customer_email" name="n_customer_email">
					</td>
				</tr>
				<tr>
					<td align="right">Message:</td>
					<td>
						<textarea id="n_sms_message" name="n_sms_message" cols="80" rows="6"></textarea>
						Characters : <span id="n_charCount">0</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="create_estimation_new();">
					</td>
				</tr>
			</table>
		</div>
		<!-- <div id="send_address">
			<table align="center" border="2" width="80%">
				<tr>
					<td align="right"> Select Customer :</td>
					<td> 
						<input type="text" class="form-control" name="address_customer" id="address_customer">
						</td>
				</tr>
				<tr>
					<td align="right">Contact Number:</td>
					<td><input type="text" class="form-control" id="address_sms_mobile" name="address_sms_mobile"></td>
				</tr>
				<tr>
					<td align="right">Message:</td>
					<td><textarea id="address_sms_message" name="address_sms_message" cols="80" rows="6">Cybera G-3 & 4, Samudra Annexe, Nr. Girish Cold Drinks Cross Road,Off C.G. Road, Navrangpura, Ahmedabad-009 Call 079-26565720 / 9898309897 http://goo.gl/Fpci9H</textarea>
						Characters : <span id="charCount">0</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="hidden" id="address_customer_email" name="customer_email">
						<input type="hidden" name="sms_customer_name" id="address_sms_customer_name">
						<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="send_address();">
					</td>
				</tr>
			</table>
		</div> -->
    </div>
    
    </div>
</div>
</div>

<div id="sms_address" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
	
    <div id="send_sms">
    <?php $all_customer = get_all_customers(); ?>
    <center>
		<a href="javascript:void(0);" onclick="show_calculator();" class="btn btn-success btn-lg">Calculator</a>
    </center>
    <ul class="tabs" data-persist="true">
            <li><a href="#send_address">Cybera Address</a></li>
            <li><a href="#send_feedback">Cybera Feedback</a></li>
    </ul>
    <div class="tabcontents">
		<div id="send_address">
			<table align="center" border="2" width="100%">
				<tr style="display: none;">
					<td align="right"> Select Customer :</td>
					<td> 
						<input type="text" class="form-control" name="address_customer" id="address_customer">
						</td>
				</tr>
				<tr>
					<td align="right">Contact Number:</td>
					<td><input type="text" class="form-control" id="address_sms_mobile" name="address_sms_mobile"></td>
				</tr>
				<tr>
					<td align="right">Message:</td>
					<td>
					<br />
					<textarea id="address_sms_message" name="address_sms_message" cols="80" rows="6">CYBERA PRINT ART G-3 & 4, Samudra Annexe, Nr. Girish Cold Drinks Cross Road, Off C.G. Road, Navrangpura, Ahmedabad. Mobile No: 9898309897- http://goo.gl/Fpci9H</textarea>
						Characters : <span id="charCount">0</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="hidden" id="address_customer_email" name="customer_email">
						<input type="hidden" name="sms_customer_name" id="address_sms_customer_name">
						<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="send_address();">
					</td>
				</tr>
			</table>
		</div>
		<div id="send_feedback">
			<table align="center" border="2" width="100%">
				<tr>
					<td align="right">Contact Number:</td>
					<td><input type="text" class="form-control" id="feedback_sms_mobile" name="feedback_sms_mobile"></td>
				</tr>
				<tr>
					<td align="right">Message:</td>
					<td>
					<br />
					<textarea id="feedback_sms_message" name="feedback_sms_message" cols="80" rows="6">Valuable Customer, CYBERA is seeking your precious feedback, kindly rate us on http://bit.ly/2z6bxpo for better products and services THANK YOU CYBERA PRINT ART</textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="hidden" id="address_customer_email" name="customer_email">
						<input type="hidden" name="sms_customer_name" id="address_sms_customer_name">
						<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="send_feedback();">
					</td>
				</tr>
			</table>
		</div>
    </div>
    
    </div>
</div>
</div>

<script>
	

	function bindCopyPSticker()
	{
		$("#copyESticker").on('click', function(e) {
			var newHtml = `<div class="extraAdded"><div class="col-md-10">
				<div class="col-md-12">
					<label>Select Wheeler:</label>	
					<select  onchange="selectWheeler(this)" class="form-control" name="wheeler[]">
						<option value="">Select Wheeler</option>
  						<option value="2">2 Wheeler</option>
  						<option  value="4">4 Wheeler</option>
  						<option  value="6">4 Wheeler ( 2 sided ) </option>
					</select>
				</div>
				
				<div class="col-md-6">
					<label>Size:</label>	
					<input type="text" name="corner_type[]" class="form-control">
				</div>
				
				<div class="col-md-6">
					<label>Corner:</label>	
					<select class="form-control" name="corner[]">
  					<option value="">Select Corner</option>
						<option>Round</option>
						<option>Rectangle</option>
						<option>Other</option>
					</select>
				</div>
				<div class="col-md-12">
					<label>Design:</label>	
  					<select class="form-control" name="design[]">
	  					<option value="">Select Design</option>
  						<option value="All Same Design">Same</option>
  						<option value="Variable Design">Variable</option>
  					</select>
				</div>
				<div class="col-md-12">
					<label>Details:</label>	
					<input type="text" name="wdetails" class="wdetails form-control">
				</div>
				<div class="col-md-6">
					<label>Qty:</label>	
					<input type="text" name="p_qty[]" class="form-control">
				</div>
				<div class="col-md-6">
					<label>Rate:</label>	
					<input type="text" name="p_rate[]" class="form-control">
				</div>
				
				
				<div class="col-md-8">
					<span class="wdetails_info"></span>
				</div>
			</div>
			<div class="col-md-2">
				<a href="javascript:void(0);" class="btn btn-warning removeEStiker" id="copyESticker">-</a>
			</div><div class="col-md-12"><hr /></div></div>`;

			$("#pdetailsContainer").append(newHtml);
		})
	}

	function selectWheeler(sel)
	{
		var closeEle = $(sel).closest('.col-md-10').find('.wdetails');
		if(sel.value.toString() == "2")
		{
			closeEle.val('Heavy Coated Matt - Water proof material'.toUpperCase());
		}
		else if(sel.value.toString() == "6")
		{
			closeEle.val('Water proof material - Both side printed'.toUpperCase());
		}
		else
		{
			closeEle.val('Water proof material - Reverse side printed'.toUpperCase());
		}
	}
    $(document).ready(function() {

    	$(document).on('click', '.removeEStiker', function(e) {
    		$(e.target).closest('.extraAdded').remove();
    	});

      $('.fancybox').fancybox({
        'width':900,
        'height':600,
        'autoSize' : false,
    });

    bindSendJobReview();
    bindAddJobReview();
    bindCopyPSticker();
    


	$('.datepicker').datetimepicker({
		dayOfWeekStart : 1,
		lang:'en',
		disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
		step:10
	});  
	
	  var options_sms_customer = $('select.estimate-customer-select option');
     var arr = options_sms_customer.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options_sms_customer.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });  
     
    /*$('.datepicker').datepicker({
      viewMode: 'years'
    }); */
  
    
});

function send_address()
{
	var customer_id,sms_message,sms_mobile;
	customer_id = $("#address_customer").val();
	sms_message = $("#address_sms_message").val();
	sms_mobile = $("#address_sms_mobile").val();
	sms_customer_name = $("#address_sms_customer_name").val();
	customer_email = $("#address_customer_email").val();
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/send_address/", 
         data:{'customer_id':customer_id,'customer_email':customer_email,"sms_message":sms_message,"sms_mobile":sms_mobile,"sms_customer_name":sms_customer_name},
         success: 
            function(data){
				//console.log(data);
				alert("SMS Sent :"+data);
				$.fancybox.close();
            }
          });
}

function send_feedback()
{
	var customer_id,sms_message,sms_mobile;
	sms_message = $("#feedback_sms_message").val();
	sms_mobile = $("#feedback_sms_mobile").val();
	
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/send_feedback/", 
         data:{
         	"sms_message":sms_message,
         	"sms_mobile":sms_mobile,
         },
         success: 
            function(data){
				//console.log(data);
				alert("SMS Sent :"+data);
				$.fancybox.close();
            }
          });
}

function create_estimation(){
	var customer_id,sms_message,sms_mobile;
	customer_id = $("#customer").val();
	sms_message = $("#sms_message").val();
	sms_mobile = $("#sms_mobile").val();
	sms_customer_name = $("#sms_customer_name").val();
	customer_email = $("#customer_email").val();
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/create_estimation/", 
         data:{'customer_id':customer_id,'customer_email':customer_email,"sms_message":sms_message,"sms_mobile":sms_mobile,"sms_customer_name":sms_customer_name},
         success: 
            function(data){
				//console.log(data);
				alert("SMS Sent :"+data);
				$.fancybox.close();
            }
          });
}
function create_estimation_new(){
	var customer_id,sms_message,sms_mobile;
	sms_message = $("#n_sms_message").val();
	sms_email = $("#n_customer_email").val();
	sms_mobile = $("#n_sms_mobile").val();
	sms_customer_name = $("#n_sms_customer_name").val();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/create_estimation/", 
         data:{"customer_email":sms_email,'customer_id':0,"sms_message":sms_message,"sms_mobile":sms_mobile,"sms_customer_name":sms_customer_name,'prospect':'1'},
         success: 
            function(data){
				alert("SMS Sent : "+data);
				$.fancybox.close();
            }
          });
}
</script>

<script>
function header_calculate_paper_cost(){
	var paper_gram,paper_size,paper_print,ori_paper_qty,paper_qty,amount=0,total=0,id,mby=1;
	
	
	var est_cutting_charge = jQuery("#est_cutting_charge").val();
	var est_binding_charge = jQuery("#est_binding_charge").val();
	var est_other_charges = jQuery("#est_other_charges").val();
	var est_lamination_charge = jQuery("#est_lamination_charge").val();
	
	
	paper_gram = jQuery("#hpaper_gram").val();
	paper_size = jQuery("#hpaper_size").val();
	paper_print = jQuery("#hpaper_print").val();
	id = jQuery("#hfancybox_id").val();
	paper_qty = jQuery("#hpaper_qty").val();
	ori_paper_qty = jQuery("h#paper_qty").val();
	if(paper_print == "FB") {
		paper_qty = paper_qty *2;
	}
	/*if(paper_print == "FB") {
		paper_qty = paper_qty *2;
	}*/
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_paper_rate/", 
         data:{"paper_gram":paper_gram,"paper_size":paper_size,
                "paper_print":paper_print,"paper_qty":paper_qty},
         dataType:"json",
         success: 
              function(data){
                if(data.success != false ) {

                  amount = amount + parseFloat(data.paper_amount);
					if(paper_print == "FB" ) {
						if(paper_size == "13X19" || paper_size == "13x19" ) {
							amount = amount * 2 - 2;
						}
					}
                  var otherTotal = parseInt(est_cutting_charge) + parseInt(est_binding_charge) + parseInt(est_other_charges) + parseInt(est_lamination_charge);
                  total = ((amount * paper_qty )* mby ) ;
                  
                  var masterTotal = parseInt(otherTotal) + parseInt(total);
                  jQuery("#hresult_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total + "<br> Including other Charges Total : <strong>"+ masterTotal+ "</strong>");
                  
            } else {
                  jQuery("#hresult_paper_cost").html("[ Data not Found - Insert Manual Price]");
            }
        }
          });
}

function show_sms_mobile_address()
{
		var customer_id = jQuery("#address_customer").val();
	if(customer_id == 0 ) {
		jQuery("#address_sms_mobile").val('');
		return true;
	}
    $.ajax({
     type: "POST",
     dataType:"json",
     url: "<?php echo site_url();?>/ajax/ajax_get_customer/"+customer_id, 
     success: 
        function(data){
			jQuery("#address_customer_email").val(data['emailid']);

			jQuery("#address_sms_mobile").val(data['mobile']);
			if(jQuery("#address_sms_customer_name").val(data['name']).length > 0 ) {
					jQuery("#address_sms_customer_name").val(data['name']);
			} else {
					jQuery("#address_sms_customer_name").val(data['companyname']);
			}
		}
  });

}

function show_sms_mobile() {
	var customer_id = jQuery("#customer").val();
	if(customer_id == 0 ) {
		jQuery("#sms_mobile").val('');
		return true;
	}
    $.ajax({
     type: "POST",
     dataType:"json",
     url: "<?php echo site_url();?>/ajax/ajax_get_customer/"+customer_id, 
     success: 
        function(data){
			jQuery("#customer_email").val(data['emailid']);
			jQuery("#sms_mobile").val(data['mobile']);
			if(jQuery("#sms_customer_name").val(data['name']).length > 0 ) {
					jQuery("#sms_customer_name").val(data['name']);
			} else {
					jQuery("#sms_customer_name").val(data['companyname']);
			}
		}
  });
}
</script>


<div id="hfancy_box_demo" style="width:800px;display: none;">
		<ul class="tabs" data-persist="true">
            <li><a href="#h-paperTab">Paper</a></li>
            <li><a href="#h-visiCard">Visiting Cards</a></li>
            <li><a href="#h-executieCard">Exclusive Visiting Cards</a></li>
            <li><a href="#h-black-white">Black & White Cards</a></li>
        </ul>
        <div class="tabcontents">
			<div id="h-paperTab">
				<?php   require_once('paper-estimation.php');?>
				
			</div>
			<div id="h-visiCard">
				<?php
					if( $this->router->fetch_class() != 'jobs' && ( $this->router->fetch_method() != 'edit' || $this->router->fetch_method() != 'edit_job'))
						require_once('layout-visiting-card.php');
				 ?>
			</div>
			<div id="h-executieCard">
				<?php
					if( $this->router->fetch_class() != 'jobs' && ( $this->router->fetch_method() != 'edit' || $this->router->fetch_method() != 'edit_job'))
						require_once('layout-excluive-visiting-card-rates.php');
				?>
			</div>
			<div id="h-black-white">
				<?php
					if( $this->router->fetch_class() != 'jobs' && ( $this->router->fetch_method() != 'edit' || $this->router->fetch_method() != 'edit_job'))
						require_once('layout-blak-white-card-rates.php');
				?>
			</div>
		</div>
</div>
</div>



<!-- Scheduler Block -->
<div id="schedule" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
	<table border="2" width="100%">
	<tr>
		<td align="right"> Assign To : </td>
		<td>
			<?php get_task_user_list();?>
		</td>
	</tr>
	<tr>
		<td align="right">
			Title :
		</td>
		<td>
			<input type="text" name="title"  id="sc_title"  class="form-control" required="required">
		</td>
	</tr>
	<tr>
		<td align="right">
			Description :
		</td>
		<td>
			<textarea name="description" id="sc_description"  class="form-control"></textarea>
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Reminder Time :
		</td>
		<td>
			<input type="text" name="reminder_time"  id="sc_reminder_time"   class="form-control datepicker" required="required">
		</td>
	</tr>
	<tr>
		<td align="right">
			Mobile Reminder : 
		</td>
		<td>
			<label><input type="checkbox" name="sc_mobile_reminder" id="sc_mobile_reminder">Send SMS</label>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<button onclick="set_schedule();" id="btn_schedule" class="btn btn-primary">Schedule</button>
			<span id="loading-image" style="display:none;">
				<img src="<?php echo base_url();?>/assets/img/load.gif">
			</span>
		</td>
	</tr>
</table>
</div>
</div>

<div id="notification_div"  style="width:800px;display: none;">
	
</div>
<script>
function set_schedule() {
	$('#loading-image').show();
	$("#btn_schedule").hide();
	var name = jQuery("#sc_title").val();
	var description = jQuery("#sc_description").val();
	var reminder_time = jQuery("#sc_reminder_time").val();
	var receiver = $('#receiver').val();
	var is_sms = 0;
	
	if($('#sc_mobile_reminder').prop("checked") == true){
		is_sms= 1;
	}
	
	 $.ajax({
     type: "POST",
     dataType:"json",
     url: "<?php echo site_url();?>/ajax/set_schedule/", 
     data : { 'is_sms':is_sms,'title':name,'description':description,'reminder_time':reminder_time,'receiver':receiver},
     success: 
        function(data){
			alert("Successfully Scheduler Set");
		},
	 complete: function(){
        $('#loading-image').hide();
        jQuery("#sc_title").val("");
		jQuery("#sc_description").val("");
		jQuery("#sc_reminder_time").val("");
		$('#receiver').val("");
        $.fancybox.close();
        $("#btn_schedule").show();
      }
  });
}


var contentLength  = 0;
var n_contentLength  = 0;
jQuery(document).ready(function() {
	
	jQuery("#sms_message").on('keyup', function()
	{
		contentLength = jQuery("#sms_message").val().length;
		if(contentLength > 140)
		{
			jQuery("#charCount").html('<span class="red">' +contentLength+ '</span>');
		}
		else
		{
			jQuery("#charCount").html('<span class="green">' +contentLength+ '</span>');	
		}
	});
	
	jQuery("#n_sms_message").on('keyup', function()
	{
		n_contentLength = jQuery("#n_sms_message").val().length;
		if(contentLength > 140)
		{
			jQuery("#n_charCount").html('<span class="red">' +n_contentLength+ '</span>');
		}
		else
		{
			jQuery("#n_charCount").html('<span class="green">' +n_contentLength+ '</span>');	
		}
	});


	jQuery(".date-picker").datepicker();
});

function bindAddJobReview()
    {
    	jQuery(".job-review").on('click', function(e) {
    		$("#reviewSms").modal('show');

    		$("#job_sms_customer_name").html($(e.target).attr('data-customer-name'));
    		$("#job_sms_title").html($(e.target).attr('data-job-name'));
    		$("#job_review_id").val($(e.target).attr('data-job-id'));
    		$("#job_review_mobile").val($(e.target).attr('data-customer-mobile'));
    		$("#job_review_customer_id").val($(e.target).attr('data-customer-id'));

    		$("#job_review_content").val("Dear "+ $(e.target).attr('data-customer-name') +", Kindly request you to please share your valuable feedback http://bit.ly/2z6bxpo Cybera");
    	});
    }
    	
    function bindSendJobReview()
    {
    	$("body").on('click', '#job_review_send_btn', function(e)
    	{
			$.ajax(
			{
		        type: "POST",
		        url: "<?php echo site_url();?>/jobs/send_review_sms", 
		        data: {
		        	content: $("#job_review_content").val(),
		        	mobile: $("#job_review_mobile").val(),
		        	jobId: $("#job_review_id").val(),
		        	customerId: $("#job_review_customer_id").val()
		        },
		        dataType: 'JSON',
		        success: function(data)
		        {
		        	$("#reviewSms").modal('hide');
				},
				complete: function(data)
				{
					$("#reviewSms").modal('hide');
				}
	        });
    	})
    }
</script>

<div id="reviewSms" class="modal fade" role="dialog">
	<div class="modal-dialog">

	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Google Review</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	Job Title: <span id="job_sms_title"></span>
        </div>

        <div class="form-group">
        	Customer: <span id="job_sms_customer_name"></span>
        </div>

        <div class="form-group">
        	<p>SMS Content</p>
        	<textarea class="form-control" id="job_review_content" name="job_review_content"></textarea>

        	<input type="hidden" name="job_review_mobile" id="job_review_mobile" />
        	<input type="hidden" name="job_review_id" id="job_review_id" />
        	<input type="hidden" name="job_review_customer_id" id="job_review_customer_id" />
		    
        </div>
      </div>
      <div class="modal-footer">
     	<button type="button" class="btn btn-info" id="job_review_send_btn">Send SMS</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="resMenuManager" class="modal fade " role="dialog" >
	<div class="modal-dialog modal-lg" style="width: 80%;">
	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Restaurant Menu</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-md-6">
      			<div class="form-group" >
		      		<label>Party Name:</label>
					<input type="text" name="resMenuClientName" id="resMenuClientName" class="form-control">
	      		</div>
		      	
		      	<div class="form-group" >
  		      		<label>Select Menu Code:</label>
  		      		<select style="height: 300px;" id="resMenuOptionsPopUp" multiple="multiple" class="form-control"></select>
  		      	</div>

  	  			<div class="form-group">
					<label>Job Notes:</label>
	  				<select class="form-control" style="height: 180px;" name="rEstimateNote[]" multiple="multiple" id="rEstimateNote">
	  					<option selected="selected" value="0">N/A</option>
	  					<option value="- Job Will be start after Approval of Estimate">Job Will be start after Approval of Estimate</option>
	  					<option value="- Job Will be start after receipt of the Payment">Job Will be start after receipt of the Payment</option>
	  					<option value="- Soft copy will be required in corel draw format">Soft copy will be required in corel draw format</option>
	  					<option value="- No Guarantee for Lamination in Digital Printed Jobs">No Guarantee for Lamination in Digital Printed Jobs</option>
	  					<option value="- Delivery from CYBERA C G Road office">Delivery from CYBERA C G Road office</option>
	  					<option value="- Delivery charges extra">Delivery charges extra</option>
	  					<option value="- Please confirm design before Adjusting Whole File ( Setting all data )">Please confirm design before Adjusting Whole File ( Setting all data )</option>
	  					<option value="- Please check sampl before placing final order">Please check sampl before placing final order</option>
	  					<option value="- Color variation can be seen in offset printed jobs">Color variation can be seen in offset printed jobs</option>
	  					<option value="- Delivery time depends on courier service provider's policy, cybera will not responsible for late deliveries.">Delivery time depends on courier service provider's policy, cybera will not responsible for late deliveries.
	  					</option>
	  					<option value="- Numbering Sequence separation will be done by customer only in variable data job">
						Numbering Sequence separation will be done by customer only in variable data job
						</option>
						<option value="- Please mention estimate number at the time of placing final order to avoid any type of discrepancies">
						Please mention estimate number at the time of placing final order to avoid any type of discrepancies
						</option>
						<option value="- Third party Delivery facility also available (Call to know more )">
						Third party Delivery facility also available (Call to know more )
						</option>
	  				</select>
				</div>
				
				<label>Copy Below Estimation:</label>
				<textarea style="height: 400px;" id="resMenuOptionsPopUpValWith" rows="6" class="form-control"></textarea>
      		</div>

      		<div class="col-md-6">

  		      	<div class="col-md-4">
  				  	<div class="form-group">
  						<label>Process:</label>
  		  				<select class="form-control" name="rProcess" id="rProcess">
  		  					<option selected="selected" value="0">N/A</option>
  		  					<option value="1">1</option>
  		  					<option value="2">2</option>
  		  					<option value="3">3</option>
  		  					<option value="4">4</option>
  		  					<option value="5">5</option>
  		  					<option value="6">6</option>
  		  					<option value="7">7</option>
  		  				</select>
  				  	</div>
  		      	</div>
  		      	<div class="col-md-4">	
  					  	<div class="form-group">
  		  					<label>Process Time:</label>
  			  				<select id="rProcessTime" name="rProcessTime" class="form-control">
  			  					<option value="0">N/A</option>
  			  					<option>Day/s</option>
  			  					<option>Hour/s</option>
  			  				</select>
  					  	</div>
  		      	</div>
  		      	<div class="col-md-4">	
  				  	<div class="form-group">
  	  					<label>Delivery Time:</label>
  	  		  			<select id="rDeliveryTime" name="rDeliveryTime" class="form-control">
  		  					<option value="0">N/A</option>
  		  					<option>Extra</option>
  		  				</select>
  				  	</div>
  		      	</div>
	  		      	<div class="col-md-6">
	  	  	  			<div class="form-group">
	  						<label>GST: <span id="rgstLabel"></span></label>
	  		  				<select onchange="estimateCalcRTotal()" id="rGst" name="rGst" class="form-control">
	  		  					<option selected value="0">N/A</option>
	  		  					<option value="Extra">Extra</option>
	  		  					<option value="5">5</option>
	  		  					<option value="10">10</option>
	  		  					<option value="12">12</option>
	  		  					<option value="15">15</option>
	  		  					<option value="18">18</option>
	  		  				</select>
	  	  	  			</div>
	  		      	</div>

	  		      	<div class="col-md-6">
	  		      		<div class="form-group">
	  					<label>Packing Forwading:</label>
	  	  				<input class="form-control" name="rTransportPfrwd" id="rTransportPfrwd" value="0">
	  	  				</div>
	  		      	</div>

  		      		<div class="col-md-6">
	  		      		<div class="form-group">
	  	  					<label>Transportation By:</label>
	  		  				<input class="form-control" name="rTransportBy" id="rTransportBy" value="0">
	  		  			</div>
	  		      	</div>

		  		      	<div class="col-md-6">
		  		      		<div class="form-group">
		  					<label>Transportation RS:</label>
		  	  				<input class="form-control" name="rTransportByRs" id="rTransportByRs" value="0">
		  	  				</div>
		  		      	</div>

		  		      	<div class="col-md-6">
		  					<div class="form-group">
		  						<label>Pay By:</label>
		  		  				<select class="form-control" name="rPayBy" id="rPayBy">
		  		  					<option value="0">N/A</option>
		  		  					<option>Cybera</option>
		  		  					<option>Party</option>
		  		  				</select>
		  	  				</div>
		  		      	</div>

		  		      	<div class="col-md-6 ">
		  	  				<div class="form-group">
		  						<label>Payment:</label>
		  		  				<select class="form-control" name="rPayment" id="rPayment">
		  		  					<option selected="selected" value="0">N/A</option>
		  		  					<option value="100% Advance">Advance</option>
		  		  				</select>
		  					</div>
		  		      	</div>

		      	<div class="col-md-12">
  	  			<div class="form-group">
					<label>Estimate Validity ( in Days ):</label>
	  				<input type="number" step="1" min="0" value="7" name="rEstimateValidity" id="rEstimateValidity" class="form-control">
				</div>
	      		<div class="form-group">
					<label>Extra Notes:</label>
	  				<textarea class="form-control" name="rEstimateExnotes" id="rEstimateExnotes"></textarea>
				</div>

  	  			

				<div class="form-group">
					<a href="javascript:void(0);" class="btn btn-primary" id="copy-r-data" onclick="showResMenuOptToVal()">Copy</a>
				</div>
		      	</div>

      			
      		</div>
      		

			<div class="col-md-6">

			</div>

			<div class="col-md-6" style="display: none;">
  	  			<label>Overview Estimation:</label>

				<textarea id="resMenuOptionsPopUpVal" rows="6" class="form-control"></textarea>
				<strong><span id="resMenuOptionsPopUpExtra"></span></strong>
			</div>
			
			
		</div>
		<br /><br />
      </div>
      <div class="modal-footer">
     	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="generalEstimate" class="modal fade modal-lg" role="dialog">
	<div class="modal-dialog modal-lg" style="width: 80%;">

	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">General Estimate</h4>
      </div>
      <div class="modal-body">
      	<div class="row">

      		<div class="col-md-12">
      			<div class="col-md-6">
      			</div>
      			<div class="col-md-6">
	      			<div class="col-md-2 mt-5">
	      				Search
	      			</div>
	      			<div class="col-md-6">
	      				<input type="text" name="search_box_fd" id="search_box_fd" class="form-control col-md-6" onkeyup="search_filter_fd();" >	
	      			</div>
	      			<div class="col-md-2">
	      				<span class="btn btn-primary" onclick="clear_filter_fd();">Clear</span>
	      			</div>
	      			<div class="col-md-2">
	      				<a href="#show_calculator" class="btn btn-sm btn-primary" onclick="show_calculator();">
							Calculator
						</a>
					</div>
				</div>

      			<div class="col-md-12" id="showFResults" style="display: none;">
      				<div style="display: none;" id="show_result_fd"></div>
      			</div>
      		</div>
			<div class="col-md-12">
				<hr />	
				<div class="col-md-12">

				<div class="col-md-6">
					<div class="form-group">
						<label>Customer:</label>
		  				<input type="text" name="cname" id="cname" class="form-control">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Title:</label>
		  				<input type="text" name="ctitle" id="ctitle" class="form-control">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="row col-md-12">
							<div class="col-md-6">
								<label>Details:</label>
							</div>
							<div class="col-md-3">
								<a href="javascript:void(0);" onclick="showMrgTmp()" class="text"> MRG</a>
							</div>
							<div class="col-md-3">
								<a href="javascript:void(0);" onclick="showRSTKTmp()" class="text">R STK</a>
							</div>
						</div>
						
						<div class="row col-md-12">

						<div class="row d-none" id="mrg_container">
							<div class="col-md-4">
							Sheet: <input type="text" name="sheet_qty" class="form-control w75" id="sheet_qty">
							</div>
							<div class="col-md-4">
							Rate: <input type="text" name="sheet_rate" class="form-control w75" id="sheet_rate">
							</div>
							<div class="col-md-4">
								<a onclick="setMrgTemplate();" href="javascript:void(0);" class="btn btn-info" style="margin-top: 12.5px;">
									Done
								</a>
								<a onclick="setMrgTemplate(1);" href="javascript:void(0);" class="btn btn-info" style="margin-top: 12.5px;">
									Clear
								</a>
							</div>
						</div>

						<div class="row d-none" id="rstk_container">
							
							<div class="col-md-4">
								<div class="col-md-12">
									Size:
								</div>
								<div class="col-md-6">
									<input type="text" class="form-control" name="rstk_size_val" id="rstk_size_val"> 
								</div>
								
								<div class="col-md-6">
									<select name="rstk_size_type" class="form-control" id="rstk_size_type">
										<option>INCH</option>
										<option>MM</option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								Shape: 
								<select name="rstk_shape" class="form-control" id="rstk_shape">
									<option>ROUND</option>
									<option>OTHER</option>
								</select>
							</div>

							<div class="col-md-2">
								Qty: <input type="text" name="rstk_qty" class="form-control w75" id="rstk_qty">
							</div>

							<div class="col-md-2">
								Rate: <input type="text" name="rstk_rate" class="form-control w75" id="rstk_rate">
							</div>

							<div class="col-md-1">
								<a onclick="setRSTKTemplate();" href="javascript:void(0);">
									<i class="fa fa-2x fa-check"></i>
								</a>
							</div>
							<div class="col-md-1">
								<a onclick="setRSTKTemplate(1);" href="javascript:void(0);">
									<i class="fa fa-2x fa-copy"></i>
								</a>
							</div>
							<br />
						</div>

						</div>

						<br />
						<textarea style="margin-	70px;" id="cnotes" rows="6" name="cnotes" class="form-control"></textarea>
					</div>

					<div class="col-md-9">
						<div class="form-group">
							<label>Bifurcation:</label>
			  				<input type="text" id="cnotes_b" name="cnotes_b" class="form-control" />
			  			</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Show:</label>
							<select class="form-control" id="cnotes_b_show" name="cnotes_b_show">
								<option>Yes</option>
								<option>No</option>
							</select>
			  			</div>
					</div>

				</div>

				<div class="col-md-6">
					<div class="row form-group">
						<div class="col-md-4">
							<label>Process:</label>
			  				<select class="form-control" name="cjprocess" id="cjprocess">
			  					<option selected="selected" value="0">N/A</option>
			  					<option value="1">1</option>
			  					<option value="2">2</option>
			  					<option value="3">3</option>
			  					<option value="4">4</option>
			  					<option value="5">5</option>
			  					<option value="6">6</option>
			  					<option value="7">7</option>
			  				</select>
						</div>
						<div class="col-md-4">
						<label>Process Time:</label>
			  				<select id="cjprocessType" name="cjprocessType" class="form-control">
			  					<option value="0">N/A</option>
			  					<option>Day/s</option>
			  					<option>Hour/s</option>
			  				</select>
						</div>
						<div class="col-md-4">
						<label>Delivery Time:</label>
			  				<select id="cjprocessTime" name="cjprocessTime" class="form-control">
			  					<option value="0">N/A</option>
			  					<option>Extra</option>
			  				</select>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<label>Sub Total:</label>
	  				<input class="form-control" name="cjSubTotalAmt" id="cjSubTotalAmt" value="0">
  				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Packing Forwading:</label>
		  				<input class="form-control" name="cjpacking" id="cjpacking" value="0">
		  			</div>
		  		</div>

		  		<div class="row col-md-6">
		  			<div class="form-group">
		  				<div class="col-md-6">
							<label>Transportation By:</label>
			  				<input class="form-control" name="cjtby" id="cjtby" value="0">
			  			</div>
			  			<div class="col-md-2">
							<label>RS:</label>
			  				<input class="form-control" name="cjtbyRs" id="cjtbyRs" value="0">
			  			</div>

			  			<div class="col-md-3">
				  			<label>Pay By:</label>
			  				<select class="form-control" name="cjtPayby" id="cjtPayby">
			  					<option value="0">N/A</option>
			  					<option>Cybera</option>
			  					<option>Party</option>
			  				</select>
			  			</div>
		  				
		  			</div>
		  		</div>


		  		<div class="row col-md-6 mt-20">
		  			<div class="form-group">
		  				<div class="col-md-4">
						<label>GST: <span id="gstLabel"></span></label>
		  				<select onchange="estimateCalcTotal()" id="cjgst" name="cjgst" class="form-control">
		  					<option selected value="0">N/A</option>
		  					<option value="Extra">Extra</option>
		  					<option value="5">5</option>
		  					<option value="10">10</option>
		  					<option value="12">12</option>
		  					<option value="15">15</option>
		  					<option value="18">18</option>
		  				</select>
		  				</div>
		  				<input type="hidden" name="cjgstHide" id="cjgstHide">
		  				

		  				<div class="col-md-4">
							<label>Total Amount:</label>
			  				<input class="form-control" name="cjTotalAmt" id="cjTotalAmt" value="0">
		  				</div>

		  				<div class="col-md-4">
				  			<div class="form-group">
								<label>Payment:</label>
				  				<select class="form-control" name="cpayment" id="cpayment">
				  					<option selected="selected" value="0">N/A</option>
				  					<option value="100% Advance">Advance</option>
				  				</select>
							</div>
						</div>
		  			</div>
		  		</div>

		  		<div class="col-md-6">
					<div class="form-group">
						<label>Job Notes:</label>
		  				<select class="form-control" style="height: 180px;" name="cjnotes[]" multiple="multiple" id="cjnotes">
		  					<option selected="selected" value="0">N/A</option>
		  					<option value="- Job Will be start after Approval of Estimate">Job Will be start after Approval of Estimate</option>
		  					<option value="- Job Will be start after receipt of the Payment">Job Will be start after receipt of the Payment</option>
		  					<option value="- Soft copy will be required in corel draw format">Soft copy will be required in corel draw format</option>
		  					<option value="- No Guarantee for Lamination in Digital Printed Jobs">No Guarantee for Lamination in Digital Printed Jobs</option>
		  					<option value="- Delivery from CYBERA C G Road office">Delivery from CYBERA C G Road office</option>
		  					<option value="- Delivery charges extra">Delivery charges extra</option>
		  					<option value="- Please confirm design before Adjusting Whole File ( Setting all data )">Please confirm design before Adjusting Whole File ( Setting all data )</option>
		  					<option value="- Please check sampl before placing final order">Please check sampl before placing final order</option>
		  					<option value="- Color variation can be seen in offset printed jobs">Color variation can be seen in offset printed jobs</option>
		  					<option value="- Delivery time depends on courier service provider's policy, cybera will not responsible for late deliveries.">Delivery time depends on courier service provider's policy, cybera will not responsible for late deliveries.
		  					</option>
		  					<option value="- Numbering Sequence separation will be done by customer only in variable data job">
		  						Numbering Sequence separation will be done by customer only in variable data job
		  					</option>
		  					<option value="- Please mention estimate number at the time of placing final order to avoid any type of discrepancies">
							Please mention estimate number at the time of placing final order to avoid any type of discrepancies
							</option>
							<option value="- Third party Delivery facility also available (Call to know more )">
						Third party Delivery facility also available (Call to know more )
						</option>
		  				</select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Extra Notes:</label>
		  				<textarea class="form-control" name="cjexnotes" id="cjexnotes"></textarea>
					</div>
				</div>

				<div class="col-md-6">

					<div class="col-md-6">
						<div class="form-group">
							<label>Approx Delivery Time ( in Days ):</label>
			  				<input type="number" step="1" min="0" value="0" name="e_approx_delivery" id="e_approx_delivery" class="form-control">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Estimate Validity ( in Days ):</label>
			  				<input type="number" step="1" min="0" value="7" name="e_valid_till" id="e_valid_till" class="form-control">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>
								<input type="checkbox" name="e_p_g_pay" id="e_p_g_pay" value="1">
								Phone / Google Pay
							</label>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>
								<input type="checkbox" name="e_pay_tm" id="e_pay_tm" value="1">
								PAYTM (walet)
							</label>
						</div>
					</div>

				</div>

				<div class="col-md-6">
					<div class="form-group">
						<a style="margin-top: 5px;" href="javascript:void(0);" class="btn btn-lg btn-primary" id="copy-c-data" onclick="copyCNotesNow()">Copy</a>
					</div>
				</div>

				</div>
			</div>

			<div class="col-md-12 text-center">
				<textarea id="resEstimateData" rows="12" class="form-control"></textarea>
			</div>
		</div>
		<br /><br />
      </div>
      <div class="modal-footer">
     	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="parkingEstimate" class="modal fade modal-lg" role="dialog">
	<div class="modal-dialog modal-lg" style="width: 60%;">
	<div class="modal-content">
    	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sticker Estimate</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
			<div class="col-md-12">
				<div class="col-md-12">
				<div class="col-md-6">
					<div class="form-group">
						<label>Customer:</label>
		  				<input type="text" name="pcname" id="pcname" class="form-control">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Title:</label>
		  				<input type="text" name="pctitle" id="pctitle" class="form-control">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<!-- <textarea id="pcnotes" rows="6" name="pcnotes" class="form-control"></textarea> 
		  				-->
		  				<div class="row" id="pdetailsContainer">
		  					<div class="col-md-10">
			  					<div class="col-md-12">
			  						<label>Parking Sticker1:</label>	
				  				</div>
			  					<div class="col-md-12">
			  						<label>Select Wheeler:</label>	
				  					<select onchange="selectWheeler(this)" class="form-control" name="wheeler[]">
				  						<option value="">Select Wheeler</option>
				  						<option value="2">2 Wheeler</option>
				  						<option  value="4">4 Wheeler</option>
				  						<option  value="6">4 Wheeler ( 2 sided ) </option>
				  					</select>
			  					</div>

		  						<div class="col-md-6">
		  							<label>Size:</label>	
		  							<input type="text" name="corner_type[]" class="form-control">
		  						</div>
		  						
		  						<div class="col-md-6">
		  							<label>Shape:</label>	
				  					<select class="form-control" name="corner[]">
					  					<option value="">Select Corner</option>
				  						<option>Round</option>
				  						<option>Rectangle</option>
				  						<option>Other</option>
				  					</select>
				  				</div>

								<div class="col-md-12">
									<label>Design:</label>	
				  					<select class="form-control" name="design[]">
					  					<option value="">Select Design</option>
					  					<option value="All Same Design">Same</option>
  										<option value="Variable Design">Variable</option>
				  					</select>
								</div>

								<div class="col-md-12">
									<label>Details:</label>	
									<input type="text" name="wdetails" class="wdetails form-control">
								</div>

		  						<div class="col-md-6">
		  							<label>Qty:</label>	
		  							<input type="text" name="p_qty[]" class="form-control">
		  						</div>
		  						<div class="col-md-6">
		  							<label>Rate:</label>	
				  					<input type="text" name="p_rate[]" class="form-control">
				  				</div>
			  					
			  					

								
			  					
			  					<div class="col-md-8">
									<div class="wdetails_info"></div>
								</div>
			  				</div>
			  				<div class="col-md-2">
			  					<a href="javascript:void(0);" class="btn btn-primary" id="copyESticker">+</a>
			  				</div>

			  				<div class="col-md-12"><hr /></div>
		  				</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="row form-group">
						<div class="col-md-4">
							<label>Process:</label>
			  				<select class="form-control" name="pcjprocess" id="pcjprocess">
			  					<option selected="selected" value="0">N/A</option>
			  					<option value="1">1</option>
			  					<option value="2">2</option>
			  					<option value="3">3</option>
			  					<option value="4">4</option>
			  					<option value="5">5</option>
			  					<option value="6">6</option>
			  					<option value="7">7</option>
			  				</select>
						</div>
						<div class="col-md-4">
						<label>Process Time:</label>
			  				<select id="pcjprocessType" name="pcjprocessType" class="form-control">
			  					<option value="0">N/A</option>
			  					<option>Day/s</option>
			  					<option>Hour/s</option>
			  				</select>
						</div>
						<div class="col-md-4">
						<label>Delivery Time:</label>
			  				<select id="pcjprocessTime" name="pcjprocessTime" class="form-control">
			  					<option value="0">N/A</option>
			  					<option>Extra</option>
			  				</select>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<label>Sub Total:</label>
	  				<input class="form-control" name="pcjSubTotalAmt" id="pcjSubTotalAmt" value="0">
  				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Packing Forwading:</label>
		  				<input class="form-control" name="pcjpacking" id="pcjpacking" value="0">
		  			</div>
		  		</div>

		  		<div class="row col-md-6">
		  			<div class="form-group">
		  				<div class="col-md-6">
							<label>Transportation By:</label>
			  				<input class="form-control" name="pcjtby" id="pcjtby" value="0">
			  			</div>
			  			<div class="col-md-2">
							<label>RS:</label>
			  				<input class="form-control" name="pcjtbyRs" id="pcjtbyRs" value="0">
			  			</div>
		  				
			  			<div class="col-md-4">
							<label>Pay By:</label>
			  				<select class="form-control" name="pcjtPayby" id="pcjtPayby">
			  					<option value="0">N/A</option>
			  					<option>Cybera</option>
			  					<option>Party</option>
			  				</select>
			  			</div>
		  			</div>
		  		</div>

		  		<div class="col-md-6">
		  			<div class="row form-group">
		  				<div class="col-md-4">
						<label>GST: <span id="pgstLabel"></span></label>
		  				<select onchange="estimateCalcPTotal()" id="pcjgst" name="pcjgst" class="form-control">
		  					<option selected value="0">N/A</option>
		  					<option value="Extra">Extra</option>
		  					<option value="5">5</option>
		  					<option value="10">10</option>
		  					<option value="12">12</option>
		  					<option value="15">15</option>
		  					<option value="18">18</option>
		  				</select>
		  				</div>
		  				<input type="hidden" name="pcjgstHide" id="pcjgstHide" value="0">
		  				

		  				<div class="col-md-4">
							<label>Total Amount:</label>
			  				<input class="form-control" name="pcjTotalAmt" id="pcjTotalAmt" value="0">
		  				</div>
		  				<div class="col-md-4">
				  			<div class="form-group">
								<label>Payment:</label>
				  				<select class="form-control" name="pcpayment" id="pcpayment">
				  					<option selected="selected" value="0">N/A</option>
				  					<option value="100% Advance">Advance</option>
				  				</select>
							</div>
		  				</div>
		  			</div>
		  		</div>

		  		<div class="col-md-6">
					<div class="form-group">
						<label>Job Notes:</label>
		  				<select style="height: 200px;" class="form-control" multiple="multiple" name="pcjnotes[]" id="pcjnotes">
		  					<option selected="selected" value="0">N/A</option>
		  					<option value="- Job Will be start after Approval of Estimate">Job Will be start after Approval of Estimate</option>
		  					<option value="- Job Will be start after receipt of the Payment">Job Will be start after receipt of the Payment</option>
		  					<option value="- Soft copy will be required in corel draw format">Soft copy will be required in corel draw format</option>
		  					<option value="- No Guarantee for Lamination in Digital Printed Jobs">No Guarantee for Lamination in Digital Printed Jobs</option>
		  					<option value="- Delivery from CYBERA C G Road office">Delivery from CYBERA C G Road office</option>
		  					<option value="- Delivery charges extra">Delivery charges extra</option>
		  					<option value="- Please confirm design before Adjusting Whole File ( Setting all data )">Please confirm design before Adjusting Whole File ( Setting all data )</option>
		  					<option value="- Do Not Paste the Stickers without washing/cleaning the vehicle for long life of the Stickers">Do Not Paste the Stickers without washing/cleaning the vehicle for long life of the Stickers</option>
		  					<option value="- Please check sampl before placing final order">Please check sampl before placing final order</option>
		  					<option value="- Color variation can be seen in offset printed jobs">Color variation can be seen in offset printed jobs</option>
		  					<option value="- Delivery time depends on courier service provider's policy, cybera will not responsible for late deliveries.">Delivery time depends on courier service provider's policy, cybera will not responsible for late deliveries.
		  					</option>
		  					<option value="- Numbering Sequence separation will be done by customer only in variable data job">
							Numbering Sequence separation will be done by customer only in variable data job
							</option>
							<option value="- Please mention estimate number at the time of placing final order to avoid any type of discrepancies">
							Please mention estimate number at the time of placing final order to avoid any type of discrepancies
							</option>
							<option value="- Third party Delivery facility also available (Call to know more )">
						Third party Delivery facility also available (Call to know more )
						</option>
		  				</select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Extra Notes:</label>
		  				<textarea class="form-control" name="pcjexnotes" id="pcjexnotes"></textarea>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Estimate Validity ( in Days ):</label>
		  				<input type="number" step="1" min="0" value="7" name="pe_valid_till" id="pe_valid_till" class="form-control">
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<a href="javascript:void(0);" class="btn btn-primary" id="copy-p-data" onclick="copySNotesNow()">Copy</a>
					</div>
				</div>

				</div>
			</div>

			<div class="col-md-12 text-center">
				<textarea id="presEstimateData" rows="12" class="form-control"></textarea>
			</div>
		</div>
		<br /><br />
      </div>
      <div class="modal-footer">
     	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	
function search_filter_fd() 
	{
		$("#show_result_fd").show();
	var search = $("#search_box_fd").val();
	var sort_by = "id";
	if(search.length > 3 ) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax_d/", 
			data : { 'search_box' : search, 'limit' :10, 'offset':0,"sort_by":sort_by},
			success: 
            function(data)
            {
            	$("#showFResults").toggle();
            	jQuery("#show_result_fd").html(data);
            }
		});
	}
}

function clear_filter_fd() {
	$("#search_box_fd").val("");
	jQuery("#show_result_fd").hide();
	$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/account/quick_ajax_clear/", 
			success: 
            function(data)
            {
            	$("#showFResults").toggle();
            	jQuery("#show_result_fd").html(data);
            }
		});
}

function showMrgTmp()
{
	$("#rstk_container").hide();
	$("#mrg_container").toggle();
}

function showRSTKTmp()
{
	$("#mrg_container").hide();
	$("#rstk_container").toggle();
}

function setMrgTemplate(isReset = 0)
{
	$("#rstk_container").hide();

	if(isReset == 1)
	{
		$("#cnotes").val('');
		$("#sheet_qty").val('');
		$("#sheet_rate").val('');
		showMrgTmp();
		return;
	}
	var qty = $("#sheet_qty").val(),
		rate = $("#sheet_rate").val();

	var nVal = '12X18 - MIRROR COAT REGULAR GUMMING PAPER STICKER - '+ qty +' SHEETS @ RS. '+ parseFloat(rate).toFixed(2);
	var xVal = $("#cnotes").val();
	var fVal = '';

	if(xVal.length > 2)
	{
		fVal = xVal + '\n' + nVal;
	}
	else
	{
		fVal = nVal;	
	}

	$("#cnotes").val(fVal);

	showMrgTmp();
}

function setRSTKTemplate(isReset = 0)
{
	$("#mrg_container").hide();
	if(isReset == 1)
	{
		$("#cnotes").val('');
		$("#rstk_size_val").val('');
		$("#rstk_qty").val('');
		$("#rstk_rate").val('');

		showRSTKTmp();
		return;
	}
	
	var stk_size = $("#rstk_size_val").val(),
		stk_type = $("#rstk_size_type").val(),
		stk_shape = $("#rstk_shape").val(),
		stk_qty = $("#rstk_qty").val(),
		stk_rate = $("#rstk_rate").val();


	var nVal =stk_size +' '+ stk_type +' '+ stk_shape +' SHAPE - MIRROR COAT HEAVY GUMMING PAPER STICKER - DIE CUTTING - '+ stk_qty +' PCS @ RS. '+ parseFloat(stk_rate).toFixed(2);
	var xVal = $("#cnotes").val();
	var fVal = '';

	if(xVal.length > 2)
	{
		fVal = xVal + '\n' + nVal;
	}
	else
	{
		fVal = nVal;	
	}


	$("#cnotes").val(fVal);

	showRSTKTmp();
}
</script>