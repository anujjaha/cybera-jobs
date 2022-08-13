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
					 <input type="text" value="<?php echo isset($startDate) ? $startDate : date('m/d/Y', strtotime('first day of january this year')) ?>" id="start_date" name="start_date" class="form-control date-picker">
				</div>

				<div class="col-md-2">
					End Date :
				</div>
				<div class="col-md-3">
					<input type="text" value="<?php echo isset($endDate) ? $endDate : date('m/d/Y', strtotime('last day of december this year')) ?>" id="end_date"  name="end_date" class="form-control date-picker">
				</div>
				<div class="col-md-2">
					<input type="submit" name="Filter" class="btn btn-primary">
				</div>
			</form>
		</div>
		<?php
			//Convert them to timestamps.
			$date1Timestamp = strtotime($startDate);
			$date2Timestamp = strtotime($endDate);
 			$difference 	= $date2Timestamp - $date1Timestamp;
 			$totalDays 		= round($difference / 86400 );

 			$employees 		= getEmployeeDetails($startDate, $endDate);
			$total  		= 0;
			
			foreach($employees as $temp)
			{

			}
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
							<strong>( <?php echo number_format((($emp->total_full_day * 100 ) / $totalDays ), 2);?> % )</strong>
							<div class="pull-right">
								<strong>Half Day: <?php echo $emp->total_half_day;?>
								( <?php echo number_format((($emp->total_half_day * 100 ) / $totalDays ), 2);?> % )</strong>
							</div>
						</div>
						
						<div>
							T.Office Half Day: <?php echo $emp->total_office_halfday;?>
							<strong>( <?php echo number_format((($emp->total_office_halfday * 100 ) / $totalDays ), 2);?> % )</strong>
							<div class="pull-right">
								T. Office Late: <?php echo $emp->total_office_late;?>
							
							<strong>( <?php echo number_format((($emp->total_office_late * 100 ) / $totalDays ), 2);?> % )</strong>
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

<input type="text" name="active-employee-id" id="active-employee-id">	
		
</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script>
jQuery(document).ready(function()
{
	jQuery('.date-picker').datepicker();
});
</script>

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
          <h3>Attendance</h3>
          <p>Emplyee Attendance <span id="startDateContainerAtt"></span> to <span id="endDateContainerAtt"></span>
          <span class="pull-right btn btn-primary print-report">Print</span>
          </p>

          <table class="example1 table table-bordered table-striped" id="attendanceTable">
          	<tr>
	          	<th>Month</th>
	          	<th>Half Day</th>
				<th>Full Day</th>
				<th>Late</th>
				<th>Office Half Day</th>
				<th>Half Night</th>
				<th>Full Night</th>
				<th>Sunday</th>
				<th>Notes</th>
         	</tr>
          </table>

        </div>
        <div id="menu2" class="tab-pane fade">
          <h3>Transactions</h3>
          <p>Emplyee Transactions <span id="startDateContainerTra"></span> to <span id="endDateContainerTra"></span></p>

          <table class="example1 table table-bordered table-striped" id="transactionTable">
          	<tr>
	          	<th>Credit</th>
	          	<th>Debit</th>
				<th>Self</th>
				<th>Balance</th>
				<th>Salary</th>
				<th>Bonus</th>
				<th>Penalty</th>
				<th>Description</th>
				<th>Notes</th>
         	</tr>
          </table>
        </div>
        <div id="menu3" class="tab-pane fade">
          <h3>Misc</h3>
          <p>N/A</p>
        </div>
      </div>
    </div>

  </div>

</div>

<script>

jQuery('.print-report').on('click', function(e)
{
	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/printEmployeeAttendanceReport",
		method: 'POST',
		dataType: 'JSON',
		data: {
			empId: document.getElementById('active-employee-id').value,
			startDate: document.getElementById('start_date').value,
			endDate: document.getElementById('end_date').value
		},
		success: function(data)
		{
			if(data.status == true)
			{
				window.open(data.result);
			}
			console.log(data);
		},
		error: function(data)
		{
			//alert(data.message);
		}
	});

});

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

function popUpRenderAttendance(empId)
{
	var startDate 	= document.getElementById('start_date').value,
		endDate 	= document.getElementById('end_date').value,
		html 		= '<tr><td>Month</td><td>Half Day</td><td>Full Day</td><td>Office Late</td><td>Office Half Day</td><td>Half Night</td><td>Full Night</td><td>Sunday</td><td>Notes</td></tr>';

	var halfDay 		= 0,
		fullDay 		= 0,
		officeLate 		= 0,
		officeHalfDay 	= 0,
		halfNight 		= 0, 
		fullNight 		= 0,
		sunday 			= 0;

	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/getEmployeeAttendanceDetails",
		method: 'POST',
		dataType: 'JSON',
		data: {
			empId: empId,
			startDate: startDate,
			endDate: endDate
		},
		success: function(data)
		{
			if(data.status == true)
			{
				for(var i = 0; i < data.result.length; i++)
				{
					html += '<tr><td>'+ data.result[i].month +'</td><td>'+ data.result[i].half_day +'</td><td>'+ data.result[i].full_day +'</td><td>'+ data.result[i].office_late +'</td><td>'+ data.result[i].office_halfday +'</td><td>'+ data.result[i].half_night +'</td><td>'+ data.result[i].full_night +'</td><td>'+ data.result[i].sunday +'</td><td>'+ data.result[i].notes +'</td></tr>';
					
					halfDay 		= halfDay + parseInt(data.result[i].half_day);
					fullDay 		= fullDay + parseInt(data.result[i].full_day);
					officeLate 		= officeLate + parseInt(data.result[i].office_late);
					officeHalfDay 	= officeHalfDay + parseInt(data.result[i].office_halfday);
					halfNight 		= halfNight + parseInt(data.result[i].half_night);
					fullNight 		= fullNight + parseInt(data.result[i].full_night);
					sunday 			= sunday + parseInt(data.result[i].sunday);

				}

				html += '<tr><td>-</td><td class="text-bold">'+ halfDay +'</td><td class="text-bold">'+ fullDay +'</td><td class="text-bold">'+ officeLate +'</td><td class="text-bold">'+ officeHalfDay +'</td><td class="text-bold">'+ halfNight +'</td><td class="text-bold">'+ fullNight +'</td><td class="text-bold">'+ sunday +'</td><td>-</td></tr>';
				
				jQuery('#attendanceTable').html(html);

				return;
			}
			else
			{
				jQuery('#attendanceTable').html(data.message);				
			}

			console.log(data);
		},
		error: function(data)
		{
			alert(data.message);
		}
	});
}

function popUpRenderTransactions(empId)
{
	var startDate 	= document.getElementById('start_date').value,
		endDate 	= document.getElementById('end_date').value,
		html 		= '';

	jQuery.ajax({
		url: "<?php echo site_url();?>/ajax/getEmployeeTransactionDetails",
		method: 'POST',
		dataType: 'JSON',
		data: {
			empId: empId,
			startDate: startDate,
			endDate: endDate
		},
		success: function(data)
		{
			if(data.status == true)
			{
				
				for(var i = 0; i < data.result.length; i++)
				{
					html = '';
					html = '<tr><td>'+ data.result[i].amount_added +'</td><td>'+ data.result[i].amount_removed +'</td><td>'+ data.result[i].current_balance +'</td><td>'+ data.result[i].employee_redeem +'</td><td>'+ data.result[i].is_salary +'</td><td>'+ data.result[i].is_bonus +'</td><td>'+ data.result[i].is_penalty +'</td><td>'+ data.result[i].description +'</td><td>'+ data.result[i].notes +'</td></tr>';

					jQuery('#transactionTable').append(html);

				}

				return;
			}
			else
			{
				jQuery('#transactionTable').html(data.message);				
			}

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
			popUpRenderAttendance(empId);
			popUpRenderTransactions(empId);

			document.getElementById('active-employee-id').value = empId;

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

