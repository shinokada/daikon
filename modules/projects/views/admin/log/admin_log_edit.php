<?php print displayStatus();?>
<?php

echo "<h2>".$title."</h2>";

echo form_open('projects/admin/update_log/');
echo "<ul class=\"projectul\">\n";

echo "<li id>Company Name: ".$name['company_name']."</li>";
echo "<li>Project Name: ".$project['project_name']."</li>";

echo "<div class=\"clear\">&nbsp;</div>";

echo "<li id=\"dateli\"><label for='date'>Date</label>\n";
// show date in European way dd-mm-yyyy not in MySQL way yyyy-mm-dd
$newdate =new DateTime($log['date']) ;
$eurodate = $newdate->format('d-m-Y');
$data = array('name'=>'date','id'=>'date','size'=>10, 'value' => $eurodate);
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"startli\"><label for='start_time'>Start Time</label>\n";
$data = array('name'=>'start_time','id'=>'start_time','size'=>6, 'value' => $log['start_time']);
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"finishli\"><label for='finish_time'>Finish Time</label>\n";
$data = array('name'=>'finish_time','id'=>'finish_time','size'=>6, 'value' => $log['finish_time']);
echo "<div>".form_input($data) ."</div></li>\n";


// use ($records['active']) ? 1 : 0 to define active or not.
// use ($records['active']) ? 1 : 0 for active Yes
// use ($records['active']) ? 0 : 1 for active No


echo "<li id=\"activeli\">".form_label($this->lang->line('userlib_active'),'active');
echo "<div><span>".$this->lang->line('general_yes');
echo form_radio('active','1',($log['active']) ? 1 : 0,'id="active"');
echo "</span>\n";
echo "<span>".$this->lang->line('general_no');
echo form_radio('active','0',($log['active']) ? 0 : 1);
echo "</span>\n</div>\n</li>\n";

echo "<li id=\"enterli\"><label for='log_entered_by'>By</label>\n";
echo "<div>".form_dropdown('log_entered_by',$administrators,$log['log_entered_by']) ."</div>\n</li>\n";

echo "<li id=\"shortli\"><label for='short_desc'>Short Description</label>\n";
$data = array('name'=>'short_desc','id'=>'short_desc', 'value' => $log['short_desc'],'size'=>'77');
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"noteli\"><label for='note'>Note</label>\n";
$data = array('name'=>'note','id'=>'note', 'value' => $log['note']);
echo "<div>".form_textarea($data) ."</div>\n</li>\n";

echo "<li>".form_hidden('id',$log['id'])."</li>";
echo "<li>".form_hidden('customer_id',$name['user_id'])."</li>";
echo "<li>".form_hidden('project_id',$project['id'])."</li>";
echo "<li id=\"submitbtn\">".form_submit('submit','Update Log')."</li></ul>";
echo form_close();

echo "<div class=\"clear\">&nbsp;</div>";

echo '$name<pre>';
print_r($name);
echo "</pre><br />";

echo '$project<pre>';
print_r($project);
echo "</pre><br />";

echo '$log<pre>';
print_r($log);
echo "</pre><br />";
?>
