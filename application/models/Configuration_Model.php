<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Configuration_Model extends CI_Model {

    

        

		public function get_integration_list($aid)

        {

                /*$query = $this->db->get('website_integration');

                return $query->result();*/

               

                $this->db->select(" * ");

                $this->db->from('website_integration');

                
                $this->db->where('comp_id',$this->session->companey_id);
                
                $this->db->where('integration_type',$aid);

                $query = $this->db->get();

                return $query->result();

        }
		
		public function get_dyn_fld($compid,$where='')
        {     
                $this->db->select("*");
                $this->db->from('tbl_input');             
                if($where){
                    $this->db->where($where);
                }  
                $this->db->where('company_id',$compid);                                
                $this->db->where('status',1);            
                $query = $this->db->get();
                return $query->result_array();
        }

        

        

        public function get_portalintegration_list($aid)

        {

                /*$query = $this->db->get('website_integration');

                return $query->result();*/

               

                $this->db->select(" * ");

                $this->db->from('portals');

                

                $this->db->where('portal_type',$aid);

                $query = $this->db->get();

                return $query->result();

        }

        

        

       

		

        public function website_integrate($data)

        {

         $this->db->insert('website_integration', $data); 

         

        }

        

        public function web_enquiry($data)

        {

        $insid = $this->db->insert('enquiry', $data); 
         $insid = $this->db->insert_id();
		 return $insid;
         

        }

        

        

        public function delete_integration($integration = null)

        {

        $this->db->where('wid',$integration)

        ->delete('website_integration');

        

        if ($this->db->affected_rows()) {

        return true;

        } else {

        return false;

        }

        }

		

		

		///////////////////////// PORTAL INTEGRATION ////////////////////

		

		public function delete_portalintegration($pintegration = null)

        {

        $this->db->where('portal_id',$pintegration)

        ->delete('portals');

        

        if ($this->db->affected_rows()) {

        return true;

        } else {

        return false;

        }

        }

		

		public function portal_integrate($data)

        {

         $this->db->insert('portals', $data); 

         

        }

		

}