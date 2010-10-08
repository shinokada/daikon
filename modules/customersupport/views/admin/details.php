<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<p>
<?php
echo "Hello ". ucwords ($username). "!";
?>
</p>
<?php

/*
 This is how CI display flash data. but we don't use it. 

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
*/

if (count($details)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>By</th>\n<th>Date</th><th>Time</th><th>Point Credit</th><th>Note</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	
		// print_r ($total);
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$details['by']."</td>\n";
		echo "<td>".$details['date']."</td>\n";
		
		echo "<td>".$details['time']. "</td>";
		echo "<td>".$details['point_credit']. "</td>";
		echo "<td>".$details['note']. "</td>";
		
		echo "</tr>\n";
	
	echo "</tbody>\n</table>";
	echo "<h4>Details</h4>";
	echo $details['details'];
}
?>