<?php print displayStatus();?>
<h2><?php echo $title;?></h2>

<?php
$this->load->helper('date');

echo "<h3>Customer name: ".$name['company_name']."</h3>" ;
echo "<h3>Project name: ".$project['project_name']."</h3>" ;

if (count($log)){
    echo "<table class='tablesorter middle' border='1' cellspacing='0' cellpadding='3' width='95%'>\n";
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th class=\"left\" >Date</th><th>Start Time</th><th>Finish Time</th><th>Total Time</th><th>Active</th><th>By</th><th class=\"left\">Short Desc</th><th>Edit Log</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    echo "<tr valign='top'>\n";

    // show date in European way dd-mm-yyyy not in MySQL way yyyy-mm-dd
    $newdate =new DateTime($log['date']) ;
    echo "<td class=\"left\" width=\"8%\">".$newdate->format('d-m-Y')."</td>\n";
    // old way to show date with YY-mm-dd
    // echo "<td class=\"left\" width=\"8%\">".$log['date']."</td>\n";
    $starttime = new DateTime($log['start_time']);
    echo "<td width=\"7%\">".date_format($starttime, 'H:i')."</td>\n";
    $finishtime = new DateTime($log['finish_time']);
    echo "<td width=\"8%\">".date_format($finishtime, 'H:i')."</td>\n";
    $timediff = 0;
    $interval = $starttime->diff($finishtime);
    $hours   = $interval->format('%h');
    $minutes = $interval->format('%i');
    $timediff = $hours * 60 + $minutes;

    // var $timediff= $starttime->diff($finishtime);
    echo "<td width=\7%\">".$timediff."</td>\n";
    $active =  ($log['active']?'tick':'cross');
    echo '<td width=\"7%\" >'.$this->bep_assets->icon($active)."</td>\n";
    echo "<td width=\"8%\">".$log['log_entered_by']."</td>\n";
    echo "<td class=\"left\" width=\"40%\">".$log['short_desc']."</td>\n";
    echo "<td width=\"8%\">";
    echo anchor('projects/admin/update_log/'.$project['customer_id']."/".$log['project_id']."/".$log['id'],$this->bep_assets->icon('pencil','Edit Log'));
    echo "</td>\n";
    echo "</tr>\n";
    echo "</tbody>\n</table>\n";
    echo "<table class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='95%'>\n";
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th class=\"left\"  >Details</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    echo "<tr valign='top'>\n";
    echo "<td class=\"left\" >".$log['note']."</td>\n</tr>\n</table>";



}else{
    echo "No Log Entry";
}

echo '$log<pre>';
print_r($log);
echo "</pre><br />";

echo '$project<pre>';
print_r($project);
echo "</pre><br />";

echo '$name<pre>';
print_r($name);
echo "</pre><br />";

?>
