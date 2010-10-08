<?php print displayStatus();?>
<h2><?php echo $title;?></h2>


<?php 
echo form_open('support/admin/enter_newcredit/');

echo "\n<p><label for='date'>Date</label><br/>\n";
$data = array('name'=>'date','id'=>'date','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='point_credit'>Point Credit</label><br/>\n";
$data = array('name'=>'point_credit','id'=>'point_credit','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='note'>Note</label><br/>\n";
$data = array('name'=>'note','id'=>'note');
echo form_textarea($data) ."</p>\n";

echo "\n<p><label for='by'>By</label><br/>\n";
echo form_dropdown('by',$administrators) ."</p>\n";

echo form_hidden('id',$id);
echo form_submit('submit','Enter Credit');
echo form_close();
	?>
	