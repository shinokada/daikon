<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
  function Admin(){
   	parent::Admin_Controller();
		   // Check for access permission
			check('Customers Admin');
			// Load models and language
			$this->load->model('MSupport');
			$this->load->module_model('auth','User_model');
			$this->load->language('customer');
			// Set breadcrumb
			$this->bep_site->set_crumb($this->lang->line('customer_support_admin'),'support/admin');	
	}
  

	function index(){
			// we use the following variables in the view
			$data['title'] = "Customer Page";
			
			// get members details where group = 1 or not 2 from be_users
			$id = 1;
			$data['support_customers'] = $this->MSupport->getAllMemberProfile($id);
			$data['header'] = $this->lang->line('customer_support');
			
			// This how Bep load views
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_support_home";
			$data['module'] = 'support';
			$this->load->view($this->_container,$data); 
	}
  
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
	
	
	
	function enter_newcredit($id=0){
		$data['title'] = "Enter Credit";
		
		$data['header'] = $this->lang->line('customer_enter_credit');
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('customer_enter_credit'),'support/admin/newcredit');
		
		$data['id'] = $this->uri->segment(4);
		
		if ($this->input->post('point_credit')){
			$id = $this->input->post('id');
	  		// fields filled up so,
	  		$this->MSupport->enter_credit();
	  		// CI way to set flashdata, but we are not using it
	  		// $this->session->set_flashdata('message','Product updated');
	  		// we are using Bep function for flash msg
	  		flashMsg('success','Credit entered');
	  		redirect('support/admin/customer_record/'.$id,'refresh');
	  	}else{
	  		// pull admin for 'by' dropdown field
			// where group = 2 from be_users table
	  		$member_id = 2;
	  		$data['administrators'] = $this->MSupport->getMembersDropDown($member_id);
	  		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_enter_credit";
	  		// This how Bep load views
			$data['module'] = 'support';
			$this->load->view($this->_container,$data);
	  	}
		
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
	
	
	function delete_record($id = NULL){
		$customer_id = $this->uri->segment(4);
		$id = $this->uri->segment(5);
		$this->MSupport->deleteRecord($id);
		flashMsg('success','Record deleted');
		redirect('support/admin/customer_record/'.$customer_id,'refresh');
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
