<?php print displayStatus();?>
<h2><?php echo $title;?></h2>

<?php
//$this->load->helper('date');
echo "<h3>";
echo anchor('projects/admin/enterlog/'.$project['customer_id']."/".$project['id'],'Enter New Log');
echo "</h3>";
echo "\n<br />\n";
echo "<h3>Customer name: ".$name['company_name']."</h3>" ;
echo "<h3>Project name: ".$project['project_name']."</h3>" ;
echo "<div class=\"message\">Row Deleted Successfully</div>";

if (count($logs)){

    echo "<table class='tablesorter middle' border='1' cellspacing='0' cellpadding='3' width='65%'>\n";
    echo "<thead>\n<tr>\n<th>Estimated Time hours (minutes)</th>\n<th>Total Time Used In Hours</th>\n<th>Total Time Used In Min</th>\n</tr>\n</thead>";
    echo "<tbody>\n<tr>\n";
    echo "<td>".$project['total_hr']." hrs ( ".$estimate_min." min )</td>\n";
    echo "<td>".$total_time_used." hrs</td>\n";
    echo "<td>".$total_time_min." min</td>\n";
    echo "</tr>\n</tbody>\n</table>\n";


    echo "<table class='tablesorter middle' border='1' cellspacing='0' cellpadding='3' width='95%'>\n";
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th class=\"left\" >Date</th><th>Start Time</th><th>Finish Time</th><th>Total Time</th><th>Active</th><th>By</th><th class=\"left\">Short Desc</th><th>Details</th>\n<th>Edit</th>\n<th>Delete</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";

    foreach ($logs as $key => $list){
        echo "<tr id='row_".$list['id']."' valign='top'>\n";
        // show date in European way dd-mm-yyyy not in MySQL way yyyy-mm-dd
        $newdate =new DateTime($list['date']) ;
        echo "<td class=\"left\" width=\"8%\">".$newdate->format('d-m-Y')."</td>\n";
        $starttime = new DateTime($list['start_time']);
        echo "<td width=\"7%\">".date_format($starttime, 'H:i')."</td>\n";
        $finishtime = new DateTime($list['finish_time']);
        echo "<td width=\"8%\">".date_format($finishtime, 'H:i')."</td>\n";
        $timediff = 0;
        $interval = $starttime->diff($finishtime);
        $hours   = $interval->format('%h');
        $minutes = $interval->format('%i');
        $timediff = $hours * 60 + $minutes;

        // var $timediff= $starttime->diff($finishtime);
        echo "<td width=\7%\">".$timediff."</td>\n";
        $active =  ($list['active']?'tick':'cross');
        echo '<td width=\"8%\" >'.$this->bep_assets->icon($active)."</td>\n";
        echo "<td width=\"7%\">".$list['log_entered_by']."</td>\n";
        echo "<td class=\"left\" width=\"40%\">".$list['short_desc']."</td>\n";
        echo "<td width=\"5%\">";
        echo anchor('projects/admin/logdetails/'.$project['customer_id']."/".$list['project_id']."/".$list['id'],$this->bep_assets->icon('info_button_16','Details'));
        echo "</td>\n";
        echo "<td width=\"5%\">";
        echo anchor('projects/admin/update_log/'.$project['customer_id']."/".$list['project_id']."/".$list['id'],$this->bep_assets->icon('pencil','Edit Log'));
        echo "</td>\n";
        echo "<td width=\"5%\">";
        //echo "<input class=\"confirm_button\" type=\"button\" value=\"Show Confirm\" />";
        echo anchor('projects/admin/delete_log/'.$project['customer_id']."/".$list['project_id']."/".$list['id'],$this->bep_assets->icon('delete','Delete Log'), array('class'=>'deleteme'));
        echo "</td>\n";

        echo "</tr>\n";
    }
    echo "</tbody>\n</table>\n";
        }else{
            echo "No Log Entry";
        }


echo "logs<pre>";
print_r($logs);
echo "</pre><br />";

echo '$project<pre>';
print_r($project);
echo "</pre><br />";

echo '$name: <pre>';
print_r($name);
echo "</pre><br />";

?>
	
