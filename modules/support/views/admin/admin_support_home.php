<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<p>
<?php
echo anchor("auth/admin/members/form", "Create new customer");
?>
</p>
<?php

/*
 This is how CI display flash data. but we don't use it. 

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
*/
if (count($support_customers)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>ID</th>\n<th>Company Name</th><th>Customer Name</th><th>User Name</th><th>Web Address</th><th class='middle'>Active</th><th>Actions</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($support_customers as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$list['id']."</td>\n";
		echo "<td><a href=\"admin/customer_record/".$list['id']."\">".$list['company_name']."</a></td>\n";
		
		echo "<td>".$list['full_name']. "</td>";
		echo "<td>".$list['username']. "</td>";
		echo "<td><a href=\"".$list['web_address']."\" target=\"_blank\">".$list['web_address']."</a></td>\n";
		
		$active =  ($list['active']?'tick':'cross');   
		echo '<td class="middle">'.$this->bep_assets->icon($active)."</td>";
		echo "<td>";
		echo anchor('auth/admin/members/form/'.$list['id'],'edit');
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}

