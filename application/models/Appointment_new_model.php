<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment_new_model extends CI_Model {

	var $column_order = array('schdl.schdl_dt','schdl.stm','tbl_admin.s_display_name','tbl_admin.s_phoneno','tbl_admin.s_user_email');
	var $column_search = array('schdl.schdl_dt','schdl.stm','tbl_admin.s_display_name','tbl_admin.s_phoneno','tbl_admin.s_user_email');

	public function read() {        
        $this->load->model('common_model');
        $all_reporting_ids    =   $this->common_model->get_categories($this->session->user_id);              
        $user_id = $this->session->user_id;
        $user_role = $this->session->user_role;
        $region_id = $this->session->region_id;
        $assign_country = $this->session->country_id;
        $assign_region = $this->session->region_id;
        $assign_territory = $this->session->territory_id;
        $assign_state = $this->session->state_id;
        $assign_city = $this->session->city_id;
        $this->db->select("*");
        $this->db->from($this->table);
        //$this->db->join('user', 'user.user_id = tbl_admin.companey_id');
        $this->db->join('tbl_user_role', 'tbl_user_role.use_id=tbl_admin.user_permissions', 'left');
		
        //$this->db->where('tbl_admin.companey_id',$this->session->companey_id); 
        // $this->db->where('tbl_admin.user_roles!=', 9);
        $where = "  tbl_admin.pk_i_admin_id IN (".implode(',', $all_reporting_ids).')';                
        $where .= "  AND tbl_admin.b_status=1";                                
        $this->db->where($where);

        /*if ($user_id >=3) {
          //$this->db->where('tbl_admin.companey_id',$this->session->companey_id);  
        }*/

        return $this->db->get()->result();
    }
	
public function staff_meet_insert($table, $arr){
		
		$this->db->insert($table, $arr);
		return $this->db->insert_id(); 
	}
	

function get_meettables()
    {
        $this->meet_get_datatables_query();

        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


	private function meet_get_datatables_query()
    {
       
        $this->db->from('tbl_internal_schdl as schdl');
        $user_id = $this->session->user_id;      

        $where = '';
        $this->db->select("schdl.schdl_dt,schdl.stm,tbl_admin.s_display_name as student,tbl_admin.s_phoneno,tbl_admin.s_user_email,schdl.schl_sts,schdl.zoin_status");             
        $this->db->join('tbl_admin', 'tbl_admin.pk_i_admin_id=schdl.stu_id', 'left');

                $filter_user_id = $this->session->filter_user_id;
                if($this->session->filter_user_id){
                    $where = " schdl.staff_id=$filter_user_id";

                }else{
                    $where .= " schdl.staff_id=$user_id";                
                }

                $this->db->where($where);
  

        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
public function count_all()
    {
        $this->db->from('tbl_internal_schdl as schdl');
        $this->db->join('tbl_admin', 'tbl_admin.pk_i_admin_id=schdl.stu_id', 'left');
        $filter_user_id = $this->session->filter_user_id;
        $user_id = $this->session->user_id;  
        $where='';

        if($this->session->filter_user_id){
            $where = " schdl.staff_id=$filter_user_id";
        }else{
            $where .= " schdl.staff_id=$user_id";                
        }

        $this->db->where($where);
        return $this->db->count_all_results();
    }
	
function count_filtered()
    {
        $this->meet_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
	
public function get_meet_calandar_feed($start,$end,$user_id=0){
        if (!$user_id) {
        $all_reporting_ids    =   $this->common_model->get_categories($this->session->user_id);              
            $user_id = $this->session->user_id;      
        }       
        $start = date("Y-m-d", strtotime($start));  
        $end = date("Y-m-d", strtotime($end));         

        $this->db->select("schdl.stm,tbl_admin.s_display_name as student,schdl.schdl_dt");
        $this->db->from('tbl_internal_schdl as schdl');
        $this->db->join('tbl_admin','tbl_admin.pk_i_admin_id=schdl.stu_id', 'left');
        $where = '';
            
    if($where){
            $where .= " AND (STR_TO_DATE(schdl.schdl_dt,'%Y-%m-%d') BETWEEN STR_TO_DATE('".$start."','%Y-%m-%d') AND  STR_TO_DATE('".$end."','%Y-%m-%d'))";            
        } else{
          $where .= " STR_TO_DATE(schdl.schdl_dt,'%Y-%m-%d') BETWEEN STR_TO_DATE('".$start."','%Y-%m-%d') AND  STR_TO_DATE('".$end."','%Y-%m-%d')";
        }
    if(!$user_id){
            $where .= "  AND schdl.staff_id IN (".implode(',', $all_reporting_ids).')';
        }else{
      $where .= " AND schdl.staff_id=$user_id";
        }

        $this->db->where($where);        
        $this->db->order_by('schdl.id', 'DESC');                
        $query = $this->db->get();
        return $query->result();
    }

public function search_meetby_id($date) {
        
        $user_id = $this->session->user_id;
        $user_role = $this->session->user_role;
        $date = date("Y-m-d", strtotime($date));
        $this->db->select("schdl.schdl_dt,schdl.stm,tbl_admin.s_display_name as student,tbl_admin.s_phoneno,tbl_admin.s_user_email,schdl.schl_sts,schdl.zoin_status");
        $this->db->from('tbl_internal_schdl as schdl');
       
        if($this->session->filter_user_id){                                
            $this->db->where('schdl.staff_id',$this->session->filter_user_id);
        }else{
            $this->db->where('schdl.staff_id',$user_id);
        }

        $this->db->join('tbl_admin', 'tbl_admin.pk_i_admin_id=schdl.stu_id', 'left');
        $this->db->where('schdl.schdl_dt',$date);
        $this->db->order_by('schdl.id', 'DESC');
        $query = $this->db->get();
        return $query->result();

    }


 }


