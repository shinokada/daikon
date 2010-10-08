<?php print displayStatus();?>
<h2><?php echo $title;?></h2>


<?php 
echo form_open('support/admin/enter_workdone/');

echo "\n<p><label for='date'>Date</label><br/>\n";
$data = array('name'=>'date','id'=>'date','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='time'>Time</label><br/>\n";
$data = array('name'=>'time','id'=>'time','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='note'>Note</label><br/>\n";
$data = array('name'=>'note','id'=>'note');
echo form_textarea($data) ."</p>\n";

echo "<p><label for='details'>Details</label><br/>\n";
$data = array('name'=>'details','id'=>'details');
echo form_textarea($data) ."</p>\n";

echo "\n<p><label for='by'>By</label><br/>\n";
echo form_dropdown('by',$administrators) ."</p>\n";


echo form_hidden('id',$id);
echo form_submit('submit','Enter Work Done');
echo form_close();
	
?>
	