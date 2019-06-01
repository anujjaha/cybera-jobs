<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>


<div class="row">
		<div class="form-group" style="margin-bottom: 50px;">
			<form action="<?php echo site_url();?>/employee/overview" method="POST" class="form-horizontal">
				<div class="col-md-2">
					Start Date :
				</div>
				<div class="col-md-3">
					 <input type="text" value="<?php echo isset($startDate) ? $startDate : date('m/d/Y', strtotime('first day of january this year')) ?>" name="start_date" class="form-control date-picker">
				</div>

				<div class="col-md-2">
					End Date :
				</div>
				<div class="col-md-3">
					<input type="text" value="<?php echo isset($endDate) ? $endDate : date('m/d/Y', strtotime('last day of december this year')) ?>" name="end_date" class="form-control date-picker">
				</div>
				<div class="col-md-2">
					<input type="submit" name="Filter" class="btn btn-primary">
				</div>
			</form>
		</div>
		<?php
			$employees = getEmployeeDetails($startDate, $endDate);
			foreach($employees as $emp)
			{
		?>
				<div class="col-md-4 overview-container">
					<div class="upper-half">
						<div>
							<strong><?php echo $emp->name;?></strong>
							<div class="pull-right">
								Dept: <?php echo $emp->department;?>
							</div>
						</div>

						<div>
							Join Date: <?php echo date('m/d/Y', strtotime($emp->join_date));?>
							<div class="pull-right">
								Blod Group: <?php echo $emp->bgroup;?>
							</div>
						</div>

						<div>
							Mobile: <?php echo $emp->mobile;?>
							<div class="pull-right">
								Other Mobile: <?php echo $emp->altercontactnumber;?>
							</div>
						</div>
						<div>
							Address: <?php echo $emp->address;?>
						</div>
					</div>
					<hr>
					<div class="lower-half">
						<div>
							Full Half Day: <?php echo $emp->total_full_day;?>
							<div class="pull-right">
								Half Day: <?php echo $emp->total_half_day;?>
							</div>
						</div>
						
						<div>
							Total Office Half Day: <?php echo $emp->total_office_halfday;?>
							<div class="pull-right">
								Total Office Late: <?php echo $emp->total_office_late;?>
							</div>
						</div>

						<div>
							Full Night: <?php echo $emp->total_full_night;?>
							<div class="pull-right">
								Half Night: <?php echo $emp->total_half_night;?>
							</div>
						</div>
					</div>
					
					<div class="text-center">
						<a href="javascript:void(0);" data-name='<?php echo $emp->name;?>' data-id="<?php echo $emp->emp_id;?>" class="btn btn-primary open-modal">
							View
						</a>
					</div>
				</div>
		<?php
			}
		?>

	
		
</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script>
jQuery(document).ready(function()
{
	jQuery('.date-picker').datepicker();
});
</script>


<!-- Trigger/Open The Modal -->
<button id="myBtn">Open Modal</button>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <div class="container">
      <h2 id="popup-name"></h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Basic Details</a></li>
        <li><a data-toggle="tab" href="#menu1">Attendance</a></li>
        <li><a data-toggle="tab" href="#menu2">Finance / Transactions</a></li>
        <li><a data-toggle="tab" href="#menu3">Other</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          	<h3>Basic Details</h3>
   			<table class="example1 table table-bordered table-striped">
   				<tr>
   					<td>
   						Name: <span id="basic-name"></span>
   					</td>

   					<td>
   						Mobile: <span id="basic-mobile"></span>
   					</td>
   				</tr>

   				<tr>
   					<td>
   						Department: <span id="basic-department"></span>
   					</td>

   					<td>
   						Join Date: <span id="basic-join-date"></span>
   					</td>
   				</tr>
				
				<tr>
   					<td>
   						Blood Group: <span id="basic-bgroup"></span>
   					</td>

   					<td>
   						Birth Date : <span id="basic-join-date"></span>
   					</td>
   				</tr>

   				<tr>
   					<td>
   						Alternate Contact Name: <span id="basic-acontact-name"></span>
   					</td>

   					<td>
   						Alternate Contact Number : <span id="basic-acontact-number"></span>
   					</td>
   				</tr>


   			</table>

        </div>
        <div id="menu1" class="tab-pane fade">
          <h3>Menu 1</h3>
          <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="menu2" class="tab-pane fade">
          <h3>Menu 2</h3>
          <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>
        <div id="menu3" class="tab-pane fade">
          <h3>Menu 3</h3>
          <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
        </div>
      </div>
    </div>

  </div>

</div>

<script>
function popUpRenderBasic(empId)
{
	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/getEmployeeBasicDetails",
		method: 'POST',
		dataType: 'JSON',
		data: {
			empId: empId
		},
		success: function(data)
		{
			if(data.status == true)
			{
				document.getElementById('basic-name').innerHTML = data.result.name;
				document.getElementById('basic-mobile').innerHTML = data.result.mobile;
				document.getElementById('basic-department').innerHTML = data.result.department;
				document.getElementById('basic-join-date').innerHTML = data.result.join_date;
				document.getElementById('basic-bgroup').innerHTML = data.result.bgroup;
				document.getElementById('basic-acontact-name').innerHTML = data.result.altercontactname;
				document.getElementById('basic-acontact-number').innerHTML = data.result.altercontactnumber;

				return;
			}

			alert(data.message);
			console.log(data);
		},
		error: function(data)
		{
			alert(data.message);
		}
	});
}

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


var elements = document.querySelectorAll('.open-modal');

if(elements)
{
	for(var i = 0; i < elements.length; i++)
	{
		elements[i].onclick = function(e) {
			document.getElementById('popup-name').innerHTML = e.target.getAttribute('data-name');

			var empId = e.target.getAttribute('data-id');

			popUpRenderBasic(empId);

			modal.style.display = "block";
		}
	}
}

// When the user clicks the button, open the modal 
/*btn.onclick = function() {
  modal.style.display = "block";
}*/

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

