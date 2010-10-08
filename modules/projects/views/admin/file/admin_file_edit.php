<?php print displayStatus();?>
<?php

echo "<h2>".$title."</h2>";

echo form_open('projects/admin/adminfile/update_file/'.$name['user_id']."/".$records['project_id']."/".$records['id']);
echo "<ul class=\"projectul\">\n";

echo "<li id>Company Name: ".$name['company_name']."</li>";
echo "<li>Project Name: ".$project['project_name']."</li>";

echo "<div class=\"clear\">&nbsp;</div>";
//link
echo "<li id=\"linkli\"><label for='date'>Link</label>\n";
$data = array('name'=>'link','id'=>'link','size'=>40, 'value' => $records['link']);
echo "<div>".form_input($data) ."</div></li>\n";

// file_desc
echo "<li id='filedescli'><label for='file_desc'>File Desc</label>\n";
$data = array('name'=>'file_desc','id'=>'file_desc','size'=>34, 'value' => $records['file_desc']);
echo "<div>".form_input($data) ."</div></li>\n";

//active
echo "<li id=\"activeli\">".form_label($this->lang->line('userlib_active'),'active');
echo "<div><span>".$this->lang->line('general_yes');
echo form_radio('active','1',($records['active']) ? 1 : 0,'id="active"');
echo "</span>\n";
echo "<span>".$this->lang->line('general_no');
echo form_radio('active','0',($records['active']) ? 0 : 1);
echo "</span>\n</div>\n</li>\n";


// id hideen
// project_id hidden
echo "<li>".form_hidden('id',$records['id'])."</li>";
echo "<li>".form_hidden('customer_id',$name['user_id'])."</li>";
echo "<li>".form_hidden('project_id',$project['id'])."</li>";
$submitdata = array(
    'name'        => 'submit',
    'class'          => 'submit',
    'value'       => 'Update File'
    );
echo "<li id=\"submitbtn\">".form_submit($submitdata)."</li></ul>";
echo form_close();

echo "<div class=\"clear\">&nbsp;</div>";

echo '$name<pre>';
print_r($name);
echo "</pre><br />";

echo '$records<pre>';
print_r($records);
echo "</pre><br />";

echo '$administorators<pre>';
print_r($administrators);
echo "</pre><br />";
?>
