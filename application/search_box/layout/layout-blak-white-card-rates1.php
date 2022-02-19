<style>
.gsm300
{
	background-color:red !important;
	border-color:red !important;
}
.Vcard_active {
	font-size:30px;
}
</style>

<form action="#" method="post" onsubmit="return saveVCardEx();">
<table class="table" border="2">
	<tr>
		<td> &nbsp; </td>
		<td colspan="2" align="center">Metalic Color Card
			<br>
			<!--<strong>Code 01 to 31</strong>-->
		 </td>
		<td colspan="2" align="center">Black Craft Card 
			<br>
			<!--<strong>Code 32 to 70</strong>-->
		</td>
	</tr>
	
	<tr>
		<td> Qty </td>
		<td> Single Side </td>
		<td> Double Side </td>
		
		<td> Single Side </td>
		<td> Double Side </td>
		
		</tr>
	
	<tr class="rowQty-ex" id="qty_96">
		<td>
			<a href="javascript:void(0);" class="btn btn-primary setVQty-ex" onclick="setQtyEx(96);">
				96
			</a> 
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="500" data-card="Metalic_Color_Card" data-type="SS">
				500
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="850" data-card="Metalic_Color_Card" data-type="FB">
				850
			</span>
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="700" data-card="Black/Craft_Card" data-type="SS">
				700
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="1050" data-card="Black/Craft_Card" data-type="FB">
				1050
			</span>
		</td>
		
	</tr>
	
	<tr  class="rowQty-ex" id="qty_192">
		<td>
			<a href="javascript:void(0);" class="btn btn-primary setVQty-ex" onclick="setQtyEx(192);">
				192
			</a>
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="850" data-card="Metalic_Color_Card" data-type="SS">
				850
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="1500" data-card="Metalic_Color_Card" data-type="FB">
				1500
			</span>
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="1050" data-card="Black/Craft_Card" data-type="SS">
				1050
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="1800" data-card="Black/Craft_Card" data-type="FB">
				1800
			</span>
		</td>
	</tr>
	
	<tr  class="rowQty-ex" id="qty_288">
		<td> 
			<a href="javascript:void(0);" class="btn btn-primary setVQty-ex" onclick="setQtyEx(288);">
				288
			</a> 
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="1150" data-card="Metalic_Color_Card" data-type="SS">
				1150
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="2000" data-card="Metalic_Color_Card" data-type="FB">
				2000
			</span>
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="1800" data-card="Black/Craft_Card" data-type="SS">
				1800
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="2500" data-card="Black/Craft_Card" data-type="FB">
				2500
			</span>
		</td>
	</tr>
	
	<tr  class="rowQty-ex" id="qty_500">
		<td> 
			<a href="javascript:void(0);" class="btn btn-primary setVQty-ex" onclick="setQtyEx(500);">
				500
			</a> 
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="1900" data-card="Metalic_Color_Card" data-type="SS">
				1900
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="3400" data-card="Metalic_Color_Card" data-type="FB">
				3400
			</span>
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="2700" data-card="Black/Craft_Card" data-type="SS">
				2700
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="4100" data-card="Black/Craft_Card" data-type="FB">
				4100
			</span>
		</td>
	</tr>
	
	<tr  class="rowQty-ex"  id="qty_1000">
		<td> 
			<a href="javascript:void(0);" class="btn btn-primary setVQty-ex" onclick="setQtyEx(1000);">
				1000
			</a> 
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="3500" data-card="Metalic_Color_Card" data-type="SS">
				3500
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary etc" data-price="6100" data-card="Metalic_Color_Card" data-type="FB">
				6100
			</span>
		</td>
		
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="5000" data-card="Black/Craft_Card" data-type="SS">
				5000
			</span>
		</td>
		<td> 
			<span class="price-ex btn btn-primary ptc" data-price="6500" data-card="Black/Craft_Card" data-type="FB">
				6500
			</span>
		</td>
	</tr>
</table>

<table class="table" border="2">
	<tr>
		<td> Qty : <span id="show_v_card_qty-bw"></span>
			<input type="hidden" id="v_card_qty-bw" name="v_card_qty-bw">
			<input type="hidden" id="original_v_card_qty-bw" name="original_v_card_qty-bw">
			</td>
			
		<td> Paper Type : <span id="show_v_card_type-bw"></span>
			<input type="hidden" id="v_card_type-bw" name="v_card_type-bw">
		</td>
		<td> Estimate : <span id="show_v_card_price-bw"></span>
			<input type="hidden" name="v_card_price-bw" id="v_card_price-bw">
			<input type="hidden" id="original_v_card_price-bw" name="original_v_card_price-bw">
		</td>
		
		<td> 
			Paper Code : 
			<br>
			<input type="text" id="paper_code-bw" name="paper_code-bw" class="form-control" onblur="setPaperCodeValueEx();"> 
		</td>
		<td> 
			Total Names : 
			<br>
			<input type="text" id="v_card_names-bw" name="v_card_names-bw" class="form-control" value="1" onBlur="updateQtyEx()"> 
		</td>
		<td align="center">
			<input type="hidden" name="paper_side-bw" id="paper_side-bw">
			<input type="hidden" name="original_title-ex" id="original_title-ex">
			<button class="btn btn-primary" onclick="saveVCardEx();">
				Confirm
			</button>
		</td>
	</tr>
</table>
</form>

<script>
jQuery(document).ready(function()
{
	jQuery(".price-ex").css('opacity','0.10');
});

jQuery(".gsmExclusive-ex").on('click', function()
{
		jQuery("#paper_code-bw").focus();
});

jQuery(".gsmEconomy-ex").on('click', function()
{
		jQuery("#paper_code-bw").focus();
});

jQuery(".gsmPremium-ex").on('click', function()
{
		jQuery("#paper_code-bw").focus();
});


jQuery(".price-ex").on('click', function()
{
	jQuery(".price-ex.Vcard_active-ex").removeClass('Vcard_active-ex');
	
	setCardPriceEx(jQuery(this).attr('data-price'));
	jQuery("#original_v_card_price-bw").val(jQuery(this).attr('data-price'));
	
	
	setCardTypeEx(jQuery(this).attr('data-card')+"_"+jQuery(this).attr('data-type'));
	
	jQuery("#original_title-ex").val(jQuery(this).attr('data-card')+"_"+jQuery(this).attr('data-type'));
	
	jQuery("#paper_side-bw").val(jQuery(this).attr('data-type'));
	jQuery(this).addClass("Vcard_active-ex");
	
	resetInputBoxEx();
});


function resetInputBoxEx()
{
	jQuery("#v_card_names-bw").val("1");
	jQuery("#paper_code-bw").val("");
}

function setCardPriceEx(value)
{
	jQuery("#v_card_price-bw").val(value);
	jQuery("#show_v_card_price-bw").html("<h2>"+value+"</h2>");
}

function setCardTypeEx(value)
{
	jQuery("#v_card_type-bw").val("V_Card_"+value);
	jQuery("#show_v_card_type-bw").html("<h2>"+value+"</h2>");
	
}

function setQtyEx(value)
{
	jQuery(".rowQty-ex").css('opacity', "1");
	
	
	jQuery("#qty_"+value+" .price-ex").css('opacity', "1");
	jQuery("#qty_"+value+" .price-ex").css('opacity', "1");
	
	console.log("Element", jQuery("#qty_"+value+" .price"));
	jQuery("#qty_"+value).css('opacity', "1");
	jQuery("#v_card_qty-bw").val(value);
	jQuery("#original_v_card_qty-bw").val(value);
	
	jQuery("#show_v_card_qty-bw").html("<h2>"+value+"</h2>");
}

function getPaperPrintSideEx()
{
	return jQuery("#paper_side-bw").val();
}
function setFinalQtyEx(value)
{
	jQuery("#v_card_qty-bw").val(value);
	jQuery("#show_v_card_qty-bw").html("<h2>"+value+"</h2>");
}

function getCardQtyEx()
{
	return jQuery("#v_card_qty-bw").val();
}

function getCardTypeEx()
{
	var cardType 	= jQuery("#v_card_type-bw").val();
	var paperCode 	= getPaperCodeEx();
	
	
	if(cardType == "V_Card_Code" )
	{
		return "V_Card_Code_"+paperCode;
	}
	
	if(cardType == "V_Card_Code" )
	{
		return "V_Card_Code_"+paperCode;
	}
	
	if(cardType == "V_Card_Code" )
	{
		return "V_Card_Code_"+paperCode;
	}
	
	return jQuery("#v_card_type-bw").val();
}

function getCardPriceEx()
{
	return jQuery("#v_card_price-bw").val();
}

function getCardRateEx()
{
	var cardRate = getCardPriceEx() /getCardQtyEx();
	
	return cardRate;
}

function getPaperCodeEx()
{
	return jQuery("#paper_code-bw").val();
}

function saveVCardEx()
{
	var multiple = 1;
	updateQtyEx();	
	if(jQuery("#v_card_names-bw").val().length > 0 )
	{
		multiple = jQuery("#v_card_names-bw").val();
	}
	
	var id = jQuery("#fancybox_id").val();
	jQuery("#category_" +id).val('Visiting Card');
	
	if(getPaperCodeEx().length > 0 )
	{
		jQuery("#details_" +id).val(getCardTypeEx());
	}
	else
	{
		jQuery("#details_" +id).val(getCardTypeEx());
	}
	
	jQuery("#qty_" +id).val(getCardQtyEx());
	jQuery("#rate_" +id).val(getCardRateEx());
	jQuery("#sub_" +id).val(getCardPriceEx());
	var cardTitle = jQuery("#original_title-ex").val();
	
	/*if(getCardQtyEx() >= 1000 && (cardTitle == "Premium_Texture_Card_FB" || cardTitle == "Premium_Texture_Card_SS" || cardTitle == "Economy_Texture_Card_SS" || cardTitle == "Economy_Texture_Card_FB"))
	{
		var nextId = parseInt(id ) + 1;
		
		jQuery("#details_" +nextId).val("Free Card Holder");
		jQuery("#qty_" +nextId).val(1);
		jQuery("#rate_" +nextId).val(0);
		jQuery("#sub_" +nextId).val(0);
	}*/
	
	jQuery.fancybox.close();
	
	return false;
}

function setPaperCodeValueEx()
{
	/*
	if(jQuery(".Vcard_active-ex").attr("data-card") == "300_GSM_Matt_Card" )
	{
		jQuery("#paper_code-ex").val("");
		return true;
	}
	
	if(jQuery(".Vcard_active-ex").attr("data-card") == "350_GSM_Matt_Card" )
	{
		jQuery("#paper_code-ex").val("");
		return true;
	}
	
	var paperCode = jQuery("#paper_code-ex").val();
	var printSide = getPaperPrintSideEx();
	
	if(jQuery("#v_card_names-ex").length > 0 )
	{
		var originalQty = jQuery("#original_v_card_qty-ex").val();
		var multiple 	= jQuery("#v_card_names-ex").val();
		var finalTitle = "V_Card_Code_"+paperCode+"_"+printSide;
		
		jQuery("#v_card_type-ex").val(finalTitle);
		jQuery("#show_v_card_type-ex").html("<h2>"+finalTitle+"</h2>");
		
		return true;
	}
	
	jQuery("#v_card_type-ex").val("V_Card_Code_"+paperCode+"_"+printSide);
	jQuery("#show_v_card_type-ex").html("<h2>"+"V_Card_Code_"+paperCode+"_"+printSide+"</h2>");
	*/
}

function updateQtyEx()
{
	var multiple = 1;
	
	if(jQuery("#v_card_names-bw").val().length > 0 )
	{
		multiple = jQuery("#v_card_names-bw").val();
	}
	
	setFinalQtyEx(jQuery("#original_v_card_qty-bw").val() * multiple)
	setCardPriceEx(jQuery("#original_v_card_price-bw").val() * multiple);
	
	var cardTitle = jQuery("#original_title-ex").val();
	
	var paperCode = jQuery("#paper_code-bw").val();
	var printSide = getPaperPrintSideEx();
	
	if(jQuery("#paper_code-bw").val() != '' &&  jQuery("#paper_code-bw").val().length > 0) 
	{
		var finalTitle = cardTitle+"_"+paperCode+"_"+jQuery("#original_v_card_qty-bw").val()+"*"+multiple;
		
		setCardTypeEx(finalTitle);
		
		return true;
	}
	
	
	var finalTitle = cardTitle+"_"+jQuery("#original_v_card_qty-bw").val()+"*"+multiple;
	
	setCardTypeEx(finalTitle);
		
	return true;
}
</script>
