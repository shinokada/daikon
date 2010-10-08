<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminfile extends Admin_Controller {
  function Adminfile(){
   	parent::Admin_Controller();
		   // Check for access permission
			check('Project Spec');
			// Load models and language
			$this->load->model('MProjectspec');
                        $this->load->model('MProject');
                        $this->load->model('MProjectfile');
			$this->load->module_model('auth','User_model');
			$this->load->language('customer');
			// Set breadcrumb
			$this->bep_site->set_crumb('Project File','projects/admin/admin/');
	}

/*
 * Not using it. when you click a breadcrumb, it will lead to the Project home
 * Future can be used to show all files according to company
 */
    function index(){
        // we use the following variables in the view
        $data['title'] = "Projects File Page";

	$data['header'] = "Projects File Page";

        // get members details where group = 1 which is a member or not 2 which is admin from be_users
	// this will get user_id and company_name
        $id = 1;
        $data['customers'] = $this->MProject->getAllCustomersProfile($id);

        // get spec details
        $data['files'] = $this->MProjectfile->getAllFiles();

	// This how Bep load views
	$data['page'] = $this->config->item('backendpro_template_admin') . "file/admin_file_home";
	$data['module'] = 'projects';
	$this->load->view($this->_container,$data);
    }



    function showfile($id=NULL){
        $data['title'] = "Project File";
        $data['header'] = 'Project File';
        // Set breadcrumb
	$this->bep_site->set_crumb('Show File','projects/admin/adminfile/showfile');
        // load TINYMCE. This does not work with ajax.
        // $this->bep_assets->load_asset_group('TINYMCE');

        // pull admin for 'by' dropdown field
        // where group = 2 from be_users table
        $member_id = 2;
        $data['administrators'] = $this->MProject->getMembersDropDown($member_id);

        // segment 5 is customer id, segment 6 is project id
        $project_id = $this->uri->segment(6);
        // get company name
        $customer_id = $this->uri->segment(5);
        $data['name'] =  $this->MProject->getCompany($customer_id);

        // get project name
        $data['project'] =  $this->MProjectspec->getProject($project_id);

        // get files
        $files =  $this->MProjectfile->getProjectFile($project_id);
        $data['files']=$files;

        if($this->input->post('link')){

            // $project_id is used to enter spec to project
            $this->MProjectfile->enterfile();
            // there is no spec so send to enter spec.
            flashMsg('info','New File is created.');
            redirect('projects/admin/adminfile/showfile/'.$customer_id."/".$project_id,'refresh');
        }

        $data['page'] = $this->config->item('backendpro_template_admin') . "file/admin_show_file";
	$data['module'] = 'projects';
	$this->load->view($this->_container,$data);

    }


    /*
     * Used in admin_show_file.php
     */


    function update_file($id=NULL){
        // get project name
        $project_id = $this->uri->segment(6);
        $data['project'] =  $this->MProjectspec->getProject($project_id);

        // get company name
        $customer_id = $this->uri->segment(5);
        $data['name'] =  $this->MProject->getCompany($customer_id);

        // if you are using TinyMCE here, load it.
        //$this->bep_assets->load_asset_group('TINYMCE');

        if ($this->input->post('link')){
            //$id = $this->input->post('id');
            // do this in models
            // info is filled out, do the followings
            $this->MProjectfile->updateFile();
            // This is CI way to show flashdata
            // $this->session->set_flashdata('message','Page updated');
            // But here we use Bep way to display flash msg
            flashMsg('success','File updated');
            redirect('projects/admin/adminfile/showfile/'.$customer_id."/".$project_id,'refresh');

        }else{

            $data['title'] = 'Update File';
            $data['header']='Update file';
            $data['page'] = $this->config->item('backendpro_template_admin') . "file/admin_file_edit";
            
            
            // find file_id
            $file_id = $this->uri->segment(7);
            $records = $this->MProjectfile->getSigleFile($file_id);
            $data['records'] = $records;

            // pull admin for 'by' dropdown field
            // where group = 2 from be_users table
            $member_id = 2;
            $data['administrators'] = $this->MProject->getMembersDropDown($member_id);
            //Pull user_names from be_users
            // need to get user name and use them with dropdown to choose it
            // this will be used in customersupport module to display customer's own support records
            //$data['members'] = $this->user_model->getUsers();// not working at the moment

              //  if (!count($data['records'])){
                    // if page is not specified redirect to index
                //    redirect('projects/admin/','refresh');
                //}
                // $data['menus'] = $this->MMenus->getAllMenusDisplay();
                // Set breadcrumb
                $this->bep_site->set_crumb('Update Spec','projects/admin/adminfile/update_file');
                $data['module'] = 'projects';
                $this->load->view($this->_container,$data);
        }

    }

    /*
     * Used in admin/adminfile/delete_file.php
     */

    function delete_file($id = NULL){
            $customer_id = $this->uri->segment(5);
            $project_id = $this->uri->segment(6);
            $id = $this->uri->segment(7);
            $this->MProjectfile->deletefile($id);
            flashMsg('success','File deleted');
            redirect('projects/admin/adminfile/showfile/'.$customer_id."/".$project_id,'refresh');
    }
















    /*******
     * Not used yet
     *
     */

// Instead of using AjaxinserShoutBox we use IS_AJAX here
	function Ajaxinsertspec(){
	  if(IS_AJAX){
			$this->MProjectspec->enterspec();
			}else{
			$this->MProjectspec->enterspec();
			flashMsg('success','New spec added');
			redirect ('projects/admin/adminspec');
			}
		}
    /*
     * Used for Ajax
     */


     function Ajaxgetspec($pro_id){

        $specs = $this->MProjectspec->getProjectSpec($pro_id);
        if(is_array($specs)){

            echo "<div class='listspec' id='tablespec' >\n";
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
            echo "<li class='toggledetail'><b>Show Details</b></li>";;
            echo "</ul>";


            foreach ($specs as $key => $list){
                echo "<ul class='firstul'>\n";
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
                    echo anchor('projects/admin/adminspec/delete_spec/'.$list['id'],$this->bep_assets->icon('delete','Delete'));
                    echo "</li>\n";
                    echo "<li class='listedit'>";
                    echo anchor('projects/admin/adminspec/update_spec/'.$list['id'],$this->bep_assets->icon('pencil','Edit'));
                    echo "\n</li>\n";

                    echo "<li class='toggledetail toggle' alt='desc".$list['id']."'>\n<img src='";
                    echo base_url();
                    echo "assets/icons/arrowdown16.png' id='desc".$list['id']."img' alt='arrowdown16'  title='Show Details' />";

                    // echo "<div>\n<a href='desc".$list['id']."' class='toggle' >\n".$this->bep_assets->icon('arrowdown16','Show Details');
                    echo "</li>\n";
                echo "</ul>\n";

                echo "<ul class='secondul' id='desc".$list['id']."'>\n<li class='listdetail'><b>Spec Details</b><div>".$list['spec_details']."</div>\n</li>\n</ul>\n";

            }

            echo "</div>\n";
        }

            else{
                echo "No list. Let's add new one.";
        }
    }




    /*
     * not used at the moment
     *
     *
     */
    function createspec($id=0){
        $data['title'] = "Enter New Spec";

        $data['header'] = "Enter New Spec";
        // Set breadcrumb
        $this->bep_site->set_crumb('Enter New Spec','projects/admin/adminspec/createspec');

        // get company name
        $id = $this->uri->segment(5);
        $data['name'] =  $this->MProject->getCompany($id);

        if ($this->input->post('spec_desc')){
            // id is still customer_id
            $id = $this->input->post('id');
	// fields filled up so,
	$this->MProject->enterNewProject();
	// CI way to set flashdata, but we are not using it
	// $this->session->set_flashdata('message','Product updated');
	// we are using Bep function for flash msg
	flashMsg('success','Log entered');
	redirect('projects/admin/adminspec/showspec/'.$id,'refresh');
        }else{
        // in order to avoid for an error when you click Create New Project
        // with no data, test if segment 4 is 0 or not
            if ($id !=0){
            // pull admin for 'by' dropdown field
            // where group = 2 from be_users table
                $member_id = 2;
                $data['administrators'] = $this->MProject->getMembersDropDown($member_id);

                // set active value to yes
                $this->validation->set_default_value('active','1');

                $data['page'] = $this->config->item('backendpro_template_admin') . "admin_project_create";
                // This how Bep load views
                $data['module'] = 'projects';
                $this->load->view($this->_container,$data);
            }else{
                redirect('projects/admin/','refresh');
            }
        }
    }

    /*
     * Used in projectlist page by clicking edit link
     */


    function update_spectest($id=NULL){

        $id = $this->uri->segment(4);
        // if you are using TinyMCE here, load it.
        // $this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('project_name')){
            $id = $this->input->post('customer_id');
            // info is filled out, do the followings
            $this->MProject->updateProject($id);
            // This is CI way to show flashdata
            // $this->session->set_flashdata('message','Page updated');
            // But here we use Bep way to display flash msg
            flashMsg('success','Project updated');
            redirect('projects/admin/projectlist/'.$id,'refresh');

        }else{

            $data['title'] = "Update Project";
            $data['header'] = 'Update Project';
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_project_edit";
            $records = $this->MProject->getProjectRecord($id);
            $data['records'] = $records;

            // pull admin for 'by' dropdown field
            // where group = 2 from be_users table
            $member_id = 2;
            $data['administrators'] = $this->MProject->getMembersDropDown($member_id);
            //Pull user_names from be_users
            // need to get user name and use them with dropdown to choose it
            // this will be used in customersupport module to display customer's own support records
            //$data['members'] = $this->user_model->getUsers();// not working at the moment

                if (!count($data['records'])){
                    // if page is not specified redirect to index
                    redirect('projects/admin/adminspec','refresh');
                }
                // $data['menus'] = $this->MMenus->getAllMenusDisplay();
                // Set breadcrumb
                $this->bep_site->set_crumb('Update Project Spec','projects/admin/adminspec/update_spec');
                $data['module'] = 'projects';
                $this->load->view($this->_container,$data);
        }

    }


    function enterlog(){
        $data['title'] = "Enter Log";
	$data['header'] = "Enter Log";
	// Set breadcrumb
	$this->bep_site->set_crumb('Enter Log','projects/admin/enterlog');
        $customer_id = $this->uri->segment(4);
	$project_id = $this->uri->segment(5);

        $data['name'] = $this->MProject->getCompany($customer_id);
        $data['project'] = $this->MProject->getProjectRecord($project_id);

	if ($this->input->post('date')){
            $customer_id = $this->input->post('customer_id');
            $project_id = $this->input->post('project_id');
            // fields filled up so,
            $this->MProject->enterLog();
            // CI way to set flashdata, but we are not using it
            // $this->session->set_flashdata('message','Product updated');
            // we are using Bep function for flash msg
            flashMsg('success','Log entered');
            redirect('projects/admin/showlog/'.$customer_id."/".$project_id,'refresh');
        }else{
            // pull admin for 'by' dropdown field
            // where group = 2 from be_users table
            $member_id = 2;
            $data['administrators'] = $this->MProject->getMembersDropDown($member_id);
            // set active value to yes
            $this->validation->set_default_value('active','1');

            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_log_enter";
            // This how Bep load views
            $data['module'] = 'projects';
            $this->load->view($this->_container,$data);
        }
    }


    function showlog(){
        $data['title'] = "Logs";
        $data['header'] = 'Logs';

        // get project details
        $customer_id = $this->uri->segment(4);
        // get company name
        $data['name'] =  $this->MProject->getCompany($customer_id);

        // get log details. create variable log to use it in method calTime()
        $project_id = $this->uri->segment(5);
        $logs = array();
        $logs = $this->MProject->getlogs($project_id);
        $data['logs'] = $logs;

        // get project details
        $project = $this->MProject->getProjectRecord($project_id);
        $data['project'] = $project;

        // find total time used in seconds
        $total_time_used = 0;
        $total_time_used = $this->MProject->calTotalTime($project_id);
        // total time in min
        $data['total_time_min']= $total_time_used / 60;
        // total time in HH:MM
        $hours = floor($total_time_used / 3600);
        $mins = ($total_time_used - $hours*3600)/60;
        $data['total_time_used']= "$hours:$mins";

        // estimated time in min
        $estimate_hr = $project['total_hr'];
        $data['estimate_min']=$estimate_hr * 60;

        // Set breadcrumb
	$this->bep_site->set_crumb('Logs','projects/admin/showlog');

        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_log_list";
	$data['module'] = 'projects';
	$this->load->view($this->_container,$data);
    }



    function logdetails($id){
        $data['title'] = "Log Details";
        $data['header'] = 'Log Details';
        // Set breadcrumb
	$this->bep_site->set_crumb('Log Details','projects/admin/logdetails');

        // get company name
        $customer_id = $this->uri->segment(4);
        $data['name'] =  $this->MProject->getCompany($customer_id);

         // get project details
        $project_id = $this->uri->segment(5);
        $data['project'] = $this->MProject->getProjectRecord($project_id);

        // get project name
        $id = $this->uri->segment(6);
        $data['log'] =  $this->MProject->getSingleLog($id);

        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_log_details";
	$data['module'] = 'projects';
	$this->load->view($this->_container,$data);
    }


    function update_log($log_id = 0){

        //$customer_id = $this->uri->segment(4);
	//$project_id = $this->uri->segment(5);
        //$log_id = $this->uri->segment(6);

        //$data['customer'] = $this->MProject->getCompany($customer_id);
        // $data['records'] = $this->MProject->getProjectRecord($project_id);


	if ($this->input->post('date')){

            $customer_id = $this->input->post('customer_id');
            $project_id = $this->input->post('project_id');
            $id = $this->input->post('id');

            // fields filled up so,
            $this->MProject->updateLog();
            // CI way to set flashdata, but we are not using it
            // $this->session->set_flashdata('message','Product updated');
            // we are using Bep function for flash msg
            flashMsg('success','Log Updated');
            redirect('projects/admin/showlog/'.$customer_id."/".$project_id,'refresh');
        }else{
            $data['title'] = "Update Log";
            $data['header'] = "Update Log";
            // Set breadcrumb
            $this->bep_site->set_crumb('Update Log','projects/admin/update_log');

             // get company name
            $customer_id = $this->uri->segment(4);
            $data['name'] =  $this->MProject->getCompany($customer_id);

             // get project details
            $project_id = $this->uri->segment(5);
            $data['project'] = $this->MProject->getProjectRecord($project_id);
            // set active value to yes
            $this->validation->set_default_value('active','1');

            // get project name
            $id = $this->uri->segment(6);
            $data['log'] =  $this->MProject->getSingleLog($id);
            // pull admin for 'by' dropdown field
            // where group = 2 from be_users table
            $member_id = 2;
            $data['administrators'] = $this->MProject->getMembersDropDown($member_id);
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_log_edit";
            // This how Bep load views
            $data['module'] = 'projects';
            $this->load->view($this->_container,$data);
        }
    }


    function start_log(){
        $data['title'] = "Start Log";
	$data['header'] = "Start Log";
	// Set breadcrumb
	$this->bep_site->set_crumb('Start Log','projects/admin/start_log');
        //$customer_id = $this->uri->segment(4);
	//$project_id = $this->uri->segment(5);

        $data['name'] = $this->MProject->getCompany($customer_id);
        $data['project'] = $this->MProject->getProjectRecord($project_id);

	if ($this->input->post('date')){
            $customer_id = $this->input->post('customer_id');
            $project_id = $this->input->post('project_id');
            // fields filled up so,
            $this->MProject->enterLog();
            // CI way to set flashdata, but we are not using it
            // $this->session->set_flashdata('message','Product updated');
            // we are using Bep function for flash msg
            flashMsg('success','Log entered');
            redirect('projects/admin/showlog/'.$customer_id."/".$project_id,'refresh');
        }else{
            // project dropdown to select


            // pull admin for 'by' dropdown field
            // where group = 2 from be_users table
            $member_id = 2;
            $data['administrators'] = $this->MProject->getMembersDropDown($member_id);
            // set active value to yes
            $this->validation->set_default_value('active','1');

            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_log_enter";
            // This how Bep load views
            $data['module'] = 'projects';
            $this->load->view($this->_container,$data);
        }

    }


	function delete_log($id = NULL){
		$customer_id = $this->uri->segment(4);
                $project_id = $this->uri->segment(5);
		$id = $this->uri->segment(6);
		$this->MProject->deletelog($id);
		flashMsg('success','Log deleted');
		redirect('projects/admin/showlog/'.$customer_id."/".$project_id,'refresh');
	}


        function ajax_delete_log($id){
                if($id){
		$this->MProject->deletelog($id);
                }

	}
















        /*
         *
         * NOT USED
         *
         */







	function customer_record($id= NULL){
		$data['title'] = "Customer Record";
		$id = $this->uri->segment(4);

		$data['customer_records'] = $this->MSupport->getAllCustomerRecord($id);
		$totaltime = $this->MSupport-> totalColumn($id,'time');
		$totalcredit = $this->MSupport-> totalColumn($id, 'point_credit');
		$total = $totalcredit->point_credit - $totaltime->time;
		$data['totaltime']= $totaltime->time;
		$data['totalcredit']= $totalcredit->point_credit;
		$data['total']= $total;

		// Get customer name and username to display by using $id which is segment 4
		$data['customer_details']= $this->MSupport->getSingleMemberProfile($id);
		$data['header'] = $this->lang->line('customer_record');
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('customer_support_customer'),'support/admin/customer');
		// This how Bep load views
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_customer_home";
		$data['module'] = 'support';
		$this->load->view($this->_container,$data);
	}






	function enter_workdone(){
		$data['title'] = "Enter Work Done";

		$data['header'] = $this->lang->line('customer_work_done');
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('customer_work_done'),'support/admin/workdone');

		$data['id'] = $this->uri->segment(4);

		if ($this->input->post('time')){
			$id = $this->input->post('id');
	  		// fields filled up so,
	  		$this->MSupport->enter_workdone();
	  		// CI way to set flashdata, but we are not using it
	  		// $this->session->set_flashdata('message','Product updated');
	  		// we are using Bep function for flash msg
	  		flashMsg('success','Work Done Entered');
	  		redirect('support/admin/customer_record/'.$id,'refresh');
	  	}else{

	  		// pull admin for 'by' dropdown field
			// where group = 2 from be_users table
	  		$member_id = 2;
	  		$data['administrators'] = $this->MSupport->getMembersDropDown($member_id);

	  		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_work_done";
	  		// This how Bep load views
			$data['module'] = 'support';
			$this->load->view($this->_container,$data);
	  	}

	}

	function update_record(){
		$id = $this->uri->segment(4);
		// if you are using TinyMCE here, load it.
		// $this->bep_assets->load_asset_group('TINYMCE');
		if ($this->input->post('date')){
			$customer_id = $this->input->post('customer_id');
			// info is filled out, do the followings

			$this->MSupport->updateRecord($id);
			// This is CI way to show flashdata
			// $this->session->set_flashdata('message','Page updated');
			// But here we use Bep way to display flash msg
	  		flashMsg('success','Customer updated');
		  	redirect('support/admin/customer_record/'.$customer_id,'refresh');
		}else{

			$data['title'] = "Update Record";
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_edit_record";
			$data['records'] = $this->MSupport->getRecord($id);

	  		// pull admin for 'by' dropdown field
			// where group = 2 from be_users table
	  		$member_id = 2;
	  		$data['administrators'] = $this->MSupport->getMembersDropDown($member_id);
			//Pull user_names from be_users
			// need to get user name and use them with dropdown to choose it
			// this will be used in customersupport module to display customer's own support records
			//$data['members'] = $this->user_model->getUsers();// not working at the moment


		if (!count($data['records'])){
			// if page is not specified redirect to index
			redirect('support/admin/','refresh');
			}
			// $data['menus'] = $this->MMenus->getAllMenusDisplay();
			// Set breadcrumb
			$this->bep_site->set_crumb($this->lang->line('customer_support_admin_edit'),'support/admin/update_record');
			$data['header'] = $this->lang->line('customer_edit_record');
			$data['module'] = 'support';
			$this->load->view($this->_container,$data);
		}

	}



	function supportDisplay(){

	}


	function details($id){

		// we use the following variables in the view
		$data['title'] = "Support Details";
		$data['header'] = "Support Details" ;

		$data['username']=$this->session->userdata('username');
		$username = $this->session->userdata('username');

		$id = $this->uri->segment(4);
		$this->load->module_model('customersupport','MCustomer_support');
		$data['details']= $this->MCustomer_support->admingetRecordDetails($id);
		// Set breadcrumb
		$this->bep_site->set_crumb('Details','customersupport/admin/details');

		// This how Bep load views
		$data['page'] = $this->config->item('backendpro_template_admin') . "details";
		$data['module'] = 'customersupport';
		$this->load->view($this->_container,$data);

	}
}//end class
?>
