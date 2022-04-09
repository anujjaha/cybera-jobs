<?php
$token = rand(1111111, 9999999);
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url();?>assets/js/job_details.js"></script>





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

function hideSaveButton()
{
	jQuery("#save_button").hide();
}

function showSaveButton()
{
	jQuery("#save_button").show();
}

$(document).ready(function() 
{
    jQuery(".select-mask").on('change', function(e)
    {
        var element = e.target,
            seqNumber = jQuery(element).attr('data-sequence');

        jQuery("#details_"+seqNumber).val(jQuery(e.target).find('option:selected').text());
    });

    jQuery(".select-rest").on('change', function(e)
    {
        var element = e.target,
            seqNumber = jQuery(element).attr('data-sequence');

        for(i in resMenus)
        {
            if($(element).val() == resMenus[i].code)
            {
                jQuery("#details_"+seqNumber).val('Code '+resMenus[i].code +': '+resMenus[i].title);
                jQuery("#qty_"+seqNumber).val(resMenus[i].qty);
                jQuery("#rate_"+seqNumber).val(resMenus[i].price);
                jQuery("#sub_"+seqNumber).val(resMenus[i].price * resMenus[i].qty);
                jQuery("#restExtra_"+seqNumber).html(resMenus[i].extra);

                $("#notes").val(menuTerms);

                jQuery("#flat_"+seqNumber).iCheck('toggle');
                jQuery("#flat_"+seqNumber).iCheck('update'); 
            }
        }
    });
	
    jQuery("#out-side-btn").on('click', function()
	{
		jQuery("#jobOutModalPopup").modal('show');
	});

	jQuery("#save_button").on('click', function(event)
	{
		hideSaveButton();

		setTimeout(function()
		{
			showSaveButton();
		}, 5000);
	});


	jQuery(document).on('click', '.show-offset-modal-box', function()
	{
		console.log(jQuery(this));
		console.log();
		
		//jQuery("#offsetModalPopup").modal('show');
		
		//jQuery("#offset_job_id").val(jQuery(this).attr('data-id'));
		
			//alert('test');
	});
	
      $('.fancybox').fancybox({
		'width':1000,
        'height':600,
        'autoSize' : false,
         afterShow: function(){
         	var fancyBoxId = jQuery("#fancybox_id").val();

         	jQuery("#details").val(jQuery("#details_"+fancyBoxId).val());
            console.log('// fancybox is open, run myFunct()');
            setTimeout(function() {
                console.log('rest value');
                
            }, 100);
        },
        'afterClose':function () {
			fancy_box_closed();
		},
    });
    
    
    var options_dealer = $('select.select-dealer option');
     var arr = options_dealer.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options_dealer.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
    
    var select_voucher = $('select.select-voucher option');
    var arr = select_voucher.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    select_voucher.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
    
    var options = $('select.select-customer option');
    var arr = options.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options.each(function(i, o) {
        //console.log(i);
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
	console.log('done');
});

function show_due(userid) {
	$.ajax({
		 type: "POST",
		 url: "<?php echo site_url();?>/ajax/get_customer_due_with_outside/"+userid, 
		 dataType: 'JSON',
		 success: 
			function(data)
			{
                jQuery("#save_button").removeAttr("disabled");
				if(data)
				{ 
					jQuery("#show_balance").html("Due : "+data.balance);
					jQuery("#is_outside").val(data.outsideStatus);
				} else {
					jQuery("#show_balance").html("");
				}
			}
	  });
}


function customer_selected(type,userid) {

	jQuery("#current_customer_type").val(type);


	if(jQuery("#current_customer_type").val() == 'dealer')
	{
		jQuery(".dealer").show();
		jQuery(".other").hide();
	}
	else
	{
		jQuery(".dealer").hide();
		jQuery(".other").show();
	}

	jQuery("#customer_id").val(userid);

    $.ajax(
    {
     type: "POST",
     dataType: 'JSON',
     url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userid, 
     success: 
        function(data)
        {
			jQuery("#mobile_"+type).val('');
        	jQuery("#mobile_"+type).val(data.mobile);
        	jQuery("#showEmailId").html("Email Id : " + data.email);
        	jQuery("#customerReviews").html("");

        	if(data.is_print_cybera == 0)
        	{
        		jQuery("#is_print_cybera").iCheck('uncheck')
        	}
        	
        	jQuery("#showStatstics").html("Jobs : " + data.total_jobs);
        	jQuery("#showStatstics").append(" || CR : " + data.total_credit);
        	jQuery("#showStatstics").append(" || DBT : " + data.total_debit) ;


        	jQuery("#isInvoice").html(data.is_invoice.toString() == "1" ? 'Yes' : 'No' );
        	jQuery("#isCyberaPay").html(data.is_party_pay.toString() == "1" ? 'No' : 'Yes' );
        	jQuery("#isCybera").html(data.is_print_cybera.toString() == "1" ? 'Yes' : 'No' );
        	jQuery("#isNote").html(data.message);

            if(
                data.message.length > 0 
                &&
                data.message != 'Collect Payment in Advance'
                )
            {
                var c = confirm(data.message);
                if(! c)
                {
                    window.location.reload();
                }    
            }
            

        	if(data.is_party_pay.toString() == "1")
        	{
        		jQuery("#party_pay").val(data.is_party_pay);
        	}
        	else
        	{
        		jQuery("#party_pay").val(0);	
        	}

        	if(data.locations)
        	{
        		resetLocations(data.locations);
        	}
        	else
        	{
        		document.getElementById('location_id').innerHTML = '';
        	}

        	if(data.is_5_tax == 1)
        	{
        		jQuery('#is_5_gst').iCheck('check'); 
        	}

        	if(data.is_invoice == 1)
        	{
        		jQuery('#is_job_invoice').iCheck('check'); 
        	}

        	if(data.under_revision == 1)
        	{
        		alert("Please Collect Payment in Advance for the Job.");

        		jQuery("#showEmailId").append("<br> <span class='red' style='font-size: 34px;'>"+ data.message +"</span>");

        		jQuery("#customerReviews").append("<br> <span class='red' style='font-size: 16px;'> <br>"+ data.customer_reviews +"</span>");

        		jQuery("#customerStarRating").html("Rating : " + data.rating);
        		
        		if(data.fixNote.length > 0)
        		{
        			jQuery("#fixNote").html("Message : " + data.fixNote);
        		}
        		else
        		{
        			jQuery("#fixNote").html("");	
        		}



        		jQuery("#save_button").hide();
        		 $('input[type=submit]', this).attr('disabled', 'disabled');
        		 jQuery("#jobname").val('');
        		 jQuery("#jobname").attr('disabled', 'disabled');

        	}
        	else
        	{
        		jQuery("#showEmailId").append("<br> <span class='red' style='font-size: 16px;'> <br>"+ data.customer_reviews +"</span>");

        		jQuery("#customerStarRating").html("Rating : " + data.rating);

        		if(data.fixNote.length > 0)
        		{
        			jQuery("#fixNote").html("Message : " + data.fixNote);
        		}
        		else
        		{
        			jQuery("#fixNote").html("");	
        		}


        		jQuery("#save_button").show();	
        		jQuery("#jobname").removeAttr('disabled', 'disabled');

        		$('input[type=submit]', this).removeAttr('disabled', 'disabled');
        	}

            if(data.referral_customer_id && data.referral_customer_id.toString() != "0" && data.referral_customer_id.length > 0)
            {
                jQuery("#reference_customer_id").val(data.referral_customer_id);
                jQuery("#fix_amount").val(1);
            }
        	console.log(data.email);
        	/*console.log(data);
        	console.log(data.email);*/
        	show_due(userid);
        	fetch_transporter(userid);
        }
  });
}

function resetLocations(locations)
{
	var selectEl  = document.getElementById('location_id'),
		locations = JSON.parse(locations),
		defaultValue,
		option;

	selectEl.innerHTML = '';

	for(var i = 0; i < locations.length; i++)
	{
		option 		= document.createElement("option");
		option.text = locations[i].add1 + ' ' + locations[i].add2 + ' ' + locations[i].city;
		option.value = locations[i].id;

		if(locations[i].is_default == 1)
		{
			defaultValue = locations[i].id;
		}

		selectEl.add(option);
	}

	if(defaultValue)
	{
		selectEl.value = defaultValue;
	}
	console.log(locations);
}

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
				//jQuery("#transporter_id").select2();
				console.log(data);
			}
	  });
}


function auto_suggest_price(id){
    jQuery("#fancy_box_demo_card_only_id").val(id);
    jQuery("#fancybox_id").val(id);
}
function set_cutting_details(id){
	jQuery("#fancybox_cutting_id").val(id);
    jQuery("#cut_icon_"+id).css('display','inline');
	if(jQuery("#category_"+id).val() == "ROUND CORNER CUTTING") {
		/*jQuery("#popup_cornercutting").css('display','none');
		jQuery("#popup_packing").css('display','none');
		jQuery("#popup_lasercutting").css('display','none');
		jQuery("#popup_machine").css('display','none');
		jQuery("#popup_size").css('display','none');
		jQuery("#popup_printing").css('display','none');
		jQuery("#popup_lamination").css('display','none');
		jQuery("#popup_binding").css('display','none');*/
		jQuery("#cutting_title").html('Round Corner - Cutting Details');
		return false;
	} else {
		jQuery("#popup_cornercutting").show();
		jQuery("#popup_lasercutting").show();
		jQuery("#popup_packing").show();
		jQuery("#popup_machine").show();
		jQuery("#popup_size").show();
		jQuery("#popup_printing").show();
		jQuery("#popup_lamination").show();
		jQuery("#popup_binding").show();
		jQuery("#cutting_title").html('Fill Cutting Details');
		return false;
	}
	
	if( jQuery("#category_"+id).val() == "Visiting Card" || jQuery("#category_"+id).val() == "Visiting Card Flat") {
		jQuery("#popup_lamination").css('display','none');
		jQuery("#popup_binding").css('display','none');
		jQuery("#cutting_title").html('Visiting Card - Cutting Details');
		return false;
	} else {
		jQuery("#popup_lamination").show();
		jQuery("#popup_binding").show();
		jQuery("#cutting_title").html('Fill Cutting Details');
		return false;
	}
	
}
function set_cutting_details_box(id)
{
    var data_id = jQuery("#fancybox_cutting_id").val();
    var machine,size,details,lamination,printing,packing,lamination_info,binding,checking,c_corner,c_laser,c_rcorner,c_cornerdie;
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
        sheet_qty = jQuery("#sheet_qty").val();

        blade_per_sheet = jQuery("#blade_per_sheet").val();
        binding_info = jQuery("#binding_info").val();
        details = jQuery("#details").val();
        lamination = $('input:radio[name=lamination]:checked').val();//jQuery("#lamination").val();
        checking = $('input:radio[name=checking]:checked').val();//jQuery("#lamination").val();
        size = $('input:radio[name=size]:checked').val();//jQuery("#lamination").val();
        printing =  $('input:radio[name=printing]:checked').val();// jQuery("#printing").val();
        packing =  $('input:radio[name=packing]:checked').val(); //printing jQuery("#packing").val();
        cCorner =  $('input:radio[name=c_corner]:checked').val(); //printing jQuery("#c_corner").val();

        console.log('C-', machine);
        console.log('C-Q', jQuery("#qty_"+data_id).val());
        console.log('C-size', size);
        console.log('C-details', details);
        console.log("data_id", data_id);



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

        jQuery("#c_sheetinfo_"+data_id).val(sheet_qty);

        jQuery("#c_blade_per_sheet_"+data_id).val(blade_per_sheet);
        jQuery("#c_bindinginfo_"+data_id).val(binding_info);
        jQuery("#c_binding_"+data_id).val(binding);
        jQuery("#c_checking_"+data_id).val(checking);
        
        jQuery("#c_corner_"+data_id).val(cCorner);

        jQuery("#c_laser_"+data_id).val($("#c_laser").val());
        
        jQuery("#c_lamination_cutting_"+data_id).val($("#c_lamination_cutting").val());
        
        jQuery("#c_cornerdie_"+data_id).val($("#c_cornerdie").val());
        

        var cBox = $('input[name=c_box_box]:checked').val();
        var cDubby = $('input[name=c_box_dubby]:checked').val();


        jQuery("#c_box_box_"+data_id).val(cBox ? cBox : 'No');
        jQuery("#c_box_dubby_"+data_id).val(cDubby ? cDubby : "No");


        $.fancybox.close();
        var isCornerCuttingApplied = 0;
        
        // if(jQuery("#category_"+data_id).val() != "Visiting Card" && jQuery("#c_machine_"+data_id).val().length > 0 && data_id < 5)
        if(data_id < 5)
        {
            console.log('store CUtting sip');
            var nextElement = parseInt(data_id) + 1;
            
            jQuery("#category_" + nextElement).val("Cutting");
            jQuery("#details_" + nextElement).val("Cutting");
            jQuery("#qty_" + nextElement).focus();

            if(cCorner == "Yes" && data_id < 4 && jQuery("#category_"+data_id).val() != "ROUND CORNER CUTTING")
            {
                nextElement = parseInt(nextElement) + 1;
                jQuery("#category_" + nextElement).val("Cutting");
                jQuery("#details_" + nextElement).val("Corner Cutting");
                jQuery("#qty_" + nextElement).focus();
                isCornerCuttingApplied = 1;
            }
        }

        if(isCornerCuttingApplied == 0 && jQuery("#c_machine_"+data_id).val().length > 0 && data_id < 4
             && jQuery("#category_"+data_id).val() != "ROUND CORNER CUTTING"
            )
        {
            var nextElement = parseInt(data_id) + 1;
            
            if(cCorner == "Yes" && data_id < 4)
            {
                jQuery("#category_" + nextElement).val("Cutting");
                jQuery("#details_" + nextElement).val("Corner Cutting");
                jQuery("#qty_" + nextElement).focus();
            }
        }
        
        if(jQuery("#category_"+data_id).val() == "Visiting Card")
        {
            jQuery("#sub_"+data_id).focus();
        }

        resetCuttingForm();
}

function set_cutting_details_boxAndOut()
{
	var data_id = jQuery("#fancybox_cutting_id").val();
	var machine,size,details,lamination,printing,packing,lamination_info,binding,checking,c_corner,c_laser,c_rcorner,c_cornerdie;
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
        sheet_qty = jQuery("#sheet_qty").val();

        blade_per_sheet = jQuery("#blade_per_sheet").val();
        binding_info = jQuery("#binding_info").val();
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

        jQuery("#c_sheetinfo_"+data_id).val(sheet_qty);

        jQuery("#c_blade_per_sheet_"+data_id).val(blade_per_sheet);
        jQuery("#c_bindinginfo_"+data_id).val(binding_info);
        jQuery("#c_binding_"+data_id).val(binding);
        jQuery("#c_checking_"+data_id).val(checking);
        
        jQuery("#c_corner_"+data_id).val(cCorner);

        jQuery("#c_laser_"+data_id).val($("#c_laser").val());
        
        jQuery("#c_lamination_cutting_"+data_id).val($("#c_lamination_cutting").val());
        
        jQuery("#c_cornerdie_"+data_id).val($("#c_cornerdie").val());
        

        var cBox = $('input[name=c_box_box]:checked').val();
        var cDubby = $('input[name=c_box_dubby]:checked').val();


        jQuery("#c_box_box_"+data_id).val(cBox ? cBox : 'No');
        jQuery("#c_box_dubby_"+data_id).val(cDubby ? cDubby : "No");


        $.fancybox.close();
        var isCornerCuttingApplied = 0;
        
        if(jQuery("#category_"+data_id).val() != "Visiting Card" && jQuery("#c_machine_"+data_id).val().length > 0 && data_id < 5)
        {
            var nextElement = parseInt(data_id) + 1;
            
            jQuery("#category_" + nextElement).val("Cutting");
            jQuery("#details_" + nextElement).val("Cutting");
            jQuery("#qty_" + nextElement).focus();

            if(cCorner == "Yes" && data_id < 4 && jQuery("#category_"+data_id).val() != "ROUND CORNER CUTTING")
            {
                nextElement = parseInt(nextElement) + 1;
                jQuery("#category_" + nextElement).val("Cutting");
                jQuery("#details_" + nextElement).val("Corner Cutting");
                jQuery("#qty_" + nextElement).focus();
                isCornerCuttingApplied = 1;
            }
        }

        if(isCornerCuttingApplied == 0 && jQuery("#c_machine_"+data_id).val().length > 0 && data_id < 4
             && jQuery("#category_"+data_id).val() != "ROUND CORNER CUTTING"
            )
        {
			var nextElement = parseInt(data_id) + 1;
			
            if(cCorner == "Yes" && data_id < 4)
            {
                jQuery("#category_" + nextElement).val("Cutting");
                jQuery("#details_" + nextElement).val("Corner Cutting");
                jQuery("#qty_" + nextElement).focus();
            }
		}
		
		if(jQuery("#category_"+data_id).val() == "Visiting Card")
		{
			jQuery("#sub_"+data_id).focus();
		}

        resetCuttingForm();
        jQuery("#jobOutModalPopup").modal('show');
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
	id 			= jQuery("#fancybox_id") ? jQuery("#fancybox_id").val() : jQuery("#fancy_box_demo_card_only_id");
	paper_qty = jQuery("#paper_qty").val();
	ori_paper_qty = jQuery("#paper_qty").val();
	if(paper_print == "FB") {
		//paper_qty = paper_qty *2;
	}
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_paper_rate/", 
         data:{
         	"paper_gram":paper_gram,
         	"paper_size":paper_size,
            "paper_print":paper_print,
            "paper_qty":paper_qty,
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
							/*amount = amount * 2 - 2;
							paper_qty = paper_qty / 2;*/
						}
					}
                  
                  total = (amount * paper_qty )* mby;
                  jQuery("#result_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );

                  jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                  
                  

                  /*if(paper_print == "FB") {
					jQuery("#rate_"+id).val(amount * 2);
                    if(paper_size == "13X19" || paper_size == "13x19" ) {
						  jQuery("#rate_"+id).val(amount);
					}
                  } else {
                      jQuery("#rate_"+id).val(amount);
                  }*/
				    jQuery("#rate_"+id).val(amount);
                  
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
		
		/*var status = confirm("Do You want to Create Bill ?");
		if(status) {
			jQuery("#subtotal").focus();
			return false;
		}*/
		
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
        
        $("#maskContainer_"+sr).hide(); 
        $("#restContainer_"+sr).hide(); 

        if($("#category_"+sr).val() == "Mask") {
            $("#details_"+sr).val("Mask");
            $("#maskContainer_"+sr).show(); 
        }
        else if($("#category_"+sr).val() == "Menu")
        {
            $("#details_"+sr).val("");
            $("#restContainer_"+sr).show();  

            // Empty Select Box
            $('#sel_rest_'+sr).empty();

            for(i in resMenus)
            {
                $('#sel_rest_'+sr).append(`<option>`+resMenus[i].code+`</option>`);
            }  
        }
        else
        {
            $("#details_"+sr).val("");
            $("#maskContainer_"+sr).hide(); 
        }	

        if($("#category_"+sr).val() == "Cutting") {
			$("#details_"+sr).val("Cutting");
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
		if($("#category_"+sr).val() == "Sticker Sheet") {
			$("#details_"+sr).val("Sticker Sheet");
		}
		if($("#category_"+sr).val() == "Flex") {
			$("#details_"+sr).val("Flex");
		}
		if($("#category_"+sr).val() == "Binding") {
			$("#details_"+sr).val("Binding");
		}
		if($("#category_"+sr).val() == "Packaging and Forwarding") {
			$("#details_"+sr).val("Packaging and Forwarding");
		}
		if($("#category_"+sr).val() == "Transportation") {
			$("#details_"+sr).val("Transportation");
		}
		if($("#category_"+sr).val() == "Offset Print") {
			$("#details_"+sr).val("Offset Print");
			$("#offsetjob-"+sr).show();
		}
		else
		{
			$("#offsetjob-"+sr).hide();
		}
		
		if($("#category_"+sr).val() == "Visiting Card") {
			$("#details_"+sr).val("Visiting Card");
		}
		
		/*if($("#category_"+sr).val() == "Visiting Card Flat") {
			$("#category_"+sr).val("Visiting Card Flat");
		}*/
		
		
		
		if($("#category_"+sr).val() == "B/W Xerox") {
			$("#details_"+sr).val("B/W Xerox");
		}
		if($("#category_"+sr).val() == "ROUND CORNER CUTTING") {
			$("#details_"+sr).val("ROUND CORNER CUTTING");


			if(jQuery("#current_customer_type").val() == 'dealer')
			{
				$("#rate_"+sr).val(".25");
			}
			else
			{
				$("#rate_"+sr).val(".50");	
			}
		}
		
		if($("#category_"+sr).val() == "Laser Cutting") {
			$("#details_"+sr).val("Laser Cutting");
		}

		if($("#category_"+sr).val() == "Transparent Visiting Card") {
			$("#details_"+sr).val("Transparent Visiting Card");
		}

		if($("#category_"+sr).val() == "Not Applicable") {
			$("#details_"+sr).val("Not Applicable");
			$("#qty_"+sr).val("0");
			$("#rate_"+sr).val("0");
			$("#sub_"+sr).val("0");
		}
		
        for(i in resMenus)
        {
            if($("#category_"+sr).val() == i)
            {
                $("#details_"+sr).val(resMenus[i]);
            }
        }
        

		open_price_list(sr);
}
function open_price_list(sr)
{
	auto_suggest_price(sr);
	var catValue = jQuery("#category_" + sr ).val();
	
	if(catValue == 'Digital Print' || catValue == 'Visiting Card' || catValue == 'Visiting Card Flat' || catValue == 'Transparent Visiting Card' )
	{	
		var currentCustomer = jQuery("#current_customer_type").val();

		if(jQuery("#category_"+sr).val() == "Digital Print" && currentCustomer == "dealer")
		{
			$.fancybox({
                'href': '#fancy_box_demo_paper_only',
                'width':1000,
				'height':600,
				'autoSize' : false,
				'afterClose':function () {
					
					fancy_box_closed();
					setTimeout(function()
					{
						openCuttingSlip(sr, catValue);	
					}, 10);
				}
            });
		}
		else
		{
			$.fancybox({
                'href': '#fancy_box_demo_card_only',
                'width':1000,
				'height':600,
				'autoSize' : false,
				'afterClose':function () {
					
					fancy_box_closed();
					setTimeout(function()
					{
						openCuttingSlip(sr, catValue);	
					}, 10);
				}
            });
		}
		
		/*$.fancybox({
                'href': '#fancy_box_demo',
                'width':1000,
				'height':600,
				'autoSize' : false,
				afterShow: function () {
					console.log('aftershow');
	    		},
				'afterClose':function () {
					
					fancy_box_closed();
					setTimeout(function()
					{
						openCuttingSlip(sr, catValue);	
					}, 10);
				}
            });*/

	}
	
}

function hideShow()
{
	
}
function openCuttingSlip(id, catValue)
{
	if(catValue == "Visiting Card" || catValue == "Visiting Card Flat")
	{
		set_cutting_details(id);
		
		$.fancybox({
                'href': '#fancy_box_cutting',
                
        });
	}
}
function check_existing_customer(value) {
	if(jQuery("#new_customer_name").val().length > 0 || jQuery("#new_customer_companyname").val().length > 0 ) {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_customer_details_by_param/mobile/"+value, 
			success: 
			function(data){
				if(data.length > 0 ) {
					jQuery("#save_button").attr("disabled","disabled");
					jQuery("#mobile_error_message").html(data + " Customer already Exists");
					alert("Customer "+ data +" already Exists with Contact Number : "+value);
				}
			}
		});
	} 
	
}
</script>

<script>
function check_receipt() {
	var s_receipt = $("#receipt").val();
	if(s_receipt.length > 0 ){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_check_receipt/"+s_receipt, 
			success: 
				function(data){
					if(data == 1) {
						$("#receipt").focus();
						alert("Receipt Alread Exist !");
						return false;
					} 
			 }
          });
	  }
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general'); ?>
<form action="<?php echo site_url();?>/jobs/edit" method="post" onsubmit="return check_form();check_receipt();calc_due();">
<div class="col-md-12">
<table width="100%" border="2">
	<tr>
        <td align="center">
        <h3>Customer Type</h3>
        <p id="balance"  align="right"><h2 class="red" id="show_balance" ></h2></p>

        
        
        <p align="center"  style="font-size: 22px;">Notes: <span class="red" id="isNote" ></span></p>
        <p align="right"><h4 class="green" id="fixNote" ></h4></p>
        </td>
        <td width="50%" align="center"> 
            <p align="right"><h4 class="green" id="showEmailId" ></h4></p>
            <p align="right"><h4 class="green" id="showStatstics" ></h4></p>
            <p align="right"><h4 class="green" id="customerReviews" ></h4></p>
            <p align="right"><h4 class="green" id="customerStarRating" ></h4></p>
            
            <p align="center">Invoice: <span class="green" id="isInvoice" ></span></p>
            <p align="center">Cybera: <span class="green" id="isCybera" ></span></p>
            <p align="center">Shipping Cybera Pay: <span class="green" id="isCyberaPay" ></span></p>
        </td>
   	<tr>
   		<td colspan="2" align="center">
        <div class="row">
            <div class="col-md-3">
                <span onClick="set_customer('new_customer');">
                    New Customer
                </span>
            </div>
            <div class="col-md-3">
                <span onClick="set_customer('regular_customer');">
                    Regular Customer
                </span>
            </div>
            <div class="col-md-3">
                <span onClick="set_customer('voucher_customer');">
                    Vocuher Customer
                </span>
            </div>
            <div class="col-md-3">
                <span onClick="set_customer('cybera_dealer');" >
                    Cybera Dealer
                </span>
            </div>
        </div>
        </td>

	</tr>
	<tr>
        <td colspan="2">
            <div id="new_customer" style="display:none;">
                <div class="col-md-6">
					<div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" 
                                    name="companyname" id="new_customer_companyname" value="" placeholder="Company Name">
                            </div>
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="new_customer_name" name="name" value="" placeholder="Name">
                    </div>
                </div>
                    <div class="col-md-6">
							<div class="form-group">
								<label>Contact Number <span style="color:red;font-size:14px;" id="mobile_error_message"></span></label>
								<input type="text" class="form-control" onblur="check_existing_customer(this.value);" name="user_mobile" id="user_mobile" value="" placeholder="Mobile Number">
							</div>
                            <div class="form-group">
                                    <label>Email Id</label>
                                    <input type="text" class="form-control"
                                           name="emailid" value="" placeholder="Email Id">
                            </div>
                    </div>
					
					<div class="col-md-6">
						<!-- text input -->
						<div class="form-group">
							<label>Address Line 1</label>
							<input type="text" class="form-control" name="add1" value="<?php if(!empty($dealer_info->add1)){echo $dealer_info->add1;}?>" placeholder="Address">
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Address Line 2</label>
							<input type="text" class="form-control" name="add2" value="<?php if(!empty($dealer_info->add2)){echo $dealer_info->add2;}?>" placeholder="Address">
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>City</label>
							<input type="text" class="form-control" name="city" value="<?php if(!empty($dealer_info->city)){echo $dealer_info->city;}else{ echo"Ahmedabad";}?>" placeholder="City">
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>State</label>
							<input type="text" class="form-control" name="state" value="<?php if(!empty($dealer_info->state)){echo $dealer_info->state;}else { echo "Gujarat";}?>" placeholder="State">
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Pin</label>
							<input type="text" class="form-control" name="pin" value="<?php if(!empty($dealer_info->pin)){echo $dealer_info->pin;}?>" placeholder="Pincode">
						</div>
					</div>
					<div class="col-md-6 text-center">
							<div class="form-group">
								<label><input type="radio" checked="checked" name="customerType" value="NewCustomer">Customer</label>
								<label><input type="radio" name="customerType" value="NewDealer">Dealer</label>
								<label><input type="radio" name="customerType" value="NewVoucher">Voucher</label>
							</div>
					</div>
            </div>
                <div id="regular_customer" style="display:none;">
                        <table width="100%">
                                <tr>
                                        <td width="50%">
                                                Customer Name : <?php echo create_customer_dropdown('customer',true); ?>
                                        </td>
                                        <td width="50%" align="right">
                                                Contact Number : <input type="text" name="mobile" id="mobile_customer">
                                                <input type="text" name="regular_extra_contact_number" id="regular_extra_contact_number">
                                        </td>
                                </tr>
                        </table>
                </div>
                <div id="cybera_voucher" style="display:none;">
                        <table width="100%">
                        <tr>
                                <td width="50%">
                                        Customer Name : <?php echo create_customer_dropdown('voucher',true); ?>
                                </td>
                                <td width="50%" align="right">
                                        Contact Number : <input type="text" name="mobile" id="mobile_voucher">
                                        <input type="text" name="voucher_extra_contact_number" id="voucher_extra_contact_number">
                                </td>
                        </tr>
                        </table>
                </div>
                <div id="cybera_dealer" style="display:none;">
                        <table width="100%">
                        <tr>
                                <td width="50%">
                                        Dealer Name : <?php echo create_customer_dropdown('dealer',true); ?>
                                </td>
                                <td width="50%" align="right">
                                        Contact Number : <input type="text" name="mobile" id="mobile_dealer">
                                        <input type="text" name="dealer_extra_contact_number" id="dealer_extra_contact_number">
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
                    Job Name : <input type="text" name="jobname"
                                      id="jobname" required="required" style="width:250px;">
            </td>
	</tr>
	<tr>
            <td width="5%">Sr</td>
            <td width="10%">Category</td>
            <td width="120px;">Details</td>
            <td width="10%">Qty.</td>
            <td width="5%">Calculate</td>
            <td width="10%">Rate</td>
            <td width="10%">Amount</td>
	</tr>
	<?php for($i=1;$i<6;$i++){ ?>
	<tr>
        <td><?php echo $i;?></td>
            
            <td>
                <div class="row">
                <div class="col-md-6">
                    <select class="form-control" style="width: 100px;" name="category_<?php echo $i;?>" id="category_<?php echo $i;?>" onChange="check_visiting_card(<?php echo $i;?>);">
                            <option>Select Category</option>
                            <option>Mask</option>
                            <option>Digital Print</option>
                            <option>Visiting Card</option>
                            <option>Visiting Card Flat</option>
                            <option>Transparent Visiting Card</option>
                            <option>Menu</option>
                            <option>Offset Print</option>
                            <option>Card Box</option>
                            <option>Flex</option>
                            <option>Cutting</option>
                            <option>Designing</option>
                            <option>Editing Charge</option>
                            <option>Binding</option>
                            <option>Sticker Sheet</option>
                            <option>Lamination</option>
                            <option>Laser Cutting</option>
                            <option>ROUND CORNER CUTTING</option>
                            <option>Packaging and Forwarding</option>
                            <option>Transportation</option>
                            <option>B/W Print</option>
                            <option>B/W Xerox</option>
                            <option>Not Applicable</option>
                            
                            <!-- <option>02</option>
                            <option>02-A</option> -->
                    </select>
                </div>
                <div class="col-md-6" id="maskContainer_<?php echo $i;?>" style="display: none;">
                         <select data-sequence="<?php echo $i;?>" class="form-control select-mask" style="width: 100px;" name="mask_<?php echo $i;?>" id="mask_<?php echo $i;?>">
                         <option value="">Select Mask</option>
                         <?php
                            foreach($maskCategories as $maskCate)
                            {
                        ?>
                            <option value="<?= $maskCate['name'];?>" ><?= $maskCate['name'];?></option>
                        <?php
                            }
                         ?>
                         </select>
                </div>

                <div class="col-md-6" id="restContainer_<?php echo $i;?>" style="display: none;">
                    <select data-sequence="<?php echo $i;?>" class="form-control select-rest" style="width: 75px;" name="rest_<?php echo $i;?>" id="sel_rest_<?php echo $i;?>">
                    </select>
                    <span id="restExtra_<?php echo $i;?>"></span>
                </div>
                </div>
            </td>
            <td>
            <!---<a class="fancybox fa fa-fw fa-question-circle" 
               onclick="return auto_suggest_price(<?php echo $i;?>);" href="#fancy_box_demo">
            </a>-->

            <input  type="text" id="details_<?php echo $i;?>" name="details_<?php echo $i;?>" style="width: 90%;">
            
            <span id="offsetjob-<?php echo $i;?>" data-sr="<?php echo $i;?>" data-id="0" class="show-offset-modal-box" style="display: none;"><i class="fa fa-check" aria-hidden="true"></i></span>
            
            </td>
            
            <td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>"  style="width: 60px;"></td>
            <td align="center"><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>" ></td>
            <td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>" style="width: 60px;"></td>
            <td align="right"><input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" 
            onblur="check_total(<?php echo $i;?>)" style="width: 60px;">
             <a class="fancybox fa fa-fw fa-cut" 
               onclick="return set_cutting_details(<?php echo $i;?>);" href="#fancy_box_cutting">
             </a>
			<a class="fa fa-fw fa-minus-square" id="cut_icon_<?php echo $i;?>" style="display:none;"
                onclick="return remove_cutting_details(<?php echo $i;?>);" href="javascript:void(main);">
            </a>
            </td>
	</tr>
	<?php } ?>
	<tr>
        <td rowspan="4" colspan="5">
        	<table>
        			<tr>
        			<td>
                        Notes : <textarea name="notes" id="notes" cols="40" rows="5"></textarea>
                    </td>
                    <td>&nbsp;</td>
                    <td>
        				<span class="green">EMAIL Notes:</span> <textarea name="mail_note" id="mail_note" cols="40" rows="5"></textarea>
        			</td>
                    <td>&nbsp;</td>
        			<td>
        				Extra Notes : <textarea name="extra_notes" style="background-color: pink;" cols="40" rows="5"></textarea>
        			</td>
        			<!-- <td>
        				<div class="row">
        					<div class="col-md-6">
        						P & F
        					</div>
        					<div class="col-md-6">
        						<input type="text" name="package">
        					</div>
        					<div class="col-md-6">
        						TRA
        					</div>
        					<div class="col-md-6">
        						<input type="text" name="package">
        					</div>
        				</div>
        			</td> -->
        			</tr>
        	</table>
        </td>
        
        <td align="right">
                Sub Total :
        </td>
        <td><input type="text" id="subtotal"
                       name="subtotal" required="required" onblur="calc_subtotal()" style="width: 80px;">
        </td>
    </tr>
    <tr>
        <td>
        	Apply Tax : 
        </td>
        <td>
                <select class="form-control" id="gst_tax" name="gst_tax" required="required">
                	<option value="">Select</option>
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
            <input type="text" id="tax" name="tax" onblur="calc_tax()" style="width: 80px;">
            </td>
	</tr>
	<tr>
            <td align="right">
                    Total :
            </td>
            <td>
                <input type="text" id="total" name="total" required="required" onfocus="calc_total(); calc_due();"  style="width: 80px;">
            </td>
	</tr>
	<tr>
		<td colspan="7" align="right">
			<input type="hidden" id="current_customer_type" name="current_customer_type" value="normal">
			<input type="hidden" id="advance" name="advance" value="0">
			<input type="hidden" id="receipt" name="receipt" value="0">
			<input type="hidden" id="bill_number" name="bill_number" value="0">
			<input type="hidden" id="due" name="due" >
			<input type="hidden" name="dealer_id" value="<?php if(!empty($dealer_info->id)){echo $dealer_info->id;}?>">
			<input type="hidden" name="customer_type" id="customer_type">
			<input type="hidden" name="customer_id" id="customer_id">
			
			
		</td>
	</tr>
</table>

<div class="clearfix"></div>
<hr>
<table align="center" class="table" style="border: 1px solid;"  border="2">	 	
	<tr>
		<td>
            <div class="row">
                <div class="col-md-4">
                    Transporter : 
                    <select name="transporter_id" id="transporter_id">
                        <option selected="selected" value="0">
                            Please Select Transporter
                        </option>
                    </select>
                    <input type="text" name="manual_transporter" class="pull-right" style="width: 300px;">
                </div>
                <div class="col-md-4">
        			Transportation Charges Paid By:
        			<select name="party_pay" id="party_pay" required="required">
                        <option value="" selected="selected">Select Transporter Charges</option>
        				<option value="2" >N/A</option>
        				<option value="0">Cybera</option>
        				<option value="1">Party</option>
        			</select>
                </div>

                <div class="col-md-2">
                    Total Jobs : <input  value="1" type="number" min="1" max="10" step="1" name="sub_jobs" id="sub_jobs" class="form-control" required="required">        
                </div>

                <div class="col-md-2">
                    <a href="javascript:void(0);" class="btn btn-primary pull-right" id="out-side-btn">
                        Out Side
                    </a>
                </div>
            </div>
        </td>
         
	</tr>
    <?php
    if(
        strtolower($this->session->userdata['department']) == "master"
                
        ||

        $this->session->userdata['user_id'] == 14
    )
    {
    ?>
	<tr>
		<td colspan="2">
			Reference Customer : 
			<select name="reference_customer_id" id="reference_customer_id">
				<option value="0">
					Please Select Reference Customer
				</option>
				<?php
					foreach(get_all_customers() as $customer)
					{
				?>
					<option value="<?php echo $customer->id;?>">
						<?php echo !empty($customer->companyname) ? $customer->companyname : $customer->name;?>
					</option>
				<?php
					}
				?>
				
			</select>
		</td>
	</tr>
    <?php
    }
    ?>
	<tr>
		<td colspan="2">
			
            <?php
            if(
                strtolower($this->session->userdata['department']) == "master"
                
                ||

                $this->session->userdata['user_id'] == 14
            )
            {
            ?>
            <div class="col-md-3">
				Percentage : <input type="number" name="percentage" value="0" min="0" 
				max="100" step="1">
			</div>

			<div class="col-md-3">
				Fix Amount : <input type="number" name="fix_amount" id="fix_amount" value="0"  min="0" 
				max="10000" step="1">
			</div>
            <?php
            }
            ?>
			

			<div class="col-md-3" style="display: none;">
				<label><input value="0" type="radio" name="is_customer_waiting" id="is_customer_waiting" checked="checked">
				Normal
				</label>
				<br>
				<label><input value="1" type="radio" name="is_customer_waiting" id="is_customer_waiting">
				Customer Waiting
				</label>
				<br>
				<label> <input value="2"  type="radio" name="is_customer_waiting" id="is_customer_waiting">
				Customer On the Way
				</label>

				<label> <input value="3"  type="radio" name="is_customer_waiting" id="is_customer_waiting">
					Call Customer once Job Finished
				</label>
			</div>
			
			<!-- <div class="col-md-12">
				<hr>
			</div> -->

			<!-- <div class="col-md-6">
				<label>Under Observation After This Job : <input value="1"  type="checkbox" name="is_revision_customer_next_job" id="is_revision_customer_next_job">
				</label>
			</div>

			<div class="col-md-6">
				<label>Block User After This Job : <input value="1"  type="checkbox" name="is_block_customer_next_job" id="is_block_customer_next_job">
				</label>
			</div>
			<div class="col-md-12">
				<hr>
			</div> -->
		</td>	
	</tr>
	<tr>
		<td colspan="2" align="center">
			<table border="2" class="table">
				<tr>
					
					<td>
						<label>
							<input type="checkbox" name="is_hold" value="1">
							Payment Pending
						</label>

						<!-- <label>
							<input type="radio" id="is_hold" checked="checked" name="is_hold" value="1">
							Payment Pending
						</label>
						<label>
							<input type="radio" name="is_hold" value="0">
							Payment Received
						</label> -->
						<br>
						<input type="text" name="payment_details" id="payment_details"  class="form-control" value="">
					</td>
					<td>
						<label>
							<input type="checkbox" name="is_pickup" value="1">
							Cybera Pickup
						</label>
						<!-- <label>
						<input type="radio" checked="checked" name="is_pickup" value="1">
						Cybera Pickup
						</label>

						<label>
							<input type="radio" name="is_pickup" value="0">
							Pickup Done
						</label> -->

						<br>
						<input type="text" name="pickup_details" id="pickup_details"  class="form-control" value="">
					</td>

					<td>
						<label>
							<input type="checkbox" name="cyb_delivery" value="1">
							Cybera Delivery
						</label>
						<!-- <label>
							<input type="radio" id="cyb_delivery" name="cyb_delivery" value="1">
							Delivery Done
						</label> -->
						<br>
						<input type="text" name="delivery_details" id="delivery_details"  class="form-control" value="">
					</td>

                    <td>
                        <label>
                            <input type="checkbox" name="is_5_gst" id="is_5_gst"  value="1">
                            FIX 5% GST
                        </label>
                        <br>
                        Used to Generate 5% BILL
                    </td>

                    <td>
                        <label>
                            <input type="checkbox" name="is_job_invoice" id="is_job_invoice"  value="1">
                            Invoice
                        </label>
                        <br>
                        <input type="text" name="invoice_details" id="invoice_details"  class="form-control" value="">
                    </td>

					<td>

                            <label><input checked="checked" type="checkbox" name="is_print_cybera" value="1" id="is_print_cybera">
                            Print CYBERA 
                            </label>
                            <br />
                            <label><input type="checkbox" checked="checked" name="sendUpdateMail" value="1">Mail</label><br />
                        
						<!-- <label>
							<input type="checkbox" name="is_manual" value="1">
							Complete ON
						</label>
						<br>
						<input type="text" name="manual_complete" id="manual_complete"  class="form-control" value=""> -->

                        
                        <!-- <label>
                            <input type="radio" id="cyb_delivery" name="cyb_delivery" value="1">
                            Delivery Done
                        </label> -->
					</td>
				</tr>
			</table>
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

<div class="col-md-3">
	Address : 
	<select id="location_id" name="location_id" class="form-control">
		<option value="">Select Address</option>
	</select>
</div>

<div class="col-md-2">
	Approx Complete Time : 
	<input type="text" name="approx_completion" id="approx_completion" class="form-control" required="required">
</div>


<div class="col-md-2">
	Payment Type:
	<select id="pay_type" name="pay_type" onchange="showPaytmId()" class="form-control" required="">
		<option value="">Select Mode</option>
		<option value="Cash">Cash</option>
        <option value="Card">Card</option>
		<option value="Paytm">Paytm</option>
		<option value="Aangadiya">Aangadiya</option>
		<option value="NEFT">NEFT</option>
		<option value="No Payment">NO Payment</option>
		<option value="Google Pay">Google Pay</option>
		<option value="Cheque">Cheque</option>
		<option value="Advance">Advance</option>
	</select>
    <br />
    <input type="text" name="paytm_id" id="paytm_id" class="form-control" placeholder="Paytm ID" style="display: none;">
</div>
<div class="col-md-1">
	Is Continue
	<select name="is_continue" class="form-control">
		<option value="0">No</option>
		<option value="1">Yes</option>
	</select>
</div>
<div class="col-md-2">
    Job Creator :  <br />
    <select name="emp_id" id="emp_id" class="form-control">
        <option selected="selected" value="0">
            Please Select Operator
        </option>
        <?php
            foreach(getAllEmployees(true) as $employee)
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

<div class="col-md-2" class="pull-right">

Confirm : 1 <input type="text" name="confirmation" style="width: 30px;" id="confirmation" value="">
			<input type="submit" name="save" id="save_button"  value="Save" class="btn btn-success btn-lg">
</div>
<input type="hidden" name="is_outside" id="is_outside" value="0">
</form>

<div id="fancy_box_cutting" style="width:800px;display: none;">
    <form id="fancyBoxCuttingForm">
    <div style="width: 800px; margin: 0 auto;">
        <table  width="80%" border="2" align="center">
            <tr>
                <td colspan="2" align="center">
					<h1 id="cutting_title">Fill Cutting Details</h1>
                </td>
            </tr>
            <tr>
                <td align="center">
					<span class="btn btn-primary setCuttingAuto" data-side="1" data-size-info="1/24" data-machine="1">Single Side</span>
                </td>
                <td align="center">
					<span class="btn btn-primary setCuttingAuto" data-side="2" data-size-info="1/24" data-machine="1">Front Back</span>
                </td>
            </tr>
            <tr id="popup_machine">
                <td align="right" width="50%">Machine:</td>
                <td  width="50%">
                    <label><input type="radio"  checked="checked" id="machine" name="machine" value="1">1</label>
                    <label><input type="radio"  id="machine" name="machine" value="2">2</label>
                    <label><input type="radio" id="machine" name="machine" value="Xrox">Xrox</label>
                </td>
            </tr>
            <tr id="popup_size">
                <td align="right">Size:</td>
                <td>
                    <label><input type="radio" name="size" id="size" value="A4">A4</label>
                    <label><input type="radio" name="size" id="size" value="A3">A3</label>
                    <label><input type="radio" checked="checked" name="size" id="size" value="12X18">12X18</label>
                    <label><input type="radio" name="size" id="size" value="13X19">13X19</label>
                    <label><input type="radio" name="size" id="size" value="12X25">12X25</label>
                    
                </td>
            </tr>
            <tr>
            	<td align="right">Sheet Qty:</td>
            	<td>
                	<input type="text" name="sheet_qty" id="sheet_qty" value="1">
            	</td>
            </tr>
            <tr>
            	<td align="right">Size/Tukda:</td>
            	<td>
                	<input type="text" name="size_info" id="size_info" value="1/">
            	</td>
            </tr>
            <tr id="popup_printing">
                <td align="right">Printing:</td>
                <td class="pRadioBtn">
                    <label>
                        <input type="radio" class="single_side" id="printing" name="printing" value="SS">Single Side
                    </label>
                    <label>
                    <input type="radio" class="double_side" id="printing" name="printing" value="FB">
                        Double Side
                    </label>
                </td>
            </tr>

            <tr id="box_dubby">
                <td align="right">Box ( Dubby or Box ):</td>
                <td>
                	<label>
                		Dubby : 
                	    <input type="checkbox" class="box_dubby"  name="c_box_dubby" id="c_box_dubby" value="Yes">Yes
                	</label>
                		&nbsp;&nbsp;&nbsp;&nbsp;
                		&nbsp;&nbsp;&nbsp;&nbsp;
                	<label>
                		Box : 
                	    <input type="checkbox" class="box_box"  name="c_box_box" id="c_box_box" value="Yes">Yes
                	</label>
                	
                	<!-- <input type="text" name="c_corner" id="c_corner"> -->
                </td>
            </tr>

            <tr id="popup_cornercutting">
                <td align="right">Corner Cutting :</td>
                <td>
                	<label>
                	    <input type="radio" checked="checked" class="corner_cutting_no"  name="c_corner" id="c_corner" value="No">No
                	</label>
                	<label>
                	<input type="radio" class="corner_cutting_yes"  name="c_corner" id="c_corner" value="Yes">
                	    Yes
                	</label>
                	<!-- <input type="text" name="c_corner" id="c_corner"> -->
                </td>
            </tr>
            <tr class="corner-cut-details">
                <td align="right">Corner Cutting Die No. :</td>
                <td>
	                <select class="form-control" name="c_cornerdie" id="c_cornerdie">
	                	<option value="3">3</option>
	                	<option value="1">1</option>
	                	<option value="2">2</option>
	                	<option value="3">3</option>
	                	<option value="4">4</option>
	                	<option value="5">5</option>
	                	<option value="6">6</option>
	                	<option value="7">7</option>
	                </select>
                    <!-- <input type="text" name="c_cornerdie" id="c_cornerdie"> -->
                </td>
            </tr>
            <tr  class="corner-cut-details">
                <td align="right">Round Cutting Side:</td>
                <td>
                	<select class="form-control" name="c_rcorner" id="c_rcorner">
                		<option value="4">4</option>
                		<option value="1">1</option>
                		<option value="2">2</option>
                		<option value="3">3</option>
                	</select>
                    <!-- <input type="text" name="c_rcorner" id="c_rcorner"> -->
                </td>
            </tr>
            <tr id="popup_lasercutting">
                <td align="right">Laser Cutting :</td>
                <td>
                    <input type="text" name="c_laser" id="c_laser">
                </td>
            </tr>
            <tr id="popup_lamination">
                <td align="right">Lamination:</td>
                <td>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="SS">Single
                    </label>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="FB">Double
                    </label>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="POUCH">POUCH
                    </label>
                    <label>
                        <input type="radio" id="lamination" name="lamination" value="N/A">N/A
                    </label>
                    <input type="text" name="lamination_info" id="lamination_info">
                </td>
            </tr>
            <tr id="popup_lamination_cutting">
                <td align="right"><strong>Lamination Cutting:</strong></td>
                <td>
                	<br />
                    <select id="c_lamination_cutting" name="c_lamination_cutting" class="form-control inline">

                    	<option value="1">Yes</option>
                    	<option value="0">No</option>
                    </select>
                    <hr />
                </td>
            </tr>
            <tr id="popup_binding">
				<td align="right">Binding</td>
				<td>
					<label><input type="checkbox" name="binding" value="Creasing">Creasing</label>
					<label><input type="checkbox" name="binding" value="Center Pin">Center Pin</label>
					<label><input type="checkbox" name="binding" value="Perfect Binding">Perfect Binding</label>
					<label><input type="checkbox" name="binding" value="Perforation">Perforation</label>
					<label><input type="checkbox" name="binding" value="Folding">Folding</label>
                    <label><input type="checkbox" name="binding" value="Half Cutting">Half Cutting</label>
					<label><input type="checkbox" name="binding" value="Full & Half Cutting">Full & Half Cutting</label>
                    <label><input type="checkbox" name="binding" value="Spiral">Spiral</label>
                    <label><input type="checkbox" name="binding" value="Wiro">Wiro</label>
					<br>
					Half Cutting Details: <br /><input type="text" name="binding_info" id="binding_info">
					<br>
					Half Cutting Blades:<input type="number" style="width: 80px;" name="blade_per_sheet" id="blade_per_sheet">
				</td>
            </tr>
                        <!--<tr>
				<td align="right">Checking:</td>
                <td>
					<label><input type="radio" name="checking" value="Paper">Paper</label>
                    <label><input type="radio" name="checking" value="Printing">Printing</label>
                </td>
            </tr>-->
            <tr>
                <td align="right">Details:</td>
                <td>
                    <textarea name="details" id="details" rows="4" cols="40"></textarea>
                </td>
            </tr>
            
            <tr id="popup_packing">
                <td align="right">Packing:</td>
                <td>
                    <label><input type="radio" id="packing" name="packing" value="Paper">Paper</label>
                    <label><input type="radio" id="packing" name="packing" value="Loose">Loose</label>
                    <label><input type="radio" id="packing" name="packing" value="Plastic Bag">Plastic Bag</label>
                    <label><input type="radio" id="packing" name="packing" value="Letter Head">Letter Head</label>
                    <label><input type="radio" id="packing" name="packing" value="Parcel">Parcel</label>
                </td>
            </tr>

            
            <tr>
                <td colspan="2" align="center">
                    <input type="hidden" name="fancybox_cutting_id" value="" id="fancybox_cutting_id">
                    <span class="btn btn-primary btn-sm" onclick="set_cutting_details_box()">Save</span>
                    <span class="btn btn-primary btn-sm" onclick="set_cutting_details_boxAndOut()">Save & Outside</span>
                </td>
            </tr>
        </table>
    </div>
    </form>
</div>


<div id="fancy_box_demo_paper_only" style="width:100%;display: none;">
	<div style="width: 100%; margin: 0 auto; padding: 10px 0 10px;">
		<input type="hidden" name="fancybox_id" id="fancybox_id">
        <ul class="tabs" data-persist="true" id="tabs">
            <li class="paper-tab-header"><a href="#paper_tab">Paper</a></li>
        </ul>
        <div class="tabcontents">
			<div id="paper_tab" class="test">
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
        </div>
    </div>
</div>

<div id="fancy_box_demo_card_only" style="width:100%;display: none;">
	<div style="width: 100%; margin: 0 auto; padding: 10px 0 10px;">
		<input type="hidden" name="fancy_box_demo_card_only_id" id="fancy_box_demo_card_only_id">
        <ul class="tabs" data-persist="true" id="tabs">
            <li class="gsm-tab-header"><a href="#view2">300/350 GSM Matt/Gloss Card</a></li>
            <li class="exlusive-tab-header"><a href="#view3">Exclusive Visiting Cards</a></li>
            <li class="transparent-tab-header"><a href="#view4">Transparent & White with Multi Color Printing</a></li>
        </ul>
        <div class="tabcontents">
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
jQuery(".setCuttingAuto").on('click', function()
{
	jQuery("#lamination_info").val('');
	alert("Do you want Corner Cutting ?");
	 var sizeInfo 		= jQuery(this).attr("data-size-info"),
		currentIndex 	= jQuery("#fancybox_cutting_id").val(),
		 details  		= jQuery("#details_"+currentIndex).val(),
		 side 			= jQuery(this).attr("data-side");
	 
	 jQuery('input:radio[class=single_side]').prop('checked', true);
	 
	 jQuery("#size_info").val(sizeInfo);
	 jQuery("#details").val(details);
	 
	 if(side == 1 )
	 {
		 var singleHtml = '<label><input type="radio" class="single_side" id="printing" checked="checked" name="printing" value="SS">Single Side</label><label><input type="radio" class="double_side" id="printing" name="printing" value="FB">Double Side</label>';
		 jQuery(".pRadioBtn").html(singleHtml);
	 }
	 
	 if(side == 2 )
	 {
		 var singleHtml = '<label><input type="radio" class="single_side" id="printing" name="printing" value="SS">Single Side</label><label><input type="radio" class="double_side" checked="checked"  id="printing" name="printing" value="FB">Double Side</label>';
		 jQuery(".pRadioBtn").html(singleHtml);
	 }
	 
	 
});

function saveOffsetJob()
{
	
}
</script>
<?php 
for($i=1;$i<6;$i++) { ?>
<div style="display:none;">
    <input type="text" name="c_machine_<?php echo $i;?>" id="c_machine_<?php echo $i;?>">
    <input type="text" name="c_qty_<?php echo $i;?>" id="c_qty_<?php echo $i;?>">
    <input type="text" name="c_material_<?php echo $i;?>" id="c_material_<?php echo $i;?>">
    <input type="text" name="c_size_<?php echo $i;?>" id="c_size_<?php echo $i;?>">
    <input type="text" name="c_details_<?php echo $i;?>" id="c_details_<?php echo $i;?>">
    <input type="text" name="c_lamination_<?php echo $i;?>" id="c_lamination_<?php echo $i;?>">
    <input type="text" name="c_packing_<?php echo $i;?>" id="c_packing_<?php echo $i;?>">
    <input type="text" name="c_print_<?php echo $i;?>" id="c_print_<?php echo $i;?>">
    <input type="text" name="c_laminationinfo_<?php echo $i;?>" id="c_laminationinfo_<?php echo $i;?>">
    <input type="text" name="c_sizeinfo_<?php echo $i;?>" id="c_sizeinfo_<?php echo $i;?>">
    <input type="text" name="c_sheetinfo_<?php echo $i;?>" id="c_sheetinfo_<?php echo $i;?>">
    <input type="text" name="c_bindinginfo_<?php echo $i;?>" id="c_bindinginfo_<?php echo $i;?>">
    
    
    <input type="text" name="c_blade_per_sheet_<?php echo $i;?>" id="c_blade_per_sheet_<?php echo $i;?>">
    <input type="text" name="c_binding_<?php echo $i;?>" id="c_binding_<?php echo $i;?>">
    <input type="text" name="c_checking_<?php echo $i;?>" id="c_checking_<?php echo $i;?>">
    <input type="text" name="c_corner_<?php echo $i;?>" id="c_corner_<?php echo $i;?>">
    <input type="text" name="c_laser_<?php echo $i;?>" id="c_laser_<?php echo $i;?>">
    <input type="text" name="c_rcorner_<?php echo $i;?>" id="c_rcorner_<?php echo $i;?>">
    

    <input type="text" name="c_lamination_cutting_<?php echo $i;?>" id="c_lamination_cutting_<?php echo $i;?>">


    <input type="text" name="c_cornerdie_<?php echo $i;?>" id="c_cornerdie_<?php echo $i;?>">

    <input type="text" name="c_box_dubby_<?php echo $i;?>" id="c_box_dubby_<?php echo $i;?>">
    <input type="text" name="c_box_box_<?php echo $i;?>" id="c_box_box_<?php echo $i;?>">

</div>
<?php } ?>


<!-- MOdal BOx for Bills -->
<div id="offsetModalPopup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Offset</h4>
      </div>
      <div class="modal-body">
			<div class="col-md-3">
					Printing Paper : 
			</div>
			<div class="col-md-9">
				<textarea name="off_printing_paper" id="off_printing_paper" class="form-control"></textarea>
			</div>
			
			<br>
			<div class="clearfix"></div>
			
			
			<div class="col-md-3">
				Printing : 
			</div>
			<div class="col-md-9">
				<textarea name="off_printing" id="off_printing" class="form-control"></textarea>
			</div>
			
			<br>
			<div class="clearfix"></div>
			
			
			<div class="col-md-3">
				Binding : 
			</div>
			<div class="col-md-9">
				<textarea name="off_printing_binding" id="off_printing_binding"  class="form-control"></textarea>
			</div>
			
			<div class="col-md-3">
				Numbering : 
			</div>
			<div class="col-md-9">
				<textarea name="off_printing_numbering"  id="off_printing_numbering"  class="form-control"></textarea>
			</div>
			
			<div class="col-md-3">
				Delivery Time : 
			</div>
			<div class="col-md-9">
				<textarea name="off_printing_timing" id="off_printing_timing"  class="form-control"></textarea>
			</div>
      </div>
      <div class="modal-footer">
		<input type="text" name="offset_job_id" id="offset_job_id">
		  <button type="button" class="btn btn-primary" onclick="saveOffsetJob()">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php
require_once('out-station.php');
?>

<script type="text/javascript">

	jQuery(".corner-cut-details").hide();

	$('.corner_cutting_yes').on('ifChanged', function(event){
	    if(this.checked) // if changed state is "CHECKED"
	    {
	    	jQuery(".corner-cut-details").show();
	        console.log('YEs');
	    }
	    else
	    {
	    	jQuery(".corner-cut-details").hide();
	      console.log('NO');
	    }
	});

function showPaytmId()
{
    jQuery("#paytm_id").hide();
    
    if(jQuery("#pay_type").val()  == 'Paytm')
    {
        jQuery("#paytm_id").show();
    }
}    

function resetCuttingForm()
{
    console.log("RESET FORM");
    $("#fancyBoxCuttingForm").trigger("reset");
    $('#fancyBoxCuttingForm :radio').iCheck('uncheck');
    $('#fancyBoxCuttingForm :checkbox').iCheck('uncheck');
    $("#details").val('');
}
</script>