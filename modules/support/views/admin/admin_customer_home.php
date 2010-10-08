<?php print displayStatus();?>
<h2><?php echo $title;?></h2>

<?php
foreach ($customer_details as $detail){
echo "<p>";
echo anchor("support/admin/enter_newcredit/".$detail['user_id'], "Enter New Credits");
echo "<br />";
echo anchor("support/admin/enter_workdone/".$detail['user_id'], "Enter Work Done");
echo "<br /></p>";


/* Display the customer details */
echo "<h4>Company Name: ".$detail['company_name']."</h4>";
echo "<h4>Customer Name: ".$detail['full_name']."</h4>";
echo "<h4>Web Address: ".$detail['web_address']."</h4>";
echo "+++++++++++++++++++++++";
}
/*
 This is how CI display flash data. but we don't use it. 

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
*/
	echo "<h4>Total time spent: ".$totaltime."</h4>";
	echo "<h4>Total credit purchased: ".$totalcredit."</h4>";
	echo "<h4>Total Points/Time Left: ".$total."</h4>";
	echo "<h4>Support Details</h4>";
// print_r ($customer_records);
if (count($customer_records)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>By</th>\n<th>Date</th><th>Time</th><th>Point Credit</th><th>Note</th><th>Details</th><th>Action</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($customer_records as $list){
		// print_r ($total);
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$list['by']."</td>\n";
		echo "<td>".$list['date']."</td>\n";
		
		echo "<td>".$list['time']. "</td>";
		echo "<td>".$list['point_credit']. "</td>";
		echo "<td>".$list['note']. "</td>";
		echo "<td>";
		echo anchor('support/admin/details/'.$list['id'],'Details');
		echo "</td>";
		echo "<td>";
		echo anchor('support/admin/update_record/'.$list['id'],'edit');
		echo " | ";
		foreach ($customer_details as $detail)
		echo anchor('support/admin/delete_record/'.$detail['user_id']."/".$list['id'],'delete');
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";

}


?>