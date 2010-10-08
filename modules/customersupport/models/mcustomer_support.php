<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MCustomer_support extends Base_model{

	function MCustomer_support(){
		parent::Base_model();
		$this->_TABLES = array( 'web_customer' => 'web_customer',
								'support_details' => 'support_details'
                                    );
	}
	
	
	function getAllCustomerRecordByUsername($username){
		$data = array();
		$this->db->select('support_details.customer_id, support_details.date, support_details.time, support_details.point_credit, support_details.note
		, support_details.id, support_details.details, support_details.by, be_users.username, be_users.group');
		$this->db->from('support_details');
		$this->db->join('be_users', 'be_users.id = support_details.customer_id');
		$this->db->where('be_users.username', $username);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
	       foreach ($query->result_array() as $row){
	         $data[]=$row;
	       }
	    }
	    $query->free_result();  
	    return $data; 
		
	}
	
	function totalColumn($username,$column){
		$data = array();
		$this->db->select_sum($column);
		$this->db->from('support_details');
		$this->db->join('be_users', 'be_users.id = support_details.customer_id');
		$this->db->where('be_users.username', $username);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
	       foreach ($query->result_array() as $row){
	         $data=$row;
	       }
	    }
	    $query->free_result();  
	    return $data; 	    
	}
	
	
	function getRecordDetails($id, $customer_id){
		$data = array();
		$query = $this->fetch('support_details','*',NULL,array('id'=> $id, 'customer_id'=>$customer_id));
		 if ($query->num_rows() > 0){
	      	$data = $query->row_array();
	    }
	    $query->free_result();    
	    return $data;
	}
	
	
	function admingetRecordDetails($id){
		$data = array();
		$query = $this->fetch('support_details','*',NULL,array('id'=> $id));
		 if ($query->num_rows() > 0){
	      	$data = $query->row_array();
	    }
	    $query->free_result();    
	    return $data;
	}
	
	
	function getSingleMemberProfileByUsername($username){
		$data = array();
		$this->db->from('be_user_profiles');
		$this->db->join('be_users', 'be_users.id = be_user_profiles.user_id');
		$this->db->where('be_users.username', $username);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
	       foreach ($query->result_array() as $row){
	         $data[]=$row;
	       }
	    }
	    $query->free_result();  
	    return $data; 	    
		
	}
	
	
	function getCustomerGroupByUsername($username){
		$data = array();
		$this->db->select('group')->from('be_users')->where('username', $username);
		$query = $this->db->get();
		
		 if ($query->num_rows() > 0){
	      	$data = $query->row_array();
	    }
	    $query->free_result();    
	    return $data;
	}
	
}
