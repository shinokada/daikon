<?php print displayStatus();?>
<h2><?php echo $title." for ".$name['company_name'];

?></h2>


<?php

echo form_open('projects/admin/newproject/');
echo "<ul class=\"projectul\">\n";
echo "<li id=\"proname\" class=\"\">\n<label for='project_name'>Project Name</label>\n";
$data = array('name'=>'project_name','id'=>'project_name','size'=>26);
echo "<div>".form_input($data) ."</div></li>\n";

echo "\n<li id=\"totalli\" class=\"\" >\n<label for='total_hr'>Total hour</label>\n";
$data = array('name'=>'total_hr','id'=>'total_hr','size'=>4);
echo "<div>".form_input($data) ."</div>\n</li>\n";


echo "<li id=\"activeli\" class=\"\">".form_label($this->lang->line('userlib_active'),'active');
echo "<div><span>".$this->lang->line('general_yes');
echo form_radio('active','1',$this->validation->set_radio('active','1'));
echo "</span>";
echo "<span>".$this->lang->line('general_no');
echo form_radio('active','0',$this->validation->set_radio('active','0'));
echo "</span>\n</div>\n</li>\n";

echo "<li id=\"createdli\" class\"\"><label for='created_by'>By</label>\n";
echo "<div>".form_dropdown('created_by',$administrators) ."</div>\n</li>";

echo "<li id=\"noteli\" class=\"\"><label for='note'>Note</label>\n";
$data = array('name'=>'note','id'=>'note');
echo "<div>".form_textarea($data) ."</div>\n</li>\n";


$id = $this->uri->segment(4);
echo "<li>".form_hidden('id',$id)."</li>\n";
$submitdata = array(
    'name'        => 'submit',
    'class'          => 'submit',
    'value'       => 'Create New Project'
    );
echo "<li id=\"submitbtn\" class=\"\">".form_submit($submitdata)."</li>\n</ul>\n";
echo form_close()."\n";

echo "<div class=\"clear\">&nbsp;</div>";

echo "<pre>";
print_r ($name);
echo "</pre>";

?>



	