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
 * @ $spec
 */

// 6th elemet is project_id
$id = $this->uri->segment(4);
//echo "<h3><a href=\"../createspec/".$id."\">Enter New Spec</a></h3>";


// Form for a new spec
$attributes = array('class' => 'projectul', 'id' => 'specformentry');
echo form_open('projects/admin/adminspec/showspec/'.$project['customer_id']."/".$project['id'],$attributes);
echo "\n<ul class=\"speculclass\" id=\"speculid\">\n";

echo "<li id=\"\">\n<label for='spec_desc'>*Spec Desc</label>\n";
$data = array('name'=>'spec_desc','id'=>'spec_desc','size'=>40);
echo "<div>\n".form_input($data) ."</div>\n</li>\n";

// no need for completed list
// autofill list for created_by can be added through login data

echo "<li id=\"dateli\">\n<label for='date_created'>*Date</label>\n";
$data = array('name'=>'date_created','id'=>'date_created','size'=>8);
echo "<div>\n".form_input($data) ."</div></li>\n";

// find login name and id
echo "<li id=\"enterli\">\n<label for='created_by'>By</label>\n";
echo "<div class=\"createdli\">\n".form_dropdown('created_by',$administrators) ."</div>\n</li>\n";

// no need for completed_by
// no need for date_completed

/*
echo "<li id=\"startli\"><label for='start_time'>Start Time</label>\n";
$data = array('name'=>'start_time','id'=>'start_time','size'=>5);
echo "<div>".form_input($data) ."</div></li>\n";

echo "<li id=\"finishli\"><label for='finish_time'>Finish Time</label>\n";
$data = array('name'=>'finish_time','id'=>'finish_time','size'=>5);
echo "<div>".form_input($data) ."</div></li>\n";
*/



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

echo"<li id='enterdetailli' class='toggle' >\n<div id='enterlabel'><label for='spec_details'>Click me to enter Spec Details</label></div>\n";
$data = array('name'=>'spec_details','id'=>'detailstext');
echo "<div  id='textarea' >\n".form_textarea($data) ."</div></li>\n";


/*
echo "<li id=\"shortli\"><label for='spec_details'>Spec Details</label>\n";
$data = array('name'=>'spec_details','id'=>'spec_details');
echo "<div>".form_textarea($data) ."</div></li>\n";
*/
/*
echo "<li id=\"noteli\"><label for='note'>Note</label>\n";
$data = array('name'=>'note','id'=>'note');
echo "<div>".form_textarea($data) ."</div>\n</li>\n";
*/

$customer_id = $this->uri->segment(5);
echo "<li>\n".form_hidden('customer_id',$customer_id)."</li>\n";
$project_id = $this->uri->segment(6);
echo "<li>\n".form_hidden('project_id',$project_id)."</li>\n";
echo "<li id=\"submitbtn\">\n".form_submit('submit','Enter Spec')."</li>\n</ul>\n";
echo form_close();
echo "\n";
echo "<div class=\"clear\">&nbsp;</div>";


// Display specs
echo "<div class='listspec' id='tablespec' >\n";
if (count($specs)){
    echo "<ul class='headul'>\n";
    echo "<li class='listspecdesc'>\n<b>Spec Desc</b></li>";
    echo "<li class='listcomp'>\n<b>Completed</b></li>";
    echo "<li class='listcreatedby'>\n".$this->bep_assets->icon('user_add_16','Created By')."</li>";
    echo "<li class='listcreateddate'>\n".$this->bep_assets->icon('calendar_add','Date Created')."</li>";
    echo "<li class='listcompletedby'>\n".$this->bep_assets->icon('user_edit','Completed By')."</li>";
    echo "<li class='listcompleddate'>".$this->bep_assets->icon('calendar_edit','Date Completed')."</li>";
    echo "<li class='listactive'><b>Active</b></li>";
    echo "<li class='listdelete'>".$this->bep_assets->icon('delete','Delete')."</li>";
    echo "<li class='listedit'>\n".$this->bep_assets->icon('pencil','Edit')."</li>";
    echo "<li class='toggledetail'><b>Show Details</b></li>";
    echo "</ul>";


    foreach ($specs as $key => $list){
        echo "<ul class='firstul' id='row_".$list['id'] ."'>\n";
            echo "<li class='listspecdesc'>\n" .$list['spec_desc']."</li>\n";
            $completed =  ($list['completed']?'tick':'cross');
            echo "<li class='listcomp'>";
            echo $this->bep_assets->icon($completed);
            echo "</li>\n";
            echo "<li class='listcreatedby'>\n".$list['created_by']."</li>";
            // if date_created exist then conver it to European way from MwSQL way
            if($list['date_created']){
                $newdatecreated =new DateTime($list['date_created']) ;

            }else{
                $newdatecreated = NULL;
            }
            echo "<li class='listcreateddate'>".$newdatecreated->format('d-m-Y')."</li>\n";
            echo "<li class='listcompletedby'>".$list['completed_by']."</li>";
            // if date_completed exist then conver it to European way from MwSQL way
            // date_completed can be NULL, if I use it with ->format, it does not work
            // so outputs must be different way
            if($list['date_completed']){
                $newdatecompleted =new DateTime($list['date_completed']) ;
                echo "<li class='listcompleddate'>\n".$newdatecompleted->format('d-m-Y')."\n</li>\n";
            }else{
                $newdatecompleted = NULL;
                 echo "<li class='listcompleddate'>\n".$newdatecompleted."\n</li>\n";
            }
            $active =  ($list['active']?'tick':'cross');
            echo '<li class=\'listactive\'>'.$this->bep_assets->icon($active)."\n</li>\n";

            echo "<li class='listdelete'>";
            echo anchor('projects/admin/adminspec/delete_spec/'.$name['user_id']."/".$project['id']."/".$list['id'],$this->bep_assets->icon('delete','Delete'), array('class' => 'deleteme'));
            echo "</li>\n";
            echo "<li class='listedit'>";
            echo anchor('projects/admin/adminspec/update_spec/'.$name['user_id']."/".$project['id']."/".$list['id'],$this->bep_assets->icon('pencil','Edit'));
            echo "\n</li>\n";

            echo "<li class='toggledetail toggle' alt='desc".$list['id']."'>\n<img src='";
            echo base_url();
            echo "assets/icons/arrowdown16.png' id='desc".$list['id']."img' alt='arrowdown16'  title='Show Details' />";

            // echo "<div>\n<a href='desc".$list['id']."' class='toggle' >\n".$this->bep_assets->icon('arrowdown16','Show Details');
            echo "</li>\n";
            echo "<li class='secondul listdetail' id='desc".$list['id']."'>\n<b>Spec Details</b><div>".$list['spec_details']."</div>\n</li>\n";
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

echo '$specs<pre>';
print_r($specs);
echo "</pre><br />";

echo '$project<pre>';
print_r($project);
echo "</pre><br />";
