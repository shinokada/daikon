<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MProjectfile extends Base_model{

	function MProjectfile(){
		parent::Base_model();
		$this->_TABLES = array( 'Files' => 'omc_files'
                                    );
	}

     /*
     *  Not used yet, not complete
     *
     */
    function getAllfiles(){
        $data = array();
	$this->db->select('omc_specs.id, omc_specs.completed, omc_specs.project_id,customer_id, project_name, omc_specs.active, company_name, spec_desc');
	$this->db->from('omc_specs');
        $this->db->join('omc_projects', 'omc_projects.id = omc_specs.project_id');
        $this->db->join('be_user_profiles', 'omc_projects.customer_id = be_user_profiles.user_id');
        $this->db->order_by('customer_id asc');
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
     * Used in class showfile()
     * get project files by project id
     */
    function getProjectfile($pro_id=NULL){
        $data = array();
        $this->db->select('*');
	$this->db->from('omc_files');
       // $this->db->join('omc_projects', 'omc_projects.id = omc_files.project_id');
        //$this->db->join('omc_projects', 'omc_projects.id = omc_specs.project_id');
        $this->db->where('project_id', $pro_id);
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
      * Used in method showfile()
      */
     function enterfile(){
       
            $data = array(
                'project_id' => $this->input->post('project_id'),
                'link' => $this->input->post('link'),
                'file_desc' => $this->input->post('file_desc'),
                'active' => $this->input->post('active'),
               
            );

            $this->db->insert('omc_files',$data);
     }


      /*
     * Used in updateFile()
     *
     */

    function updateFile(){
        $id = $this->input->post('id');

        $data = array(

            'project_id' => $this->input->post('project_id'),
            'link' => $this->input->post('link'),
            'file_desc' => $this->input->post('file_desc'),
            'active' => $this->input->post('active'),

            );
        $this->db->where('id',$id);
        $this->db->update('omc_files',$data);
    }


     /*
      * Used in update_file()
      */

    function getSigleFile($file_id=NULL){
        $data = array();
        $this->db->select('*');
	$this->db->from('omc_files');
        $this->db->where('id', $file_id);

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
* Used in delete_file()
*/

     function deletefile($id){
            $this->delete('Files',array('id'=>$id));
     }


   
}
