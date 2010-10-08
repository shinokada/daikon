<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<?php
/*
 This is how CI display flash data. but we don't use it.

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
*/

/*
 * @ $customers returns user_id, company_name
 * 
 */

echo "<h3 class=\"projectheading\">Company List</h3>";


if (count($customers)){
	echo "<table class='tablesorter middle' border='1' cellspacing='0' cellpadding='3' width='95%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th class=\"left\">Company Name</th><th>Show Project List</th><th>Enter New Project</th><th>Edit Company Details</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($customers as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td class=\"left\">".$list."</td>\n";
                echo "<td><a href=\"../admin/projectlist/".$key."\" >".$this->bep_assets->icon('page_16','Show Project List')."</a></td>\n";
		echo "<td><a href=\"../admin/newproject/".$key."\" >".$this->bep_assets->icon('add_16','Enter New Project')."</a></td>\n";
                echo "<td>";
		echo anchor('auth/admin/members/form/'.$key,$this->bep_assets->icon('pencil','Edit Company Details'));
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}

echo "<h3 class=\"projectheading\">Project Specs by Company</h3>";
if (count($specs)){
        foreach($specs as $companyname => $spec){
            echo "<h4 class=\"companyname\">".$companyname."</h4>";
            echo "<table class='tablesorter middle' border='1' cellspacing='0' cellpadding='3' width='95%'>\n";
           // echo "<thead>\n<tr valign='top'>\n";
           // echo "<th class=\"left\" colspan=6 >".$companyname."</th>";
            //echo "</tr>";
            echo "<tr><th class=\"left\" >Project Name</th>\n<th>Spec Desc</th>\n<th>Edit</th>\n<th class=\"middle\">Completed</th>\n<th class=\"middle\">Active</th>\n</tr>\n</thead>\n<tbody>\n";

            foreach ($spec as $key => $list){
                echo "<tr valign='top'>\n";
                echo "<td class=\"left\" width=\"20%\">".$list['project_name']."</td>\n";
                echo "<td class=\"left\" width=\"40%\">".$list['spec_desc']."</td>\n";
               
                echo "<td width=\"20%\"><a href=\"../admin/adminspec/update_spec/".$list['customer_id']."/"
                .$list['project_id']."/".$list['id']."\" >".$this->bep_assets->icon('pencil','Edit')
                        ."</a></td>\n";
                $completed =  ($list['completed']?'tick':'cross');
		echo '<td width=\"10%\" >'.$this->bep_assets->icon($completed)."</td>\n";
                $active =  ($list['active']?'tick':'cross');
		echo '<td width=\"10%\" >'.$this->bep_assets->icon($active)."</td>\n";
               

                echo "</tr>\n";
            }
            echo "</tbody>\n</table>\n";
	}

    }

echo '$customers<pre>';
print_r($customers);
echo "</pre><br />";


echo '$specs<pre>';
print_r($specs);
echo "</pre><br />";
