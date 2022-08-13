<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<center>
	<h1><a href="<?php echo base_url();?>">Dashboard</a></h1>
</center>

<script type="text/javascript">
	$(document).ready(function() 
    {
    	bindOpenPopupBox();
    });


function bindOpenPopupBox()
{
	if(window.location.search.includes("menuEstimate"))
	{
		openPopupBoxGEstimate();
	}
}

</script>