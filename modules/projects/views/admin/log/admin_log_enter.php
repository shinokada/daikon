<?php print displayStatus();?>
<?php

echo "<h2>".$title."</h2>";


echo form_open('projects/admin/enterlog/');
echo "<ul class=\"projectul\">\n";

echo "<li id=\"companlyli\">Company Name: ".$name['company_name']."</li>";
echo "<li>Project Name: ".$project['project_name']."</li>";

echo "<div class=\"clear\">&nbsp;</div>";

echo "<li id=\"dateli\"><label for='date'>Date</label>\n";
$data = array('name'=>'date','id'=>'date','size'=>10);
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"startli\"><label for='start_time'>Start Time</label>\n";
$data = array('name'=>'start_time','id'=>'start_time','size'=>6);
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"finishli\"><label for='finish_time'>Finish Time</label>\n";
$data = array('name'=>'finish_time','id'=>'finish_time','size'=>6);
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"activeli\">".form_label($this->lang->line('userlib_active'),'active');
echo "<div><span>".$this->lang->line('general_yes');
echo form_radio('active','1',$this->validation->set_radio('active','1'));
echo "</span>\n";
echo "<span>".$this->lang->line('general_no');
echo form_radio('active','0',$this->validation->set_radio('active','0'));
echo "</span>\n</div>\n</li>\n";

echo "<li id=\"enterli\"><label for='log_entered_by'>By</label>\n";
echo "<div>".form_dropdown('log_entered_by',$administrators) ."</div>\n</li>\n";

echo "<li id=\"shortli\"><label for='short_desc'>Short Description</label>\n";
$data = array('name'=>'short_desc','id'=>'short_desc','size'=>'77');
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"noteli\"><label for='note'>Note</label>\n";
$data = array('name'=>'note','id'=>'note');
echo "<div>".form_textarea($data) ."</div>\n</li>\n";


$customer_id = $this->uri->segment(4);
echo "<li>".form_hidden('customer_id',$customer_id)."</li>";
$project_id = $this->uri->segment(5);
echo "<li>".form_hidden('project_id',$project_id)."</li>";
$submitdata = array(
    'name'        => 'submit',
    'class'          => 'submit',
    'value'       => 'Enter Log'
    );
echo "<li id=\"submitbtn\">".form_submit($submitdata)."</li></ul>";
echo form_close();

echo "<div class=\"clear\">&nbsp;</div>";

echo '$name<pre>';
print_r($name);
echo "</pre><br />";

echo '$project<pre>';
print_r($project);
echo "</pre><br />";



?>
	