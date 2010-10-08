<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MProject extends Base_model{

    function MProject(){
        parent::Base_model();
	$this->_TABLES = array( 
                            'Table' => 'omc_projects',
                            'Logs' =>'omc_logs'
                            );
    }

    /*
     *
     *
     */
    function getCustomersProfile($id=NULL){
        $data = array();
	$this->db->select('user_id, company_name');
	$this->db->from('be_user_profiles');
	// $this->db->join('be_users', 'be_users.id = be_user_profiles.user_id');
        // $this->db->join('omc_projects', 'omc_projects.customer_id = be_users.id');
	$this->db->where('user_id', $id);

	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                            
                $data[$row['user_id']] = $row['company_name'];
            }
        }
        $query->free_result();
        return $data;

    }


    /*
     * Used in class index in order to list user_id and comany name.
     *
     */
    function getAllCustomersProfile($id=NULL){
        $data = array();
	$this->db->select('*');
	$this->db->from('be_user_profiles');
	$this->db->join('be_users', 'be_users.id = be_user_profiles.user_id');
        // next line shows company which has only project
        // $this->db->join('omc_projects', 'omc_projects.customer_id = be_users.id');
	$this->db->where('be_users.group', $id);
        $this->db->order_by("user_id", "asc");
	$query = $this->db->get();
	if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $data[$row['user_id']] = $row['company_name'];
            }
        }
        $query->free_result();
        return $data;
    }


    /*
     * Used in class projectlist
     *
     */
    function getProjectList($cus_id=NULL){
        $data = array();
        $this->db->select('*');
	$this->db->from('omc_projects');
        $this->db->join('be_user_profiles', 'omc_projects.customer_id = be_user_profiles.user_id');
        $this->db->where('customer_id', $cus_id);
        $this->db->order_by('customer_id asc');
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
     * Ths is used in admin/index.php. This pulls out data and order by company_name with array
     * 
     */
    function getAllProjects(){
        $data = array();
	$this->db->select('id, customer_id, project_name, active, company_name, total_hr');
	$this->db->from('omc_projects');
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
     * Find company name and other details from segment(4)
     * Used in method projectlist(), enterlog()
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
     * Used in projectlist()
     */
     function getProjectRecord($id=NULL){
            $data = array();
            // when you use fetch which is BEP function, you must use Table
            // which you define in the contructor
            $Q = $this->fetch('Table',NULL ,NULL ,array('id'=>$id));
            if ($Q->num_rows() > 0){
                $data = $Q->row_array();
            }
            $Q->free_result();
            return $data;
     }


     /*
      * Used in method newproject()
      */
     function enterNewProject(){
            $data = array(
                'customer_id' => $this->input->post('id'),
                'project_name' => $this->input->post('project_name'),
                'total_hr' => $this->input->post('total_hr'),
                'note' => $this->input->post('note'),
                'created_by' => $this->input->post('created_by'),
                'active' => $this->input->post('active'),

            );

            $this->db->insert('omc_projects',$data);
     }


     /*
      * Used in update_project()
      */
      function updateProject($id){
            $data = array(
                'customer_id' => $this->input->post('customer_id'),
                'project_name' => $this->input->post('project_name'),
                'total_hr' => $this->input->post('total_hr'),
                'active' => $this->input->post('active'),
                'note' => $this->input->post('note'),
                'created_by' => $this->input->post('created_by'),
            );
            $id = $this->input->post('id');
            $this->update('Table',$data,array('id'=>$id));

     }

    /*
     * Used in enterlog()
     *
     */

    function enterLog(){
        // use STR_TO_DATE function to convert European way dd-mm-yy to MySQL way yyyy-mm-dd
        $eurodate = $this->input->post('date');
        $newdate = new DateTime($eurodate);
        $sqldate = $newdate->format('Y-m-d');
        $data = array(
            'project_id'=>$this->input->post('project_id'),
            'date' => $sqldate,
            'start_time' => $this->input->post('start_time'),
            'finish_time' => $this->input->post('finish_time'),
            'active' => $this->input->post('active'),
            'log_entered_by' => $this->input->post('log_entered_by'),
            'short_desc' => $this->input->post('short_desc'),
            'note' => $this->input->post('note'),
            );

		$this->db->insert('omc_logs',$data);
	 }

    

/*
 * Used in showlog(), show all log details in an array
 */


    function getlogs($id){
        $data = array();
        // This is another way to put time with HH:MM format
        // If you are using the following method, you need to modify view admin_log_list.php
       /*
        $Q = $this->db->query("SELECT id,
        DATE_FORMAT(date, '%d-%m-%Y'),
        active, log_entered_by, short_desc, note,
        TIME_FORMAT(start_time, '%H:%i'),
        TIME_FORMAT(finish_time, '%H:%i') FROM omc_logs WHERE project_id=$id");
*/
        // display logs ordered by date
        
        $this->db->select('*');
        $this->db->order_by('date desc, start_time desc');
        $Q = $this->db->get_where('omc_logs', array('project_id'=>$id));

       
        // $Q = $this->fetch('Logs','*',NULL ,array('project_id'=>$id));
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }


    /*
     * Used in showlog()
     */
    function calTotalTime($project_id){
        $data = 0;
        $total_diff = 0;
        $Q = $this->fetch('Logs','*',NULL ,array('project_id'=>$project_id));
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
               
                    $total_diff += strtotime($row['finish_time']) - strtotime($row['start_time']);
             
                $data = $total_diff;
            }
        }
        $Q->free_result();
        return $data;
    }


    /*
     * Used in logdetails(). collect one log entry
     */

    function getSingleLog($id){
        $data = array();
        $Q = $this->fetch('Logs','*',1 ,array('id'=>$id));
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data = $row;
            }
        }
        $Q->free_result();
        return $data;

    }



    /*
     * Used in update_log()
     *
     */

    function updateLog(){
        $id = $this->input->post('id');
        // use STR_TO_DATE function to convert European way dd-mm-yy to MySQL way yyyy-mm-dd
        $eurodate = $this->input->post('date');
        $newdate = new DateTime($eurodate);
        $sqldate = $newdate->format('Y-m-d');
        $data = array(
            
            'project_id'=>$this->input->post('project_id'),
            'date' => $sqldate,
            'start_time' => $this->input->post('start_time'),
            'finish_time' => $this->input->post('finish_time'),
            'active' => $this->input->post('active'),
            'log_entered_by' => $this->input->post('log_entered_by'),
            'short_desc' => $this->input->post('short_desc'),
            'note' => $this->input->post('note'),
            );
        $this->db->where('id',$id);
        $this->db->update('omc_logs',$data);
    }


/*
 * Used in delete_log()
 */

	 function deletelog($id){
	 	$this->delete('Logs',array('id'=>$id));
	 }



/*
 * Used in projects/admin/admin.php
 */
         function checkproject($id){
            $data = array();
            /*
            $sql = 'SELECT omc_projects.id, omc_specs.id, omc_logs.id, omc_files.id
                        FROM omc_projects
                        LEFT OUTER JOIN omc_specs ON omc_specs.project_id = omc_projects.id
                        LEFT OUTER JOIN omc_logs   ON omc_logs.project_id = omc_projects.id
                        LEFT OUTER JOIN omc_files ON omc_files.project_id = omc_projects.id
                        WHERE omc_projects.id = $id';
            $query = $this->db->query($sql);

            */

            $this->db->select('omc_files.link, omc_logs.date, omc_specs.spec_desc, omc_projects.project_name');
            $this->db->from('omc_projects');
            $this->db->join('omc_specs', 'omc_specs.project_id = omc_projects.id','left outer');
            $this->db->join('omc_logs', 'omc_logs.project_id = omc_projects.id','left outer');
            $this->db->join('omc_files', 'omc_files.project_id = omc_projects.id','left outer');
            $this->db->where('omc_projects.id', $id);
            $query = $this->db->get();
              

            
            if ($query->num_rows() > 0){
                foreach ($query->result_array() as $row){
                   $data = $row;
                }
            }else{
                $data = FALSE;
            }
            $query->free_result();
            return $data;

         }



/*
 * Used in projects/admin/admin.php
 */
         function deleteproject($id){
            $this->delete('Table',array('id'=>$id));

         }








/*
 * Not used yet
 */

        




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


        /*
         * Used in method newproject()
         *
         */
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

	



}
