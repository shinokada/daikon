<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<p>
<?php
echo "Hello ". ucwords ($username). "!";
?>
</p>
<?php

echo "<h3>Total time spent: ".$totaltime['time']."</h3>";
echo "<h3>Total credit purchased: ".$totalcredit['point_credit']."</h3>";
echo "<h3>Total Points/Time Left: ".$total."</h3>";
echo "<h4>Support Details</h4>";

if (count($customer_records)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>By</th>\n<th>Date</th><th>Time</th><th>Point Credit</th><th>Note</th><th>Details</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($customer_records as $list){
		// print_r ($total);
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$list['by']."</td>\n";
		echo "<td>".$list['date']."</td>\n";
		
		echo "<td>".$list['time']. "</td>";
		echo "<td>".$list['point_credit']. "</td>";
		echo "<td>".$list['note']. "</td>";
		echo "<td><a href=\"admin/details/".$list['id']. "\">Details</a></td>";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
	
}

?>