<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<div id="editrecord">
<?php

echo form_open('projects/admin/update_project');
echo "<ul class=\"projectul\">\n";

echo "<li id=\"proname\"><label for='date'>Project Name</label>\n";
$data = array('name'=>'project_name','id'=>'project_name','size'=>26, 'value' => $records['project_name']);
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"totalli\"><label for='time'>Total Time</label>\n";
$data = array('name'=>'total_hr','id'=>'total_hr','size'=>4, 'value' => $records['total_hr']);
echo "<div>".form_input($data) ."</div>\n</li>\n";

// use ($records['active']) ? 1 : 0 to define active or not.
// use ($records['active']) ? 1 : 0 for active Yes
// use ($records['active']) ? 0 : 1 for active No

echo "<li id=\"activeli\">".form_label($this->lang->line('userlib_active'),'active');
echo "<div><span>". $this->lang->line('general_yes');
echo form_radio('active','1',($records['active']) ? 1 : 0,'id="active"');
echo "</span>";
echo "<span>".$this->lang->line('general_no');
echo form_radio('active','0',($records['active']) ? 0 : 1);
echo "</span>\n</div>\n</li>\n";

echo "<li id=\"createdli\" ><label for='created_by'>By</label>\n";
echo "<div>".form_dropdown('created_by',$administrators,$records['created_by']) ."</div></li>\n";

echo "<li id=\"noteli\"><label for='note'>Note</label>\n";
$data = array('name'=>'note','id'=>'note', 'value' => $records['note']);
echo "<div>".form_textarea($data) ."</div></li>\n";


echo "<li>".form_hidden('id',$records['id'])."</li>";
echo "<li>".form_hidden('customer_id',$records['customer_id'])."</li>";
echo "<li id=\"submitbtn\" >".form_submit('submit','Update Record')."</li></ul>\n";
echo form_close();


echo "<div class=\"clear\">&nbsp;</div>";


echo '$records<pre>';
print_r ($records);
echo "</pre>";
?>
</div>