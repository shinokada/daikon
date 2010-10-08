<?php print displayStatus();?>
<?php

echo "<h2>".$title."</h2>";

echo form_open('projects/admin/adminspec/update_spec/'.$name['user_id']."/".$records['project_id']."/".$records['id']);
echo "<ul class=\"projectul\">\n";

echo "<li id>Company Name: ".$name['company_name']."</li>";
echo "<li>Project Name: ".$project['project_name']."</li>";

echo "<div class=\"clear\">&nbsp;</div>";
//spec_desc
echo "<li id=\"dateli\"><label for='date'>Spec Desc</label>\n";
$data = array('name'=>'spec_desc','id'=>'spec_desc','size'=>70, 'value' => $records['spec_desc']);
echo "<div>".form_input($data) ."</div></li>\n";

// spec_details
echo "<li id='enterdetailli'><label for='spec_details'>Spec Details</label>\n";
$data = array('name'=>'spec_details','id'=>'spec_details', 'value' => $records['spec_details']);
echo "<div>".form_textarea($data) ."</div></li>\n";

// created_by
echo "<li id=\"createdbyli\" class='clear' ><label for='created_by'>Created By</label>\n";
echo "<div>".form_dropdown('created_by',$administrators,$records['created_by']) ."</div>\n</li>\n";

//date_created
echo "<li id=\"datecreatedli\"><label for='date_created'>Date Created</label>\n";
// show date in European way dd-mm-yyyy not in MySQL way yyyy-mm-dd
$newdate =new DateTime($records['date_created']) ;
$eurodate = $newdate->format('d-m-Y');
$data = array('name'=>'date_created','id'=>'date_created','size'=>10, 'value' => $eurodate);
echo "<div>".form_input($data) ."</div></li>\n";

//active
echo "<li id=\"activeli\">".form_label($this->lang->line('userlib_active'),'active');
echo "<div><span>".$this->lang->line('general_yes');
echo form_radio('active','1',($records['active']) ? 1 : 0,'id="active"');
echo "</span>\n";
echo "<span>".$this->lang->line('general_no');
echo form_radio('active','0',($records['active']) ? 0 : 1);
echo "</span>\n</div>\n</li>\n";


// completed_by
echo "<li id='completedbyli' class='clear'><label for='completed_by'>Completed By</label>\n";
echo "<div>".form_dropdown('completed_by',$administrators,$records['completed_by']) ."</div>\n</li>\n";


// date_completed
echo "<li id=\"datecompletedli\"><label for='date_completed'>Date Completed</label>\n";
// it could be NULL
if($records['date_completed']==NULL){
    $eurodatecom = '';
}else{
    // show date in European way dd-mm-yyyy not in MySQL way yyyy-mm-dd
    $newdate =new DateTime($records['date_completed']) ;
    $eurodatecom = $newdate->format('d-m-Y');
}

$data = array('name'=>'date_completed','id'=>'date_completed','size'=>10, 'value' => $eurodatecom);
echo "<div>".form_input($data) ."</div></li>\n";

// completed
echo "<li id=\"completedli\" class='listcomp'><label id='completed'>Completed</label>";
echo "<div><span>".$this->lang->line('general_yes');
echo form_radio('completed','1',($records['completed']) ? 1 : 0,'id="completed"');
echo "</span>\n";
echo "<span>".$this->lang->line('general_no');
echo form_radio('completed','0',($records['completed']) ? 0 : 1);
echo "</span>\n</div>\n</li>\n";


// project_id hidden
echo "<li>".form_hidden('id',$records['id'])."</li>";
echo "<li>".form_hidden('customer_id',$name['user_id'])."</li>";
echo "<li>".form_hidden('project_id',$project['id'])."</li>";
$submitdata = array(
    'name'        => 'submit',
    'class'          => 'submit',
    'value'       => 'Update Log'
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
