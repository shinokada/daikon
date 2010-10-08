<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<div id="editrecord">
<?php

echo form_open('support/admin/update_record');
       
echo "\n<p><label for='date'>Date</label><br/>\n";
$data = array('name'=>'date','id'=>'date','size'=>40, 'value' => $records['date']);
echo form_input($data) ."</p>\n";

echo "<p><label for='time'>Time</label><br/>\n";
$data = array('name'=>'time','id'=>'time','size'=>40, 'value' => $records['time']);
echo form_input($data) ."</p>\n";

echo "<p><label for='point_credit'>Point Credit</label><br/>\n";
$data = array('name'=>'point_credit','id'=>'point_credit','size'=>40, 'value' => $records['point_credit']);
echo form_input($data) ."</p>\n";

echo "<p><label for='note'>Note</label><br/>\n";
$data = array('name'=>'note','id'=>'note', 'value' => $records['note']);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='details'>Details</label><br/>\n";
$data = array('name'=>'details','id'=>'details', 'value' => $records['details']);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='by'>By</label><br/>\n";
echo form_dropdown('by',$administrators,$records['by']) ."</p>\n";


echo form_hidden('id',$records['id']);
echo form_hidden('customer_id',$records['customer_id']);
echo form_submit('submit','Update Record');
echo form_close();

?>
</div>