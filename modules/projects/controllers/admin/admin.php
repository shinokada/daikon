<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
  function Admin(){
   	parent::Admin_Controller();
		   // Check for access permission
			check('Project Home');
			// Load models and language
			$this->load->model('MProject');
			$this->load->module_model('auth','User_model');
			$this->load->language('customer');
			// Set breadcrumb
			$this->bep_site->set_crumb('Project Log','projects/admin');
                        $this->load->helper('date');
	}


    function index(){
        // we use the following variables in the view
        $data['title'] = "Projects Page";

	$data['header'] = $this->lang->line('project_projects');

        // get members details where group = 1 which is a member or not 2 which is admin from be_users
	// this will get user_id and company_name
        $id = 1;
        $data['customers'] = $this->MProject->getAllCustomersProfile($id);

        // get all projects
        $data['projects'] = $this->MProject->getAllProjects();

	// This how Bep load views
	$data['page'] = $this->config->item('backendpro_template_admin') . "admin_project_home";
	$data['module'] = 'projects';
	$this->load->view($this->_container,$data);
    }


    function projectlist($id=NULL){
        $data['title'] = "Project List";
        $data['header'] = 'Project List';
        $id = $this->uri->segment(4);
        $data['projects'] =  $this->MProject->getProjectList($id);
 
        // Set breadcrumb
	$this->bep_site->set_crumb('Project List','projects/admin/projectlist');

        // get company name
        $data['name'] =  $this->MProject->getCompany($id);

        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_project_list";
	$data['module'] = 'projects';
	$this->load->view($this->_container,$data);

    }

       
    function newproject($id=0){
        $data['title'] = "Enter New Project";

        $data['header'] = "Enter New Project";
        // Set breadcrumb
        $this->bep_site->set_crumb('Enter New Project','projects/admin/enter_newproject');

        // get company name
        $id = $this->uri->segment(4);
        $data['name'] =  $this->MProject->getCompany($id);

        if ($this->input->post('project_name')){
        $id = $this->input->post('id');
	// fields filled up so,
	$this->MProject->enterNewProject();
	// CI way to set flashdata, but we are not using it
	// $this->session->set_flashdata('message','Product updated');
	// we are using Bep function for flash msg
	flashMsg('success','New project created.');
	redirect('projects/admin/projectlist/'.$id,'refresh');
        }else{
        // in order to avoid for an error when you click Create New Project
        // with no data, test if segment 4 is 0 or not
            if ($id !=0){
            // pull admin for 'by' dropdown field
            // where group = 2 from be_users table
                $member_id = 2;
                $data['administrators'] = $this->MProject->getMembersDropDown($member_id);

                // set active value to yes
                // Bep way to do it.
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


    function update_project($id=NULL){

        $id = $this->uri->segment(4);
        // if you are using TinyMCE here, load it.
         $this->bep_assets->load_asset_group('TINYMCE');
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
                    redirect('projects/admin/','refresh');
                }
                // $data['menus'] = $this->MMenus->getAllMenusDisplay();
                // Set breadcrumb
                $this->bep_site->set_crumb('Update Project','projects/admin/update_project');
                $data['module'] = 'projects';
                $this->load->view($this->_container,$data);
        }
            
    }


    function enterlog(){
        $data['title'] = "Enter Log";
	$data['header'] = "Enter Log";
	// Set breadcrumb
	$this->bep_site->set_crumb('Enter Log','projects/admin/enterlog');

        // if you are using TinyMCE here, load it.
         $this->bep_assets->load_asset_group('TINYMCE');
         
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

            $data['page'] = $this->config->item('backendpro_template_admin') . "log/admin_log_enter";
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

        $data['page'] = $this->config->item('backendpro_template_admin') . "log/admin_log_list";
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

        $data['page'] = $this->config->item('backendpro_template_admin') . "log/admin_log_details";
	$data['module'] = 'projects';
	$this->load->view($this->_container,$data);
    }


    function update_log($log_id = 0){
        
        //$customer_id = $this->uri->segment(4);
	//$project_id = $this->uri->segment(5);
        //$log_id = $this->uri->segment(6);

        //$data['customer'] = $this->MProject->getCompany($customer_id);
        // $data['records'] = $this->MProject->getProjectRecord($project_id);
        // if you are using TinyMCE here, load it.
        $this->bep_assets->load_asset_group('TINYMCE');

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
            $data['page'] = $this->config->item('backendpro_template_admin') . "log/admin_log_edit";
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
 * Used in views/admin_project_list.php
 * Don't let delete project if there are logs, files and specs. Do it in model
 */
	function delete_project($project_id = NULL){
		
                $project_id = $this->uri->segment(5);
		// check if there are any logs, files and specs
                // this will return a single array
                $checkproject = $this->MProject->checkproject($project_id);
                
                // check if the array is with data
                if($checkproject['link']==NULL && $checkproject['spec_desc']==NULL && $checkproject['date']==NULL ){
                    $this->MProject->deleteproject($project_id);
                    flashMsg('success','Project deleted.');
                }else{
                    flashMsg('warning','Project can\'t be deleted. There are either logs, files or specs. You need to delete them first.');
                }
                redirect('projects/admin/admin/','refresh');
               

	}




}//end class
?>
