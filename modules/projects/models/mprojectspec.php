<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MProjectspec extends Base_model{

	function MProjectspec(){
		parent::Base_model();
		$this->_TABLES = array( 'Specs' => 'omc_specs'
                                    );
	}

     /*
     * Ths is used in admin/adminspec/index. This pulls out data and order by company_name with array
     *
     */
    function getAllSpecs(){
        $data = array();
	$this->db->select('omc_specs.id, omc_specs.completed, omc_specs.project_id,customer_id, project_name, omc_specs.active, company_name, spec_desc');
	$this->db->from('omc_specs');
        $this->db->join('omc_projects', 'omc_projects.id = omc_specs.project_id');
        $this->db->join('be_user_profiles', 'omc_projects.customer_id = be_user_profiles.user_id');
        $this->db->order_by('customer_id asc, project_id asc');
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $data[$row['company_name']][] = $row;
            }
        }
        $query->free_result();
        return $data;

    }


    /*
     * Used in class showspec
     *
     */
    function getProjectSpec($pro_id=NULL){
        $data = array();
        $this->db->select('*');
	$this->db->from('omc_projects');
        $this->db->join('omc_specs', 'omc_projects.id = omc_specs.project_id');
        //$this->db->join('omc_projects', 'omc_projects.id = omc_specs.project_id');
        $this->db->where('omc_projects.id', $pro_id);
        // $this->db->order_by('project_id asc');
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $data[]=$row;
            }
        }
        $query->free_result();
        return $data;
    }


    /*
     * segment are different from project/admin/admin.php
     * Find company name and other details from segment(5)
     * 
     */
    function getCompany($id=NULL){
        $data = array();
	$this->db->select('*');
	$this->db->from('be_user_profiles');
        $this->db->where('user_id', $id);
	$query = $this->db->get();
	if ($query->num_rows() > 0){
                foreach ($query->result_array() as $row){
                $data=$row;
                }
        }
        $query->free_result();
        return $data;
    }


    /*
     * Used in showspec() in adminspec.php
     */

    function getProject($project_id){
        $data = array();
	$this->db->select('*');
	$this->db->from('omc_projects');
        $this->db->where('id', $project_id);
	$query = $this->db->get();
	if ($query->num_rows() > 0){
                foreach ($query->result_array() as $row){
                $data=$row;
                }
        }
        $query->free_result();
        return $data;
    }


      /*
      * Used in method showspec()
      */
     function enterspec(){
        // use STR_TO_DATE function to convert European way dd-mm-yy to MySQL way yyyy-mm-dd
        $eurodatecreated = $this->input->post('date_created');
        $newdatecreated = new DateTime($eurodatecreated);
        $sqldatecreated = $newdatecreated->format('Y-m-d');
        if($this->input->post('date_completed')){
            $eurodatecompleted = $this->input->post('date_completed');
            $newdatecompleted = new DateTime($eurodatecompleted);
            $sqldatecompleted = $newdatecompleted->format('Y-m-d');
        }else{
            $sqldatecompleted= NULL;

        }
        // some values can be NULL
        $completed_by = $this->input->post('completed_by');
        if($completed_by){

             $completed_by = $this->input->post('completed_by');

        }else{

            $completed_by= NULL;
        }

            $data = array(
                'project_id' => $this->input->post('project_id'),
                'spec_desc' => $this->input->post('spec_desc'),
                'spec_details' => $this->input->post('spec_details'),
                'created_by' => $this->input->post('created_by'),
                'date_created' => $sqldatecreated,
                'completed' => $this->input->post('completed'),
                'active' => $this->input->post('active'),
                'date_completed' => $sqldatecompleted,
                'completed_by' => $completed_by,
                'spec_details' => $this->input->post('spec_details'),
            );

            $this->db->insert('omc_specs',$data);
     }


     /*
      * Used in update_spec()
      */

    function getSigleSpec($spec_id=NULL){
        $data = array();
        $this->db->select('*');
	$this->db->from('omc_specs');
        //$this->db->join('omc_specs', 'omc_projects.id = omc_specs.project_id');
        //$this->db->join('omc_projects', 'omc_projects.id = omc_specs.project_id');
        $this->db->where('id', $spec_id);
       
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $data=$row;
            }
        }
        $query->free_result();
        return $data;
    }



    /*
     * Used in updateSpec()
     *
     */

    function updateSpec(){
        $id = $this->input->post('id');
        // use STR_TO_DATE function to convert European way dd-mm-yy to MySQL way yyyy-mm-dd
        $eurodatecreated = $this->input->post('date_created');
        $newdatecreated = new DateTime($eurodatecreated);
        $sqldatecreated = $newdatecreated->format('Y-m-d');

        // use STR_TO_DATE function to convert European way dd-mm-yy to MySQL way yyyy-mm-dd
        $eurodatecompleted = $this->input->post('date_completed');
        $newdatecompleted = new DateTime($eurodatecompleted);
        $sqldatecompleted = $newdatecompleted->format('Y-m-d');

        $data = array(

            'project_id'=>$this->input->post('project_id'),
            'spec_desc'=>$this->input->post('spec_desc'),
            'spec_details'=>$this->input->post('spec_details'),
            'created_by'=>$this->input->post('created_by'),
            'date_created'=>$sqldatecreated,
            'completed'=>$this->input->post('completed'),
            'date_completed' => $sqldatecompleted,
            'completed_by'=>$this->input->post('completed_by'),
            'active'=>$this->input->post('active'),

            );
        $this->db->where('id',$id);
        $this->db->update('omc_specs',$data);
    }


/*
* Used in delete_spec()
*/

     function deletespec($id){
            $this->delete('Specs',array('id'=>$id));
     }


}
