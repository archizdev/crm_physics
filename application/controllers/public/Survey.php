<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Survey extends CI_Controller {
    public function __construct() {
        parent::__construct();
   }
	
	public function form($tid,$comp_id,$enquiry_code,$uid,$for=1){    
        $tid            =   base64_decode($tid); 
        $comp_id        =   base64_decode($comp_id); 
        $enquiry_code   =   base64_decode($enquiry_code); 
        $uid            =   base64_decode($uid); 
        $this->db->select('*,input_types.title as input_type_title');         
        $this->db->where('tbl_input.form_id',$tid);           
        $this->db->where('tbl_input.company_id',$comp_id);            
        $this->db->join('input_types','input_types.id=tbl_input.input_type');
        $data['form_fields']    = $this->db->get('tbl_input')->result_array();        
        $data['form_row']    =   $this->db->where('id',$tid)->get('forms')->row_array();        
        //$data['dynamic_field']  = $ci->enquiry_model->get_dyn_fld($enquiry_id,$tid);
        $data['tid']            = $tid;
        $data['comp_id']            = $comp_id;
        $data['enquiry_code']   = $enquiry_code;
        $data['uid']            = $uid;
        if($for == 1){            
            $enquiry_row    =   $this->db->where('Enquery_id',$enquiry_code)->get('enquiry')->row_array();
            $data['enquiry_id']  = $enquiry_id  =   $enquiry_row['enquiry_id'];            
            $data['url']    = base_url().'public/survey/survery_form_submit/'.$enquiry_id;
        }else if($for == 2){            
            $enquiry_row    =   $this->db->where('ticketno',$enquiry_code)->get('tbl_ticket')->row_array();
            $data['enquiry_id']  = $enquiry_id   =   $enquiry_row['id'];
            $data['url']    = base_url().'public/survey/survery_support_form_submit/'.$enquiry_id;
        }
        $this->load->view('forms/public_form',$data);
    }
    public function survery_support_form_submit($tck_id){
        if($this->session->submitted){
            echo '<h4 style="text-align: center;">Thanks for your feedback</h4';
            exit();
        }
        if(empty($_POST)){
            exit();
        }
        $tid   =   $this->input->post('tid');
        $user_id    =   $this->input->post('uid');
        $form_type    =   $this->input->post('form_type');
        $comp_id    =   $this->input->post('comp_id');
        $enqarr = $this->db->select('*')->where('id',$tck_id)->get('tbl_ticket')->row();
        $en_comments = $enqarr->ticketno;
        $type = $enqarr->status;
        $this->load->model('Ticket_Model');
       $comment_id = $this->Ticket_Model->saveconv($tck_id,'Ticket Updated','', $enqarr->client,$user_id);       
        if(!empty($enqarr)){        
            if(isset($_POST['inputfieldno'])) {                    
                $inputno   = $this->input->post("inputfieldno", true);
                $enqinfo   = $this->input->post("enqueryfield", true);
                $inputtype = $this->input->post("inputtype", true);                
                $file_count = 0;                
                $file = !empty($_FILES['enqueryfiles'])?$_FILES['enqueryfiles']:'';                
                foreach($inputno as $ind => $val){
	
                 if ($inputtype[$ind] == 8) {                                                
                        $file_data    =   $this->doupload($file,$file_count);
                        if (!empty($file_data['imageDetailArray']['file_name'])) {
                            $file_path = base_url().'uploads/ticket_documents/'.$comp_id.'/'.$file_data['imageDetailArray']['file_name'];
                            $biarr = array( 
                                            "enq_no"  => $en_comments,
                                            "input"   => $val,
                                            "parent"  => $tck_id, 
                                            "fvalue"  => $file_path,
                                            "cmp_no"  => $comp_id,
                                            "comment_id" => $comment_id
                                        );
                            $this->db->where('enq_no',$en_comments);        
                            $this->db->where('input',$val);        
                            $this->db->where('parent',$tck_id);
                            if($this->db->get('ticket_dynamic_data')->num_rows())
                            {
                                if ($form_type == 1) {
                                    $this->db->insert('ticket_dynamic_data',$biarr);                                       
                                }else{                                    
                                    $this->db->where('enq_no',$en_comments);        
                                    $this->db->where('input',$val);        
                                    $this->db->where('parent',$tck_id);
                                    $this->db->set('fvalue',$file_path);
                                    $this->db->set('comment_id',$comment_id);
                                    $this->db->update('ticket_dynamic_data');
                                }
                            }else{
                                $this->db->insert('ticket_dynamic_data',$biarr);	
                            }         
                        }
                        $file_count++;          
                    }else{
                        $biarr = array( "enq_no"  => $en_comments,
                                      "input"   => $val,
                                      "parent"  => $tck_id, 
                                      "fvalue"  => $enqinfo[$val],
                                      "cmp_no"  => $comp_id,
                                      "comment_id" => $comment_id
                                     );                                 
                        $this->db->where('enq_no',$en_comments);        
                        $this->db->where('input',$val);        
                        $this->db->where('parent',$tck_id);
                        if($this->db->get('ticket_dynamic_data')->num_rows()){  
                            if ($form_type == 1) {
                                $this->db->insert('ticket_dynamic_data',$biarr);                                       
                            }else{                                                              
                                $this->db->where('enq_no',$en_comments);        
                                $this->db->where('input',$val);        
                                $this->db->where('parent',$tck_id);
                                $this->db->set('fvalue',$enqinfo[$val]);
                                $this->db->set('comment_id',$comment_id);
                                $this->db->update('ticket_dynamic_data');
                            }
                        }else{
                            $this->db->insert('ticket_dynamic_data',$biarr);
                        }
                    }                                      
                } //foreach loop end               
            }            
             
        }
        echo '<h4 style="text-align: center;">Thanks for your feedback</h4';
        $this->session->userdata('submitted',true);
    }
    public function survery_form_submit($enquiry_id){  
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";
*/
        $this->load->model('Leads_Model');              
        $tid    =   $this->input->post('tid');
        $form_type    =   $this->input->post('form_type');
        $user_id    =   $this->input->post('uid');
        $enqarr = $this->db->select('*')->where('enquiry_id',$enquiry_id)->get('enquiry')->row();
        $en_comments = $enqarr->Enquery_id;
        $type = $enqarr->status;           
        $comment_id = $this->Leads_Model->add_comment_for_events_stage_api('Survery submitted', $en_comments,'','','',$user_id,$comment_type=0);     
        if(!empty($enqarr)){
            if(isset($_POST['inputfieldno'])) {
                $inputno   = $this->input->post("inputfieldno", true);
                $enqinfo   = $this->input->post("enqueryfield", true);
                $inputtype = $this->input->post("inputtype", true);
                $file_count = 0;                
                $file = !empty($_FILES['enqueryfiles'])?$_FILES['enqueryfiles']:'';                
                foreach($inputno as $ind => $val){
                 if ($inputtype[$ind] == 8) {
                 }else{
                        $biarr = array( "enq_no"  => $en_comments,
                                      "input"   => $val,
                                      "parent"  => $enquiry_id, 
                                      "fvalue"  => $enqinfo[$val],
                                      "cmp_no"  => $this->input->post('comp_id'),
                                      "comment_id" => $comment_id
                                     );                                 
                        $this->db->where('enq_no',$en_comments);        
                        $this->db->where('input',$val);        
                        $this->db->where('parent',$enquiry_id);
                        if($this->db->get('extra_enquery')->num_rows()){  
                            if ($form_type == 1) {
                                $this->db->insert('extra_enquery',$biarr);
                            }else{                                        
                                $this->db->where('enq_no',$en_comments);
                                $this->db->where('input',$val);        
                                $this->db->where('parent',$enquiry_id);
                                $this->db->set('fvalue',$enqinfo[$val]);
                                $this->db->set('comment_id',$comment_id);
                                $this->db->update('extra_enquery');
                            }
                        }else{
                            $this->db->insert('extra_enquery',$biarr);
                        }
                    }                                      
                } //foreach loop end               
            }            
        }        
        echo '<h4 style="text-align: center;">Thanks for your feedback</h4';
    }
}