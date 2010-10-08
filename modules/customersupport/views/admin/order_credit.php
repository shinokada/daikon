<?php
echo "<h3>Order Credit</h3>";
echo $title."<br />";
foreach ($customer_details as $detail){
echo "Your company: ".$detail['company_name']."<br />\n";
echo "Your name: ".$detail['full_name']."<br />\n";
echo "Your email: ".$detail['email']."<br />\n";


echo form_open('customersupport/admin/purchase_credit');

echo form_radio('order_support', '60min 700Kr');
echo "60min 700Kr";
echo "<br/>\n";

echo form_radio('order_support', '120min 1300Kr');
echo "120min 1300Kr";
echo "<br/>\n";


echo form_radio('order_support', '180min 1800Kr');
echo "180min 1800Kr";
echo "<br/>\n";
echo form_hidden('id',$detail['id']);
echo form_hidden('company_name',$detail['company_name']);
echo form_hidden('full_name',$detail['full_name']);
echo form_hidden('email',$detail['email']);
echo form_submit('submit','Order Support Credit');
echo form_close();
}