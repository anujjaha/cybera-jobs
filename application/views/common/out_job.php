<div style="width: 570px;">
<h1><center><?= $jobInfo->location_name;?></center></h1>

<table align="center" border="2" style="border: solid 2px black;" width="100%">
<tr>
    <td style="border: solid 1px; width: 33%; padding: 10px; font-weight: bold; font-size: 22px;" > 
        Job Id: <?= $jobInfo->job_id;?>
    </td>
    <td style="border: solid 1px; width: 33%; padding: 10px; font-weight: bold; font-size: 22px;" > 
        Person: <?= $jobInfo->person;?>
    </td>
    <td style="text-align: right; border: solid 1px; width: 33%; padding: 10px; font-weight: bold; font-size: 22px;" > 
        <?= date('H:i a', strtotime($jobInfo->created_at));?>
    </td>
</tr>

<tr>
<td colspan="3">
<table align="center" style="border: solid 1px black;" width="100%">
    <tr>
        <td width="8%" style="text-align: center; font-size: 20px; border: solid 1px; padding: 10px;" >Location</td>
        <td width="7%" style="text-align: center; font-size: 20px; border: solid 1px; padding: 10px;" >Size</td>
        <td width="15%" style="text-align: center; font-size: 20px; border: solid 1px; padding: 10px;" >Type</td>
        <td width="15%" style="text-align: center; font-size: 20px; border: solid 1px; padding: 10px;" >Side</td>
        <td width="15%" style="text-align: center; font-size: 20px; border: solid 1px; padding: 10px;" >Qty(Sheets)</td>
        <td width="40%" style="text-align: center; font-size: 20px; border: solid 1px; padding: 10px;" >Notes</td>
    </tr>
    <?php
    foreach($jobDetails as $job)
    {
    ?>
        <tr>
            <td style="font-size: 14px; text-align: center; padding: 2px; font-weight: bold; border: solid 1px;" ><?= $job['out_location'];?></td>
            <td style="font-size: 14px; text-align: center; padding: 2px; font-weight: bold; border: solid 1px;" ><?= $job['out_size'];?></td>
            <td style="font-size: 14px; text-align: center; padding: 2px; font-weight: bold; border: solid 1px;" ><?= $job['out_type'];?></td>
            <td style="font-size: 14px; text-align: center; padding: 2px; font-weight: bold; border: solid 1px;" ><?= $job['out_side'];?> SIDE</td>
            <td style="font-size: 14px; text-align: center; padding: 2px; font-weight: bold; border: solid 1px;" ><?= $job['out_qty'];?></td>
            <td style="font-size: 14px; text-align: center; padding: 2px; font-weight: bold; border: solid 1px;" ><?= $job['out_notes'];?></td>
        </tr>   
    <?php
    }
    ?>
</table>
</td>
</tr>
</table>
</div>