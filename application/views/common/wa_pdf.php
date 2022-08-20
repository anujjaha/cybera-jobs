<?php
echo $waInfo->customer;
echo "<br/><br/>";
echo $waInfo->title;
echo "<br/><br/>";
echo $waInfo->details;
echo "<br/><br/><br/>";

echo "- PROCESS: " . $waInfo->process . " WORKING ". $waInfo->procsss_time;
echo "<br/>";
echo "- PACKING FORWARDING RS. ". $waInfo->pack_forward;
echo "<br/>";
echo "- TRANSPORTATION BY. ". $waInfo->transport_by . " RS. ".$waInfo->transport_cost;
echo "<br/>";
if($waInfo->gst == 'Extra')
{
    echo "- GST: EXTRA";
}
else if($waInfo->gst > 0)
{
    echo "- GST: ".$waInfo->gst ."% EXTRA";
}
else
{
    echo "- GST: N/A";
}
echo "<br><br>";
echo "TOTAL AMOUNT RS. ".$waInfo->total;
echo "<br/><br/>";
if(isset($waInfo->job_notes) && !empty($waInfo->job_notes))
{
    foreach (explode(',', $waInfo->job_notes) as $value) 
    {
        echo $value. '<br  />';
    }
}

echo "<br>";
echo "NOTE: ". $waInfo->extra_notes;
echo "<br/><br/>";
echo "APPROX DELIVERY: ". $waInfo->approx_delivery_days .' WORKING DAY/S';
?>
<br />
<br />
THANK YOU
<br />
CYBERA PRINT ART 
<br />
<br />
PLEASE FEEL FREE TO CALL FOR MORE CLARIFICATIONS
<br />
<?php
echo "ESTIMATE VALIDITY:". $waInfo->validity_days ." WORKING DAY/S";
?>
<br />
EST-ID-<?=$waInfo->id;?>

