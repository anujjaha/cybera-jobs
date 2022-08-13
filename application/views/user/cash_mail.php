<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<h3>
		Cash Receipt : <?php echo date('d-m-Y');?>
	</h3>
	</div>
</div>


<div class="box">
	<h3>Today Jobs</h3>
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped" style="border: 2px solid;">
		<thead>
		<tr>
		<th style="border: 1px solid;">Sr</th>
		<th style="border: 1px solid;">Job Id</th>
		<th style="border: 1px solid;">Company Name</th>
		<th style="border: 1px solid;">Job Title</th>
		<!-- <th style="border: 1px solid;">Customer Name</th> -->
		<th style="border: 1px solid;">Amount</th>
		<th style="border: 1px solid;">Credit</th>
		<th style="border: 1px solid;">Reciepts</th>
		<th style="border: 1px solid;">Cash</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$total = 0 ;
		$totalCredit = 0 ;
		$totalCash = 0 ;
		foreach($results as $result) {
			$cash = '';

			if($result['job_id'] == '30063')
			{
			//	pr($result);
			}
		?>
		<tr>
		<td  style="border: 1px solid;"><?php echo $sr;?></td>
		<td  style="border: 1px solid;"><?php echo $result['job_id'];?></td>
		<td  style="border: 1px solid;"><?php echo $result['companyname'];?></td>
		<td  style="border: 1px solid;"><?php echo $result['jobname'];?></td>
		<!-- <td  style="border: 1px solid;"><?php echo $result['customername'];?></td> -->
		<td width="100" align="right"  style="border: 1px solid;"><?php echo number_format($result['amount'], 2);?></td>
		<td  width="100" align="right" style="border: 1px solid;"><?php echo number_format($result['totalCredit'], 2);?></td>
		<td style="border: 1px solid;">
			<?php
				$receiptShow = !empty($result['receipts']) ? $result['receipts'] : '';

				if(strlen($receiptShow) > 2)
				{
					$receiptShow = explode(",", $receiptShow);

					if($receiptShow[0] == '')
					{
						unset($receiptShow[0]);
						$printReceipt = implode(",", $receiptShow);
						echo $printReceipt;
						$cash = $result['totalCredit'];
					}
					else
					{
						echo $result['receipts'];
						$cash = $result['totalCredit'];
					}
				}
			?>

			</td>
			<td width="100" align="right"  style="border: 1px solid;">
				<?php 
					if($cash != '' && !strpos($result['receipts'], 'PAYTM') !== false
						&& $result['receipts'] != 'PAYTM'
						)
					{
						$totalCash = $totalCash + $cash;
						echo number_format($cash, 2);
					}
				?>
				</td>
		</tr>
		<?php 
			$sr++; 
			$total = $total + $result['amount'];
			$totalCredit = $totalCredit + $result['totalCredit'];
		}
		?>
	</tbody>
	<tfoot>
		<td style="border: 2px solid;" colspan="5" align="right"><?php echo number_format($total, 2);?></td>
		<td style="border: 2px solid;" align="right"><?php echo number_format($totalCredit, 2);?></td>
		<td style="border: 2px solid;"  colspan="1" align="right">&nbsp;</td>
		<td style="border: 2px solid;" align="right"><?php echo number_format($totalCash, 2);?></td>
	</tfoot>
	</table>
	</div>
</div>

<div class="box">
	<h3>Direct Cash</h3>
		<div class="box-body table-responsive">
		<table id="example2" class="table table-bordered table-striped" style="border: 2px solid;">
		<thead>
		<tr>
		<th style="border: 1px solid;">Sr</th>
		<th style="border: 1px solid;">Company Name</th>
		<th style="border: 1px solid;">Reference</th>
		<th style="border: 1px solid;">Credited By</th>
		<th style="border: 1px solid;">Receipt</th>
		<th style="border: 1px solid;">Amount</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$total = 0 ;
		
		foreach($directCash as $direct) {

			$cash = '';
		?>
		<tr>
		<td  style="border: 1px solid;"><?php echo $sr;?></td>
		<td  style="border: 1px solid;"><?php echo $direct['companyname'];?></td>
		<td style="border: 1px solid;">
		<?php
			if(!empty($direct['other']))
			{
				echo $direct['other'];	
			}
			else if(!empty($direct['pay_ref']))
			{
				echo $direct['pay_ref'];	
			}
			else if(!empty($direct['notes']))
			{
				echo $direct['notes'];	
			}
		?>
		</td>
		<td style="border: 1px solid;"><?php echo $direct['nickname'];?></td>
		<td style="border: 1px solid;"><?php echo $direct['receipt'] ? $direct['receipt'] : '-';?></td>
		<td width="100" align="right"  style="border: 1px solid;"><?php echo number_format($direct['directCredit'], 2);?></td>
		<?php 
			$sr++; 
			$total = $total + $direct['directCredit'];
		}
		?>
	</tbody>
	<tfoot>
		<td style="border: 2px solid;" colspan="6" align="right"><?php echo number_format($total, 2);?></td>
	</tfoot>
	</table>
	</div>
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
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                });
            });
            

        </script>

