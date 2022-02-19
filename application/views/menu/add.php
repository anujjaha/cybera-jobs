
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" rel="stylesheet"/>
<?php
$this->load->helper('form');
 echo form_open('menu/add');?>
<div class="col-md-12">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Add Menu</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div class="form-group">
			<label>Code</label>
			<input type="text" class="form-control" name="code" id="code" placeholder="Code" value="" required="required">
		</div>

		<div class="form-group">
			<label>Menu Name</label>
			<input type="text" class="form-control" name="title" id="title" placeholder="Title" value="" required="required">
		</div>

		<div class="form-group">
			<label>Qty</label>
			<input type="number" class="form-control" name="qty" id="qty" placeholder="Quantity" value="0" step="1" required="required">
		</div>

		<div class="form-group">
			<label>Rate</label>
			<input type="number" class="form-control" name="price" id="price" placeholder="Price" value="0" step="1" required="required">
		</div>

		<div class="form-group">
			<label>Extra</label>
			<input type="text" class="form-control" name="extra" id="extra" placeholder="Extra Pages" value="" required="required">
		</div>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

<div class="col-md-12">
	<div class="form-group">
			<input type="submit" name="save" class="btn btn-primary btn-flat" value="Save">
		</div>
</div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js" type="text/javascript"></script>

<script>

var options = jQuery('select.select-customer option');
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

	jQuery(document).ready(function()
	{
		jQuery("#customer").select2({
		  allowClear:true,
		  placeholder: 'Select Customer'
		});

		jQuery(".paid-select").on('change', function(element)
		{
			if(jQuery("#paid").val() == 1)
			{
				jQuery("#paidAmountContainer").show();
			}
			else
			{
				jQuery("#paidAmountContainer").hide();
			}
		})
	});

function customer_selected(customer, customerId)
{
	
	var bookTitle = jQuery("#book_title").val();
	
	
	jQuery.ajax({
		 type: "POST",
		 url: "<?php echo site_url();?>/ajax/get_customer_book_info", 
		 data: {
		 	cutomerId: customerId,
		 	bookTitle: bookTitle
		 },
		 dataType: 'JSON',
		 success: 
			function(data)
			{
				if(data.status == true)
				{
					jQuery("#bookMsg").html('Book is Already Delievered !');
					alert("Book Already Delievered !");
					return false;
				}
				else
				{
					jQuery("#bookMsg").html('');
				}
			}
	  });
	console.log(customer, value);
}
</script>
