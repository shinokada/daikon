<?php print displayStatus();?>
<h2><?php
echo $title." for ".$name['company_name'].": ".$project['project_name'];

?></h2>

<?php

/*
 This is how CI display flash data. but we don't use it.

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
*/

/*
 * @ $customers returns user_id, company_name
 * @ $file
 */

// Form for a new file
$attributes = array('class' => 'fileul', 'id' => 'fileformentry');
echo form_open('projects/admin/adminfile/showfile/'.$project['customer_id']."/".$project['id'],$attributes);
echo "\n<ul class=\"fileulclass\" id=\"fileulid\">\n";

echo "<li id=\"linkli\">\n<label for='link'>*Link</label>\n";
$data = array('name'=>'link','id'=>'link','size'=>30);
echo "<div>\nhttp://".form_input($data) ."</div>\n</li>\n";


echo "<li id=\"filedescli\">\n<label for='file_desc'>*File Desc</label>\n";
$data = array('name'=>'file_desc','id'=>'filedescid','size'=>30);
echo "<div>\n".form_input($data) ."</div></li>\n";


echo "<li id=\"activeli\">\n<label for='active'>".form_label($this->lang->line('userlib_active'),'active')."</label>";
echo "<div>\n<span>\n".$this->lang->line('general_yes');
$datayes = array(
    'name'        => 'active',
    'id'          => 'activeyes',
    'value'       => '1',
    'checked'     => TRUE,

    );
echo form_radio($datayes);
echo "</span>\n";
echo "<span>\n".$this->lang->line('general_no');
$datano = array(
    'name'        => 'active',
    'id'          => 'activeno',
    'value'       => '0',
    );
echo form_radio($datano);
echo "</span>\n</div>\n</li>\n";


$customer_id = $this->uri->segment(5);
echo "<li>\n".form_hidden('customer_id',$customer_id)."</li>\n";
$project_id = $this->uri->segment(6);
echo "<li>\n".form_hidden('project_id',$project_id)."</li>\n";
$submitdata = array(
    'name'        => 'submit',
    'class'          => 'submit',
    'value'       => 'Enter File Link'
    );
echo "<li id=\"submitbtn\">\n".form_submit($submitdata)."</li>\n</ul>\n";
echo form_close();
echo "\n";
echo "<div class=\"clear\">&nbsp;</div>";


// Display specs
echo "<div class='listspec' id='tablespec' >\n";
if (count($files)){
    echo "<ul class='headul'>\n";
    echo "<li class='linkli'>\n<b>Link</b></li>";
    echo "<li class='filedescli'>\n<b>File Desc</b></li>";
    echo "<li class='listactive'><b>Active</b></li>";
    echo "<li class='listdelete'>".$this->bep_assets->icon('delete','Delete')."</li>";
    echo "<li class='listedit'>\n".$this->bep_assets->icon('pencil','Edit')."</li>";
    echo "</ul>";


    foreach ($files as $key => $list){
        echo "<ul class='firstul' id='row_".$list['id']."'>\n";
            echo "<li class='linkli'>\n<a href='http://".$list['link']."' target='_blank'>http://".$list['link']."</a></li>\n";
           
         
            echo "<li class='filedescli'>".$list['file_desc']."</li>";
           
            $active =  ($list['active']?'tick':'cross');
            echo '<li class=\'listactive\'>'.$this->bep_assets->icon($active)."\n</li>\n";

            echo "<li class='listdelete'>";
            echo anchor('projects/admin/adminfile/delete_file/'.$name['user_id']."/".$project['id']."/".$list['id'],$this->bep_assets->icon('delete','Delete'), array('class'=>'deleteme'));
            echo "</li>\n";
            echo "<li class='listedit'>";
            echo anchor('projects/admin/adminfile/update_file/'.$name['user_id']."/".$project['id']."/".$list['id'],$this->bep_assets->icon('pencil','Edit'));
            echo "\n</li>\n";         
        echo "</ul>\n";
    
    }
    
    
}else{
    echo "</div>\n";
    echo "<div class=\"clear\">&nbsp;</div>";
    echo "<div id='noproject'>There are no projects. Add new project.</div>";
}

echo "<div class=\"clear\">&nbsp;</div>";
?>



<?php
echo '<br />$name<pre>';
print_r($name);
echo "</pre><br />";

echo '$files<pre>';
print_r($files);
echo "</pre><br />";

echo '$project<pre>';
print_r($project);
echo "</pre><br />";
