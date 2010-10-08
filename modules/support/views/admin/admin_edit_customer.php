<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<div id="create_edit">
<?php

echo form_open('support/admin/edit_customer');
echo "\n<p><label for='username'>User Name</label><br/>\n";
foreach ($members->result_array() as $row){
         $options[$row['username']] = $row['username'];
       }
echo form_dropdown('username',$options, $customerdetails['username']) ."</p>\n";
       
echo "\n<p><label for='comname'>Company Name</label><br/>\n";
$data = array('name'=>'company_name','id'=>'comname','size'=>40, 'value' => $customerdetails['company_name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='customer_name'>Cutomer Name</label><br/>\n";
$data = array('name'=>'customer_name','id'=>'customer_name','size'=>40, 'value' => $customerdetails['customer_name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='web_address'>Web Address</label><br/>\n";
$data = array('name'=>'web_address','id'=>'web_address','size'=>40, 'value' => $customerdetails['web_address']);
echo form_input($data) ."</p>\n";

echo "<p><label for='password'>Password for website</label><br/>\n";
$data = array('name'=>'password','id'=>'password','size'=>40, 'value' => $customerdetails['password']);
echo form_input($data) ."</p>\n";

echo "<p><label for='phone'>Phone</label><br/>\n";
$data = array('name'=>'phone_number','id'=>'phone','size'=>40, 'value' => $customerdetails['phone_number']);
echo form_input($data) ."</p>\n";

echo "<p><label for='email'>email</label><br/>\n";
$data = array('name'=>'email','id'=>'email','size'=>40, 'value' => $customerdetails['email']);
echo form_input($data) ."</p>\n";

echo "<p><label for='address'>Address</label><br/>\n";
$data = array('name'=>'address','id'=>'address','size'=>100, 'value' => $customerdetails['address']);
echo form_input($data) ."</p>\n";

echo "<p><label for='city'>City</label><br/>\n";
$data = array('name'=>'city','id'=>'city','size'=>40, 'value' => $customerdetails['city']);
echo form_input($data) ."</p>\n";

echo "<p><label for='post_code'>Postcode</label><br/>\n";
$data = array('name'=>'post_code','id'=>'postcode','size'=>10, 'value' => $customerdetails['post_code']);
echo form_input($data) ."</p>\n";

echo "<p><label for='status'>Status</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $customerdetails['status']) ."</p>\n";

echo form_hidden('id',$customerdetails['id']);
echo form_submit('submit','Update Customer');
echo form_close();

?>
</div>