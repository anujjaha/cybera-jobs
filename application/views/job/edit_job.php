<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/job_details.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />
<script>
    $(document).ready(function() {
      $('.fancybox').fancybox({
		'width':1000,
        'height':600,
        'autoSize' : false,
        'afterClose':function () {
			fancy_box_closed();
		},
    });
});

function customer_selected(type,userid) {
	jQuery("#customer_id").val(userid);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userid, 
         success: 
              function(data){
				 
				jQuery("#mobile_"+type).val('');
				jQuery("#mobile_"+type).val(data);
				jQuery("#showEmailId").html("Email Id : " + data.email);

				if(data.under_revision == 1)
        	{
        		alert("Please Collect Payment in Advance for the Job.");

        		jQuery("#showEmailId").append("<br> <span class='red'>"+ data.message +"</span><br><span class='red>'"+  + "'</span>");
        	}
			 }
          });
}
function customer_selected_set() {
	var userid = jQuery("#customer_id").val();
	$.ajax({
         type: "POST",
         dataType: 'JSON',
         url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userid, 
         success: 
              function(data){
              	
              	jQuery("#mobile_customer").val(data.mobile);
	        	jQuery("#showEmailId").html("Email Id : " + data.email);

	        	if(data.under_revision == 1)
        	{
        		alert("Please Collect Payment in Advance for the Job.");
        		jQuery("#showEmailId").append("<br> <span class='red'>Collect Payment in Advance<br>"+ data.message +"</span>");
        	}
			 }
          });
}
function auto_suggest_price(id){
	jQuery("#fancybox_id").val(id);
}
function set_cutting_details(id,cutting_id,job_id){
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_update_cutting_details/"+cutting_id+"/"+job_id+"/"+id, 
         success: 
            function(data){
                jQuery("#fancy_box_cutting").html(data);
                resetCuttingCallBack();
            }
          });
}

function resetCuttingCallBack()
{
	if($('.corner_cutting_no').prop('checked') == true)
	{
	    jQuery(".corner-cut-details").hide();
	}
	else
	{
	    jQuery(".corner-cut-details").show();
	}
	
	$('.corner_cutting_yes').on('change', function(event)
	{
	    if(event.target.checked == true)
	    {
	        jQuery(".corner-cut-details").show();
	    }
	    else
	    {
	        jQuery(".corner-cut-details").hide();   
	    }
	});

	$('.corner_cutting_no').on('change', function(event)
	{
	    if(event.target.checked == true)
	    {
	        jQuery(".corner-cut-details").hide();   
	    }
	    else
	    {
	        jQuery(".corner-cut-details").show();
	    }
	});
}

function set_fbox_data(data) {
	$("#machine").val(data['c_machine']);
	$("#size").val(data['c_size']);
	$("#size_info").val(data['c_sizeinfo']);
	$("#printing").val(data['c_print']);
	$("#lamination").val(data['c_lamination']);
	$("#lamination_info").val(data['c_laminationinfo']);
	$("#binding").val(data['c_binding']);
	$("#binding_info").val(data['c_bindinginfo']);
	$("#c_blade_per_sheet").val(data['c_blade_per_sheet']);
	$("#packing").val(data['c_packing']);
	$("#checking").val(data['c_checking']);
	$("#details").val(data['c_details']);
}

function set_cutting_details_box(id){
	var data_id =jQuery("#fancybox_cutting_id").val();
	var machine,size,details,lamination,printing,packing,lamination_info,binding,checking, c_blade_per_sheet;
        machine = $('input:radio[name=machine]:checked').val();// jQuery("#machine").val();
        
      binding = ""; 
      var $boxes = $('input[name=binding]:checked');
      $boxes.each(function(){
		  if($(this).val().length > 0 ) {
			binding = $(this).val() + ","+binding;  
		  }
		});
        
        lamination_info = jQuery("#lamination_info").val();
        size_info = jQuery("#size_info").val();
        binding_info = jQuery("#binding_info").val();
        c_blade_per_sheet = jQuery("#c_blade_per_sheet").val();
        details = jQuery("#details").val();
        lamination = $('input:radio[name=lamination]:checked').val();//jQuery("#lamination").val();
        checking = $('input:radio[name=checking]:checked').val();//jQuery("#lamination").val();
        size = $('input:radio[name=size]:checked').val();//jQuery("#lamination").val();
        printing =  $('input:radio[name=printing]:checked').val();// jQuery("#printing").val();
        packing =  $('input:radio[name=packing]:checked').val(); //printing jQuery("#packing").val();
        cCorner =  $('input:radio[name=c_corner]:checked').val(); //printing jQuery("#c_corner").val();

        jQuery("#c_machine_"+data_id).val(machine);
        jQuery("#c_qty_"+data_id).val(jQuery("#qty_"+data_id).val());
        jQuery("#c_material_"+data_id).val(jQuery("#details_"+data_id).val());
        jQuery("#c_size_"+data_id).val(size);
        jQuery("#c_details_"+data_id).val(details);
        jQuery("#c_lamination_"+data_id).val(lamination);
        jQuery("#c_print_"+data_id).val(printing);
        jQuery("#c_packing_"+data_id).val(packing);
        jQuery("#c_laminationinfo_"+data_id).val(lamination_info);
        jQuery("#c_sizeinfo_"+data_id).val(size_info);
        jQuery("#c_blade_per_sheet_"+data_id).val(c_blade_per_sheet);
        jQuery("#c_bindinginfo_"+data_id).val(binding_info);
        jQuery("#c_binding_"+data_id).val(binding);
        jQuery("#c_checking_"+data_id).val(checking);

        jQuery("#c_corner_"+data_id).val(cCorner);
        jQuery("#c_cornerdie_"+data_id).val($("#c_cornerdie").val());
        $.fancybox.close();
}
function remove_cutting_details(data_id) {
    jQuery("#cut_icon_"+data_id).css('display','none');
     jQuery("#c_machine_"+data_id).val('');
        jQuery("#c_qty_"+data_id).val('');
        jQuery("#c_material_"+data_id).val('');
        jQuery("#c_size_"+data_id).val('');
        jQuery("#c_details_"+data_id).val('');
        jQuery("#c_lamination_"+data_id).val('');
        jQuery("#c_print_"+data_id).val('');
        jQuery("#c_packing_"+data_id).val('');
    }
function fancy_box_closed(id){
	//alert(jQuery("#fancybox_id").val());
}

function calculate_paper_cost(){
	var paper_gram,paper_size,paper_print,ori_paper_qty,paper_qty,amount=0,total=0,id,mby=1;
	paper_gram = jQuery("#paper_gram").val();
	paper_size = jQuery("#paper_size").val();
	paper_print = jQuery("#paper_print").val();
	id = jQuery("#fancybox_id").val();
	paper_qty = jQuery("#paper_qty").val();
	ori_paper_qty = jQuery("#paper_qty").val();
	if(paper_print == "FB") {
		paper_qty = paper_qty *2;
	}
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_paper_rate/", 
         data:{"paper_gram":paper_gram,"paper_size":paper_size,
                "paper_print":paper_print,"paper_qty":paper_qty,
                'check_customer_id': jQuery("#customer_id").val()
            	},
         dataType:"json",
         success: 
              function(data){
                if(data.success != false ) {

                  amount = amount + parseFloat(data.paper_amount);
                  if(paper_print == "FB" ) {
						if(paper_size == "13X19" || paper_size == "13x19" ) {
							//amount = amount * 2 - 3;
							amount = amount * 2 - 3;
							paper_qty = paper_qty / 2;
						}
					}
					
                  total = (amount * paper_qty )* mby;
                  jQuery("#result_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
                  jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                  if(paper_print == "FB") {
                          jQuery("#rate_"+id).val(amount * 2);
                    if(paper_size == "13X19" || paper_size == "13x19" ) {
						  jQuery("#rate_"+id).val(amount );
					}
                  } else {
					  jQuery("#rate_"+id).val(amount);
				  }
                  
                  jQuery("#qty_"+id).val(ori_paper_qty);
                  jQuery("#sub_"+id).val(total);
                  $('#flag_'+id).prop('checked', true);
            } else {
                   jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                  jQuery("#result_paper_cost").html("[ Data not Found - Insert Manual Price]");
            }
        }
          });
}
function check_form() {
	
	if(jQuery("#confirmation").val().length > 0 ) {
		return true;
	}
	if(jQuery("#subtotal").val().length < 1 ) {
		jQuery("#subtotal").focus();
	} else {
		jQuery("#confirmation").focus();
	}
	
	return false;
}
function check_visiting_card(sr) {
		if($("#category_"+sr).val() == "Cutting") {
			$("#details_"+sr).val("Cutting");
		}
		
		if($("#category_"+sr).val() == "Laser Cutting") {
			$("#details_"+sr).val("Laser Cutting");
		}
		
		if($("#category_"+sr).val() == "Sticker Sheet") {
			$("#details_"+sr).val("Sticker Sheet");
		}
		if($("#category_"+sr).val() == "Flex") {
			$("#details_"+sr).val("Flex");
		}
		
		if($("#category_"+sr).val() == "Digital Print") {
			$("#details_"+sr).val("");
		}
		if($("#category_"+sr).val() == "Lamination") {
			$("#details_"+sr).val("Lamination");
		}
		if($("#category_"+sr).val() == "B/W Print") {
			$("#details_"+sr).val("B/W Print");
		}

		if($("#category_"+sr).val() == "Card Box") {
			$("#details_"+sr).val("Card Box");
			$("#qty_"+sr).val("1");
			$("#rate_"+sr).val("10");
			$("#sub_"+sr).val("10");
		}

		if($("#category_"+sr).val() == "Designing") {
			$("#details_"+sr).val("Designing");
		}
		if($("#category_"+sr).val() == "Editing Charge") {
			$("#details_"+sr).val("Editing Charge");
		}
		if($("#category_"+sr).val() == "Binding") {
			$("#details_"+sr).val("Binding");
		}
		if($("#category_"+sr).val() == "Packaging and Forwarding" || $("#category_"+sr).val() == "Packaging and Forwading" ) {
			$("#details_"+sr).val("Packaging and Forwarding");
		}
		if($("#category_"+sr).val() == "Transportation") {
			$("#details_"+sr).val("Transportation");
		}
		
		if($("#category_"+sr).val() == "ROUND CORNER CUTTING") {
			$("#details_"+sr).val("ROUND CORNER CUTTING");

			$("#rate_"+sr).val(".25");
			
		}
		
		if($("#category_"+sr).val() == "Offset Print") {
			$("#details_"+sr).val("Offset Print");
		}
		if($("#category_"+sr).val() == "Visiting Card") {
			$("#details_"+sr).val("Visiting Card");
		}

		if($("#category_"+sr).val() == "Visiting Card Flat") {
			$("#details_"+sr).val("Visiting Card Flat");
		}

		if($("#category_"+sr).val() == "Transparent Visiting Card") {
			$("#details_"+sr).val("Transparent Visiting Card");
		}

		if($("#category_"+sr).val() == "B/W Xerox") {
			$("#details_"+sr).val("B/W Xerox");
		}
		if($("#category_"+sr).val() == "Not Applicable") {
			$("#details_"+sr).val("Not Applicable");
			$("#qty_"+sr).val("0");
			$("#rate_"+sr).val("0");
			$("#sub_"+sr).val("0");
		}
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general');
$modified_by = $this->session->userdata['user_id'];
?>
<form action="<?php echo base_url();?>jobs/edit_job/<?php echo $job_data->id;?>" method="post" onsubmit="return check_form();">
<div class="col-md-12">

<div class="col-md-12 text-center">
<p id="balance"  align="right"><h2 class="red" id="show_balance" ></h2></p>
<p align="right"><h4 class="green" id="showEmailId" >Email Id : <?php echo $customer_details->emailid; ?></h4></p>
</div>

<table width="100%" border="2">
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%">
					<tr>
						<td width="50%">
							Customer Name : 
							<?php echo $customer_details->companyname ? $customer_details->companyname : $customer_details->name;?>
						</td>
						<td>
							<strong>Job Id : <?php echo $job_data->id;?></strong>
						</td>
					</tr>
					<tr>
						<td width="50%">
							Update Customer Name : 
							<select name="customer_id" id="customer_id" onchange="customer_selected_set();">
								<?php
									foreach($all_customers as $jcustomer) {
								?>
									<option
										<?php if($jcustomer['id'] ==  $job_data->customer_id) { echo 'selected="selected"';}?>
									 value="<?php echo $jcustomer['id'];?>">
										<?php echo $jcustomer['companyname'] ? $jcustomer['companyname'] : $jcustomer['name'];?>
									</option>
								<?php } ?>
							</select>
						</td>
						<td width="50%" align="right">
							<input type="hidden" name="original_customer_id" value="<?php echo $job_data->customer_id;?>">
							Contact Number : <input type="text" value="<?php echo $customer_details->mobile;?>" name="user_mobile" id="mobile_customer">
							<input type="text" name="jsmsnumber" id="jsmsnumber" value="<?php echo $job_data->jsmsnumber;?>">
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<table width="100%" border="2">
	<tr>
		<td colspan="7" align="center">
			Job Name : <input type="text" name="jobname" id="jobname" value="<?php echo $job_data->jobname;?>" style="width:250px;">
		</td>
	</tr>
	<tr>
		<td width="5%">Sr</td>
		
		<td width="10%">Category</td>
		<td width="50%">Details</td>
		<td width="10%">Qty.</td>
		<td width="5%">Calculate</td>
		<td width="10%">Rate</td>
		<td width="10%">Amount</td>
	</tr>
	<?php 
	$j=0;
	for($i=1;$i<6;$i++){ 
		?>
	<tr>
		<td><?php echo $i;?>
		<input type="hidden" name="jdid_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['id'])) { echo $job_details[$j]['id']; }?>" >
		</td>
		<td>
			<select name="category_<?php echo $i;?>" id="category_<?php echo $i;?>" onChange="check_visiting_card(<?php echo $i;?>);">
				<option
				 <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Digital Print' ) { echo 'selected="selected"';} ?>>Digital Print</option>
				<option
				 <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Visiting Card' ) { echo 'selected="selected"';} ?>>Visiting Card</option>
				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Visiting Card Flat'  ) { echo 'selected="selected"';} ?>>Visiting Card Flat</option>

				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Transparent Visiting Card'  ) { echo 'selected="selected"';} ?>>Transparent Visiting Card</option>


				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Offset Print' ) { echo 'selected="selected"';} ?>>Offset Print</option>

				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Card Box' ) { echo 'selected="selected"';} ?>>Card Box</option>
				
				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Flex' ) { echo 'selected="selected"';} ?>>Flex</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Cutting' ) { echo 'selected="selected"';} ?>>Cutting</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Designing' ) { echo 'selected="selected"';} ?>>Designing</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Editing Charge' ) { echo 'selected="selected"';} ?>>Editing Charge</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Binding' ) { echo 'selected="selected"';} ?>>Binding</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Sticker Sheet' ) { echo 'selected="selected"';} ?>>Sticker Sheet</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Packaging and Forwarding' ) { echo 'selected="selected"';} ?>>Packaging and Forwarding</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Transportation' ) { echo 'selected="selected"';} ?>>Transportation</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Lamination' ) { echo 'selected="selected"';} ?>>Lamination</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Laser Cutting' ) { echo 'selected="selected"';} ?>>Laser Cutting</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'ROUND CORNER CUTTING' ) { echo 'selected="selected"';} ?>>ROUND CORNER CUTTING</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'B/W Print' ) { echo 'selected="selected"';} ?>>B/W Print</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'B/W Xerox' ) {echo 'selected="selected"';} ?>>B/W Xerox</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Not Applicable' ) { echo 'selected="selected"';} ?>>Not Applicable</option>
				
				
			</select>
		</td>
		<td>
		<a class="fancybox fa fa-fw fa-question-circle" 
               onclick="return auto_suggest_price(<?php echo $i;?>);" href="#fancy_box_demo">
            </a>
         <input type="text" id="details_<?php echo $i;?>" name="details_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jdetails'])) { echo $job_details[$j]['jdetails']; }?>" style="width:70%;">
          
         </td>
		<td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jqty'])) { echo $job_details[$j]['jqty']; }?>" ></td>
		
		<td align="center"><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>"></td>
		
		<td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jrate'])) { echo $job_details[$j]['jrate']; }?>" ></td>
		<td align="right">
		<input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jamount'])) { echo $job_details[$j]['jamount']; }?>" onblur="check_total(<?php echo $i;?>)" style="width:100px;">
		
		<a class="fancybox fa fa-fw fa-cut" 
               onclick="return set_cutting_details(<?php echo $i;?>,<?php echo $job_details[$j]['id'] ? $job_details[$j]['id']:0;?>,<?php echo $job_data->id;?>);" href="#fancy_box_cutting"></a>
           <a class="fa fa-fw fa-minus-square" id="cut_icon_<?php echo $i;?>" style="display:none;"
                onclick="return remove_cutting_details(<?php echo $i;?>);" href="javascript:void(main);">
           </a>    
		</td>
	</tr>
	<?php $j++;} ?>
	<tr>
		<td rowspan="6" colspan="5">
        	<table>
        			<tr>
	        			<td>
	        				Notes : <textarea name="notes" cols="60" rows="5"><?php echo $job_data->notes;?></textarea>
	        			</td>
	        			<td>
	        				Extra Notes : <textarea name="extra_notes" style="background-color: pink;"  cols="60" rows="5"><?php echo $job_data->extra_notes;?></textarea>
	        			</td>
        			</tr>
        	</table>
        </td>

		<td align="right">
			Sub Total :
		</td>
		<td><input type="text" id="subtotal" name="subtotal"  onblur="calc_subtotal()" required="required"></td>
	</tr>
	<tr>
        <td>
        	Apply Tax : 
        </td>
        <td>
                <select class="form-control" id="gst_tax" name="gst_tax">
                	<option value="0">N/A</option>
                	<option value="5">5 %</option>
                	<option value="12">12 %</option>
                	<option value="18">18 %</option>
                </select>
                       <div style="display: none;">
                       	
           		<input type="checkbox" name="cb_checkbox" checked="checked" id="cb_checkbox">
                       </div>
        </td>
	</tr>
	<tr>
            <td align="right">
                    <strong>GST (Tax) :</strong>
                
            </td>
            <td>
            <input type="text" id="tax"  value="<?php if(!empty($job_data->tax)) { echo $job_data->tax; }?>" name="tax" onblur="calc_tax()" style="width: 80px;">
            </td>
	</tr>
	<!-- <tr style="display: none;">
		<td align="right">
			Tax :
		</td>
		<td>
		<input type="checkbox" name="cb_checkbox" id="cb_checkbox" <?php if(!empty($job_data->tax)) { echo 'checked="checked"'; }?>>
		<input type="text" id="tax" name="tax" onblur="calc_tax()"></td>
	</tr> -->
	<tr>
		<td align="right">
			Total :
		</td>
		<td><input type="text" id="total" value="<?php if(!empty($job_data->total)) { echo $job_data->total; }?>" name="total" onfocus="calc_total()"></td>
	</tr>
	<tr>
		<td align="right">
			Advance :
		</td>
		<td>
		<input type="text" id="advance1" value="<?php echo $job_data->advance ? $job_data->advance: 0;?>" name="advance1"  disabled="disabled">
		<input type="hidden" id="advance" value="<?php echo $job_data->advance ? $job_data->advance: 0;?>" name="advance" value="0">
		</td>
	</tr>
	<tr>
		<td align="right">
			Due :
		</td>
		<td><input type="text" id="due" value="<?php if(!empty($job_data->due)) { echo $job_data->due; }?>" name="due" onfocus="calc_due()"></td>
	</tr>
	<tr>
		<td colspan="6" align="right">
			Discount :
		</td>
		<td>
		<input type="text" id="discount" value="0" name="discount"></td>
	</tr>
</table>
    
    <hr>
<div class="col-md-12">
<div class="row">

	<div class="col-md-4">
		Job Creator : 
		<select name="emp_id" id="emp_id">
			<option selected="selected" value="0">
				Please Select Operator
			</option>
			<?php
				foreach(getAllEmployees() as $employee)
				{
			
			?>
				<option value="<?php echo $employee->id;?>">
					<?php echo $employee->name;?>
				</option>
			<?php
				}
			?>
			
		</select>
	</div>
	
	<div class="col-md-4">
		<input type="hidden" name="job_id" value="<?php echo $job_data->id;?>">
		<input type="hidden" name="modified" value="<?php echo $modified_by;?>">
		
		<input type="hidden" name="hasDiscount" value="1">
            Bill Number : <input type="text" name="bill_number" value="<?php if(!empty($job_data->bill_number)) { echo $job_data->bill_number;}?>">
	</div>
	<div class="col-md-4">
		Reciept Number : <input type="text" name="receipt"  value="<?php if(!empty($job_data->receipt)) { echo $job_data->receipt;}?>">
	</div>
</div>
<hr>
<div class="col-md-12">
<div class="form-group">
		
	</div>
</div>

		

<table align="center" style="border: 2px solid #000;" border="2">		
	<tr>
		<td>
			Reference Customer : 
			<select  style="width: 250px;" name="reference_customer_id" id="reference_customer_id">
				<option value="0">
					Please Select Reference Customer
				</option>
				<?php

					foreach(get_all_customers() as $customer)
					{
						$selected = '';
						if(isset($reference_data) && isset($reference_data->customer_id) && $customer->id == $reference_data->customer_id)
						{
							$selected = 'selected="selected"';
						}
				?>
					<option <?php echo $selected;?> value="<?php echo $customer->id;?>">
						<?php echo !empty($customer->companyname) ? $customer->companyname : $customer->name;?>
					</option>
				<?php
					}
				?>
				
			</select>
		</td>
		<td>
			Transporter : 
			<select name="transporter_id" id="transporter_id">
				<option selected="selected" value="0">
					Please Select Transporter
				</option>
			</select>
			<input type="text" name="manual_transporter" class="pull-right" style="width: 200px;">
			<br><br>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<br>
			<div class="col-md-3">
			Percentage : <input type="number" name="percentage" value="<?php echo isset($reference_data) ? $reference_data->percentage :  0;?>" min="0" 
			max="100" step="1">
			</div>

			<div class="col-md-3">
			Fix Amount : <input type="number" name="fix_amount" value="<?php echo isset($reference_data) ? $reference_data->fix_amount :  0;?>"  min="0" 
			max="10000" step="1">
			</div>

			<div class="col-md-3">
			<label>Print CYBERA : <input <?php echo $job_data->is_print_cybera == 1 ? 'checked="checked"' : '';?> value="1"  type="checkbox" name="is_print_cybera" id="is_print_cybera">
			</label>
			</div>

			<div class="col-md-3">
			<label><input value="0" <?php echo $job_data->is_customer_waiting == 0 ? 'checked="checked"' : '';?>  type="radio" name="is_customer_waiting" id="is_customer_waiting" checked="checked">
			Normal
			</label>
			<br>
			<label><input value="1" <?php echo $job_data->is_customer_waiting == 1 ? 'checked="checked"' : '';?>  type="radio" name="is_customer_waiting" id="is_customer_waiting">
			Customer Waiting
			</label>
			<br>
			<label> <input value="2" <?php echo $job_data->is_customer_waiting == 2 ? 'checked="checked"' : '';?>   type="radio" name="is_customer_waiting" id="is_customer_waiting">
			Customer On the Way
			</label>
			
			<label> <input value="3" <?php echo $job_data->is_customer_waiting == 3 ? 'checked="checked"' : '';?> type="radio" name="is_customer_waiting" id="is_customer_waiting">
				Call Customer once Job Finished
			</label>

			</div>

			<div class="col-md-12">
				<hr>
			</div>

			<div class="col-md-6">
				<label>Under Observation After This Job : <input value="1"  type="checkbox" name="is_revision_customer_next_job" id="is_revision_customer_next_job">
				</label>
			</div>

			<div class="col-md-6">
				<label>Block User After This Job : <input value="1"  type="checkbox" name="is_block_customer_next_job" id="is_block_customer_next_job">
				</label>
			</div>
			<div class="col-md-12">
				<hr>
			</div>
		</td>	
	</tr>
	<tr>
		<td colspan="2" align="center">
			<table border="2" class="table">
				<tr>
					
					<td>
						<label>
							<input  
						 type="radio"  <?php if($job_data->is_hold == 1) echo 'checked="checked"';?>  id="is_hold" checked="checked" name="is_hold" value="1">
							Payment Pending
						</label>
						<label>
							<input  <?php if($job_data->is_hold == 0) echo 'checked="checked"';?>  type="radio" name="is_hold" value="0">
							Payment Received
						</label>
						<br>
						<input type="text" name="payment_details" id="payment_details"  class="form-control"  value="<?=$job_data->payment_details?>">
					</td>
					<td>
						<label>
						<input   <?php if($job_data->is_pickup == 1) echo 'checked="checked"';?> type="radio" checked="checked" name="is_pickup" value="1">
						Cybera Pickup
						</label>

						<label>
							<input   <?php if($job_data->is_pickup == 0) echo 'checked="checked"';?> type="radio" name="is_pickup" value="0">
							Pickup Done
						</label>

						<br>
						<input type="text" name="pickup_details" id="pickup_details"  class="form-control" value="<?=$job_data->pickup_details?>">
					</td>

					<td>
						<label>
							<input <?php if($job_data->cyb_delivery == 1) echo 'checked="checked"';?> type="radio" id="cyb_delivery" name="cyb_delivery" value="1">
							Delivery Done
						</label>
						<label>

							<input type="radio" <?php if($job_data->cyb_delivery == 0) echo 'checked="checked"';?> name="cyb_delivery" value="0">
							Cybera Delivery
						</label>
						<br>
						<input type="text" name="delivery_details" id="delivery_details"  class="form-control"  value="<?=$job_data->delivery_details?>">
					</td>

					<td>
						<label>
							<input <?php if($job_data->is_manual == 1) echo 'checked="checked"';?> type="radio" name="is_manual" value="1">
							Complete ON
						</label>

						<label>
							<input <?php if($job_data->is_manual == 0) echo 'checked="checked"';?> type="radio" name="is_manual" value="0">
							Default
						</label>
						<br>
						<input type="text" name="manual_complete" id="manual_complete"  class="form-control" value="<?=$job_data->manual_complete?>">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>		
		<td align="right"> Remind Me : </td>		
		<td>		
		<select name="remindMe" id="remindMe" onchange="showRemindContainer()">		
			<option value="0">No</option>		
			<option value="1">Yes</option>		
		</select>		
		</td>		
	</tr>		
			
	<tr id="remindContainer" style="display: none;">		
	<td>		
			Reminder Time :		
	</td>		
	<td>		
			<input type="text" name="reminder_time"  id="sc_reminder_time" value="<?php echo date('Y/m/d H:i', strtotime('now +1 hour'));?>"  class="form-control datepicker" required="required">		
		</td>		
	</tr>		
</table>		

<hr>
<div class="col-md-2">
	Approx Complete Time : 
</div>
<div class="col-md-2">
	<input type="text" name="approx_completion" id="approx_completion" value="<?php echo $job_data->approx_completion;?>" class="form-control">
</div>



<div class="col-md-3">
	<table>
		<tr>
			<td>
				Total Jobs : 
			</td>
			<td>
				<input type="number" min="1" max="6" step="1"  value="<?php echo $job_data->sub_jobs;?>" type="text" name="sub_jobs" id="sub_jobs" class="form-control" required="required">
			</td>
		</tr>
	</table>
</div>

<div class="col-md-5" class="pull-right">
Confirm : 1 <input type="text" name="confirmation" id="confirmation" value="">
		<input type="submit" name="save" value="Save" class="btn btn-success btn-lg">
</div>
</form>


<div id="view_job_status" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="fancy_box_cutting"></div>
</div>
</div>


<div id="fancy_box_demo" style="width:100%;display: none;">
	<div style="width: 100%; margin: 0 auto; padding: 120px 0 40px;">
		<input type="hidden" name="fancybox_id" id="fancybox_id">

		<ul class="tabs" data-persist="true">
		    <li><a href="#paper_tab">Paper</a></li>
		    <li><a href="#view2">300/350 GSM Matt/Gloss Card</a></li>
		    <li><a href="#view3">Exclusive Visiting Cards</a></li>
		    <li><a href="#view4">Transparent & White with Multi Color Printing</a></li>
		</ul>
        <div class="tabcontents">
			<div id="paper_tab">
				<div class="row">
				<table width="80%" border="2">
					<tr>
						<td align="right">Select Paper : </td>
						<td><select  name="paper_gram" id="paper_gram">
							<?php foreach($paper_gsm as $gsm) {?>
							<option value="<?php echo strtolower($gsm['paper_gram']);?>">
							<?php echo $gsm['paper_gram'];?></option>
							<?php } ?>
						</select>
						</td>
					</tr>
					<tr>
						<td align="right">Select Paper Size: </td>
						<td><select name="paper_size" id="paper_size">
							<?php foreach($paper_size as $psize) {?>
							<option value="<?php echo strtolower($psize['paper_size']);?>">
							<?php echo $psize['paper_size'];?></option>
							<?php } ?>
							<option>10X10</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Print Side: </td>
						<td><select name="paper_print" id="paper_print">
							<option value="SS">Single</option>
							<option value="FB">Double ( front & Back )</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Quantity : </td>
						<td><input type="text" name="paper_qty" value="1" id="paper_qty"></td>
					</tr>
					<tr>
						<td colspan="2">
						<span class="btn btn-primary btn-sm" onclick="calculate_paper_cost()">Estimate Cost</span>
						<span id="result_paper_cost"></span>
						</td>
					</tr>
				</table>
				</div>
			</div>
             <div id="view2">
				<?php
					require_once('visiting-card-rates.php');
				?>
            </div>
            <div id="view3">
                <?php
					require_once('excluive-visiting-card-rates.php');
				?>
            </div>
            <div id="view4">
                <?php
					require_once('blak-white-card-rates.php');
				?>
            </div>
            
        </div>
    </div>
</div>

<script>
function showRemindContainer()		
{		
	var value = jQuery("#remindMe").val();		
	if(value == 1)		
	{		
		jQuery("#remindContainer").show();		
	}		
	else		
	{		
		jQuery("#remindContainer").hide();		
	}		
}
</script>


<script type="text/javascript">
	setTimeout(function()
	{
		jQuery("#reference_customer_id").select2();
		fetch_transporter(<?php echo $job_data->customer_id;?>);
	}, 100);

	function fetch_transporter(userid)
	{
		var selectList = document.getElementById('transporter_id'),
			option;

		selectList.innerHTML = '';
		
		$.ajax({
			 type: "POST",
			 url: "<?php echo site_url();?>/ajax/get_customer_transporter/", 
			 data: {
			 	userId: userid
			 },
			 dataType: 'JSON',
			 success: 
				function(data)
				{
					if(data.status == true)
					{
						for(var i = 0; i < data.transporters.length; i++)
						{
							option 			= document.createElement("option");
							option.value 	= data.transporters[i].id;
							option.text 	= data.transporters[i].name;
							selectList.appendChild(option);
						}
					}
					jQuery("#transporter_id").val(<?php echo $job_data->transporter_id;?>);

					//jQuery("#transporter_id").select2();
				}
		  });
	}
</script>

<script type="text/javascript">
	setTimeout(function()
	{
		jQuery("#reference_customer_id").select2();
		//jQuery("#emp_id").select2();
	}, 100);
</script>