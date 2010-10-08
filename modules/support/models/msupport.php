<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MSupport extends Base_model{

	function MSupport(){
		parent::Base_model();
		$this->_TABLES = array( 'support_details' => 'support_details'
                                    );
	}
	
	
	function getCustomer($id){
	    $data = array();
	    
	    $Q = $this->fetch('be_users','*',1,array('id'=>$id));
	    if ($Q->num_rows() > 0){
	      	$data = $Q->row_array();
	    }
	    $Q->free_result();    
	    return $data;    
	}
	
	
	 function getAllCustomerRecord($id){
	 	$data = array();
	    $this->db->where('customer_id', $id);
	    $Q = $this->db->get('support_details');
	    if ($Q->num_rows() > 0){
	       	foreach ($Q->result_array() as $row){
	        $data[] = $row;
	      }
	    }
	    $Q->free_result();    
	    return $data;  
	 	
	 }
	 
	 function totalColumn($id, $column){
	 	$data = array();
	 	$this->db->select_sum($column);
	    $this->db->where('customer_id', $id);
	    $Q = $this->db->get('support_details');
	    if ($Q->num_rows() > 0){
	       	 $data = $Q->row(); 
	      }
	    
	    $Q->free_result(); 
	    return $data;  
	 	
	 }
	 
	 function enter_credit(){
	 	$data = array( 
			'customer_id' => $this->input->post('id'),
			'date' => $this->input->post('date'),
			'point_credit' => $this->input->post('point_credit'),
			'note' => $this->input->post('note'),
	 		'by' => $this->input->post('by'),
			
		);
		
		$this->insert('support_details',$data);	
	 }
	 
	 
 	function enter_workdone(){
	 	$data = array( 
			'customer_id' => $this->input->post('id'),
			'date' => $this->input->post('date'),
			'time' => $this->input->post('time'),
			'note' => $this->input->post('note'),
	 		'details' => $this->input->post('details'),
	 		'by' => $this->input->post('by'),
			
		);
		
		$this->insert('support_details',$data);	
	 }
	
	 
	function getMembers($id){
		// admin id is 2 and member id is 1
	     $data = array();
	     $this->db->select('id,username');
	     $this->db->where('group', $id);
	     $Q = $this->db->get('be_users');
	     if ($Q->num_rows() > 0){
	       foreach ($Q->result_array() as $row){
	         $data[]=$row;
	       }
	    }
	    $Q->free_result();  
	    return $data; 
	 } 
	 
	
	function getAllMemberProfile($id=NULL){
		$data = array();
		$this->db->select('*');
		$this->db->from('be_user_profiles');
		$this->db->join('be_users', 'be_users.id = be_user_profiles.user_id');
		$this->db->where('be_users.group', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
	       foreach ($query->result_array() as $row){
	         $data[]=$row;
	       }
	    }
	    $query->free_result();  
	    return $data; 
		
	} 
	 
	
	function getSingleMemberProfile($id=NULL){
		$data = array();
		$this->db->select('*');
		$this->db->from('be_user_profiles');
		$this->db->join('be_users', 'be_users.id = be_user_profiles.user_id');
		$this->db->where('be_user_profiles.user_id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
	       foreach ($query->result_array() as $row){
	         $data[]=$row;
	       }
	    }
	    $query->free_result();  
	    return $data; 
		
	} 
	 
	 
	function getMembersDropDown($id){
		// admin id is 2 and member id is 1
	     $data = array();
	     $this->db->select('id,username');
	     $this->db->where('group', $id);
	     $Q = $this->db->get('be_users');
	     if ($Q->num_rows() > 0){
	       foreach ($Q->result_array() as $row){
	         $data[$row['username']] = $row['username'];
	       }
	    }
	    $Q->free_result();  
	    return $data; 
	 }
	 
	// not used delete 
	function getAdminsDropDown(){
	     $data = array();
	     $admin= 2;
	     $this->db->select('id,username');
	     $this->db->where('group', $admin);
	     $Q = $this->db->get('be_users');
	     if ($Q->num_rows() > 0){
	       foreach ($Q->result_array() as $row){
	         $data[$row['username']] = $row['username'];
	       }
	    }
	    $Q->free_result();  
	    return $data; 
	 }
	 
	 function getRecord($id){
	 	$data = array();
	    $Q = $this->fetch('support_details',NULL ,NULL ,array('id'=>$id));
	    if ($Q->num_rows() > 0){
	      	$data = $Q->row_array();
	    }
	    $Q->free_result();    
	    return $data;    
	 }
	 
	 
	 function updateRecord($id){
	 	$data = array( 
			'date' => $this->input->post('date'),
			'time' => $this->input->post('time'),
			'point_credit' => $this->input->post('point_credit'),
			'note' => $this->input->post('note'),
			'details' => $this->input->post('details'),
			'by' => $this->input->post('by'),
			
		);
		$id = $this->input->post('id');
		$this->update('support_details',$data,array('id'=>$id));
	 	
	 }
	 
	 function deleteRecord($id){
	 	$this->delete('support_details',array('id'=>$id));
	 }
	 
}
