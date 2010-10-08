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
 * $customers returns user_id, company_name
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
                //echo "<td><a href=\"../admin/projectlist/".$key."\" >".$this->bep_assets->icon('page_16','Show Project List')."</a></td>\n";

                echo "<td>";
                echo anchor('projects/admin/projectlist/'.$key,$this->bep_assets->icon('page_16','Show Porject List'));
                echo "</td>\n";


                //echo "<td><a href=\"../admin/newproject/".$key."\" >".$this->bep_assets->icon('add_16','Enter New Project')."</a></td>\n";

                echo "<td>";
                echo anchor('projects/admin/newproject/'.$key,$this->bep_assets->icon('buttonadd16','Enter Newhow Porject'));
                echo "</td>\n";


                echo "<td>";
		echo anchor('auth/admin/members/form/'.$key,$this->bep_assets->icon('pencil','Edit Company Details'));
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}

echo "<h3 class=\"projectheading\">Project List by Company</h3>";
if (count($projects)){
        foreach($projects as $companyname => $project){
            echo "<h4 class=\"companyname\">".$companyname."</h4>";
            echo "<table class='tablesorter middle' border='1' cellspacing='0' cellpadding='3' width='95%'>\n";
           // echo "<thead>\n<tr valign='top'>\n";
           // echo "<th class=\"left\" colspan=6 >".$companyname."</th>";
            //echo "</tr>";
            echo "<tr><th class=\"left\" >Project Name</th>\n<th>Show Log</th>\n<th>Enter Log</th><th>Specs</th>\n<th>Files</th>\n<th>Total hour</th>\n<th class=\"middle\">Active</th>\n<th>Edit Project</th>\n</tr>\n</thead>\n<tbody>\n";

            foreach ($project as $key => $list){
                echo "<tr valign='top'>\n";
                echo "<td class=\"left\" width=\"20%\">".$list['project_name']."</td>\n";
                echo "<td width=\"10%\"><a href=\"../admin/showlog/".$list['customer_id']."/".$list['id']."\" >".$this->bep_assets->icon('document16','Show Log')."</a></td>\n";
                //echo "<td width=\"15%\"><a href=\"../admin/projectspec/".$list['customer_id']."/".$list['id']."\" >".$this->bep_assets->icon('arrow_right_16','Show Project Spec')."</a></td>\n";

                echo "<td width=\"10%\">";
                echo anchor('projects/admin/enterlog/'.$list['customer_id']."/".$list['id'],$this->bep_assets->icon('glyphadd16','Enter Log'));
                echo "</td>\n";

                echo "<td width=\"10%\">";
                echo anchor('projects/admin/adminspec/showspec/'.$list['customer_id']."/".$list['id'],$this->bep_assets->icon('arrow_right_16','Show/Enter Porject Specs'));
                echo "</td>\n";

                //echo "<td width=\"15%\"><a href=\"../admin/enterlog/".$list['customer_id']."/".$list['id']."\" >".$this->bep_assets->icon('glyphadd16','Enter Log')."</a></td>\n";

                echo "<td width=\"15%\">";
                echo anchor('projects/admin/adminfile/showfile/'.$list['customer_id']."/".$list['id'],$this->bep_assets->icon('box16','Enter File'));
                echo "</td>\n";

                echo "<td width=\"10%\">".$list['total_hr']."</td>\n";
                $active =  ($list['active']?'tick':'cross');
		echo '<td width=\"10%\" >'.$this->bep_assets->icon($active)."</td>\n";
                echo "<td width=\"15%\">";
                echo anchor('projects/admin/update_project/'.$list['id'],$this->bep_assets->icon('pencil','Edit Project'));
                echo "</td>\n";

                echo "</tr>\n";
            }
            echo "</tbody>\n</table>\n";    
	}	

    }

echo '$customers<pre>';
print_r($customers);
echo "</pre><br />";

echo '$projects<pre>';
print_r($projects);
echo "</pre><br />";
