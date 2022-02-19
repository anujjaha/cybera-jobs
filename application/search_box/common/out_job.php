<div style="width: 550px; padding: 20px;">
<h5><center><?= $jobInfo->location_name;?></center></h5>

<table align="center" border="2" style="border: solid 2px black;" width="100%">
<tr>
    <td style="border: solid 1px; width: 33%; padding: 5px; font-weight: bold; font-size: 12px;" > 
        Job Id: <?= $jobInfo->job_id;?>
    </td>
    <td style="border: solid 1px; width: 33%; padding: 5px; font-weight: bold; font-size: 12px;" > 
        Person: <?= $jobInfo->person;?>
    </td>
    <td style="text-align: right; border: solid 1px; width: 33%; padding: 5px; font-weight: bold; font-size: 12px;" > 
        <?= date('H:i a', strtotime($jobInfo->created_at));?>
    </td>
</tr>

<tr>
<td colspan="3">
<table align="center" style="border: solid 1px black;" width="100%">
    <tr>
        <td style="width: 20%; text-align: center; font-size: 12px; border: solid 1px; padding: 2px;" >Location</td>
        <td style="width: 10%; text-align: center; font-size: 12px; border: solid 1px; padding: 2px;" >Size</td>
        <td style="width: 10%; text-align: center; font-size: 12px; border: solid 1px; padding: 2px;" >Type</td>
        <td style="width: 10%; text-align: center; font-size: 12px; border: solid 1px; padding: 2px;" >Side</td>
        <td style="width: 10%; text-align: center; font-size: 12px; border: solid 1px; padding: 2px;" >Qty(Sheets)</td>
    </tr>
    <?php
    foreach($jobDetails as $job)
    {
    ?>
        <tr>
            <td style="font-size: 12px; text-align: center; padding: 1px; border: solid 0.2px;" ><?= $job['out_location'];?></td>
            <td style="font-size: 12px; text-align: center; padding: 1px; border: solid 0.2px;" ><?= $job['out_size'];?></td>
            <td style="font-size: 12px; text-align: center; padding: 1px; border: solid 0.2px;" ><?= $job['out_type'];?></td>
            <td style="font-size: 12px; text-align: center; padding: 1px; border: solid 0.2px;" ><?= $job['out_side'];?> SIDE</td>
            <td style="font-size: 12px; text-align: center; padding: 1px; border: solid 0.2px;" ><?= $job['out_qty'];?></td>
            
        </tr>   
        <tr>
            <td  colspan="5" style="font-size: 16px; text-align: center; padding: 2px; border: solid 0.2px;" >Note: <?= $job['out_notes'];?></td>
            </td>
        </tr>
    <?php
    }
    ?>
</table>
</td>
</tr>
</table>
</div>