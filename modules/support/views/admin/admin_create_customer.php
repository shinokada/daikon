<h2><?php echo $title;?></h2>
<div id="create_edit">
<?php

echo form_open('support/admin/create_customer');
echo "\n<p><label for='username'>User Name</label><br/>\n";
/*
foreach ($members->result_array() as $row){
         $options[$row['username']] = $row['username'];
       }
       */
echo form_dropdown('username',$members) ."</p>\n";

echo "\n<p><label for='comname'>Company Name</label><br/>\n";
$data = array('name'=>'company_name','id'=>'comname','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='customer_name'>Cutomer Name</label><br/>\n";
$data = array('name'=>'customer_name','id'=>'customer_name','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='web_address'>Web Address</label><br/>\n";
$data = array('name'=>'web_address','id'=>'web_address','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='password'>Password for website</label><br/>\n";
$data = array('name'=>'password','id'=>'password','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='phone'>Phone</label><br/>\n";
$data = array('name'=>'phone_number','id'=>'phone','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='email'>email</label><br/>\n";
$data = array('name'=>'email','id'=>'email','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='address'>Address</label><br/>\n";
$data = array('name'=>'address','id'=>'address','size'=>100);
echo form_input($data) ."</p>\n";

echo "<p><label for='city'>City</label><br/>\n";
$data = array('name'=>'city','id'=>'city','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='postcode'>Postcode</label><br/>\n";
$data = array('name'=>'postcode','id'=>'postcode','size'=>10);
echo form_input($data) ."</p>\n";

echo "<p><label for='status'>Status</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";


echo form_submit('submit','Create Customer');
echo form_close();


?>
</div>