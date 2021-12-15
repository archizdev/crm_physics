<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Smsapi extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'Client_Model','Apiintegration_Model','dash_model'
		));
	}
    
         
	public function index()
	{
      if (user_role('56') == true) {
      }
		//$data['nav1']='nav5';
		$aid = $this->session->userdata('user_id');
		$api_for = 2;
		$data['title'] = 'Sms Api Integration' ;
			$data['page_title'] = 'SMS API';
		$data['api_list'] = $this->Apiintegration_Model->get_api_list($api_for);
        /*print_r($data['api_list']);
        exit();*/
        $data['products'] = $this->dash_model->get_user_product_list();

		$data['temp_list'] = $this->Apiintegration_Model->get_template_list($api_for);
		$data['content'] = $this->load->view('smsapi',$data,true);
		//$this->load->view('leads',$data);
		$this->load->view('layout/main_wrapper',$data);
	}
	
	
	public function api_details()
    {  
      if (user_role('56') == true) {
      }
    //$data['title'] = display('Enquiry Details');
    #------------------------------# 
    //$leadid = $this->uri->segment(3);
    
    //////////////////////////////////////////////////////
    if(!empty($_POST)){
    $apiid = $this->input->post('id');
    
    $api_name = $this->input->post('api_name');
    $api_url = $this->input->post('api_url');
    
     $api_key=explode(',',$this->input->post('key_for_mob'));
        if(!empty($api_key[0])){
           $key_for_msg=$api_key[0]; 
        }else{
          $key_for_msg=$api_key[0];  
        }
        
        if(!empty($api_key[1])){
           $key_for_mob=$api_key[1];
        }else{
           $key_for_mob=$api_key[1]; 
        }
    $this->db->set('api_name',$api_name);
    $this->db->set('api_url',$api_url);
    $this->db->set('key_moblie',$key_for_mob);
    $this->db->set('api_key',$key_for_msg);
    $this->db->where('api_id',$apiid);
    $this->db->update('api_integration');
    
    redirect('smsapi');
    }
    
    //////////////////////////////////////////////////////
    $api_for = 2;
    $data['title'] = 'SMS Api Integration'  ;	
    $data['api_list'] = $this->Apiintegration_Model->get_api_list($api_for);
    $data['temp_list'] = $this->Apiintegration_Model->get_template_list($api_for);
    
    $data['content'] = $this->load->view('smsapi', $data, true);
    $this->load->view('layout/main_wrapper',$data);
    }
    
    
    
    
    public function template_details()
    {  
      if (user_role('56') == true) {
      }
    //$data['title'] = display('Enquiry Details');
    #------------------------------# 
    //$leadid = $this->uri->segment(3);
    
    //////////////////////////////////////////////////////
    if(!empty($_POST)){
    $tmpid = $this->input->post('template_id');
    
    $template_name = $this->input->post('template_name');
    $template_content = $this->input->post('template_content');
    $process=$this->input->post('process');
    $template_id=$this->input->post('sms_template_id');
    $stage=$this->input->post('stage');
    $process =implode(',',$process);
    $stage =implode(',',$stage);
    // die();
    $this->db->set('stage',$stage);
    $this->db->set('process',$process);
    
    $this->db->set('template_name',$template_name);
    $this->db->set('template_content',$template_content);
    $this->db->set('sms_template_id',$template_id);
    
    $this->db->where('temp_id',$tmpid);
    $this->db->update('api_templates');
    
    redirect('smsapi');
    }
    
    //////////////////////////////////////////////////////
    $api_for = 2;
    $data['title'] = 'SMS Api Integration'  ;	
    $data['api_list'] = $this->Apiintegration_Model->get_api_list($api_for);
    $data['temp_list'] = $this->Apiintegration_Model->get_template_list($api_for);
    
    $data['content'] = $this->load->view('smsapi', $data, true);
    $this->load->view('layout/main_wrapper',$data);
    }

    
	
	
	
        public function createapi()
        {
         if (user_role('54') == true) {
         }
        if(!empty($_POST)){
        
        $api_name = $this->input->post('api_name');
        $api_type = $this->input->post('api_type');
        $api_url = $this->input->post('api_url');
        $api_key=explode(',',$this->input->post('key_for_mob'));
        if(!empty($api_key[0])){
           $key_for_msg=$api_key[0]; 
        }else{
          $key_for_msg=$api_key[0];  
        }
        
        if(!empty($api_key[1])){
           $key_for_mob=$api_key[1];
        }else{
           $key_for_mob=$api_key[1]; 
        }
        
        $data = array(
        'api_name' => $api_name,
        'api_url' => $api_url,
        'api_type' => $api_type,
        'api_key'=>$key_for_msg,
        'key_moblie'=>$key_for_mob,
        'api_addby' => $this->session->userdata('user_id'),
        'comp_id' => $this->session->userdata('companey_id'),
         'api_for' => 2
        
        );
        
        $insert_id = $this->Apiintegration_Model->addsmsapi($data);
        
        $this->session->set_flashdata('SUCCESSMSG','API Details Added Successfully');
        redirect('smsapi');
        
        }
        }



        
         public function createtemplate()
        {
         if (user_role('54') == true) {
         }
        if(!empty($_POST)){
        
        $template_name = $this->input->post('template_name');
        $template_content = $this->input->post('template_content');
        $process=$this->input->post('process');
        $stage=$this->input->post('stage');
        $template_id=$this->input->post('template_id');
        $process =implode(',',$process);
        $stage =implode(',',$stage);

        $data = array(
         'stage'=>$stage,
         'process'=>$process,
        'template_name' => $template_name,
        'template_content' => $template_content,
        'sms_template_id' => $template_id,
        //'api_type' => $api_type,
        'temp_addby' => $this->session->userdata('companey_id'),
        'comp_id' => $this->session->userdata('companey_id'),
         'temp_for' => 2
        
        );
        
        $insert_id = $this->Apiintegration_Model->addTemplates($data);
        
        $this->session->set_flashdata('SUCCESSMSG','Template Added Successfully');
        redirect('smsapi');
        
        }
        }
    
    
        public function delete_api(){
         if (user_role('57') == true) {
         }
        if(!empty($_POST)){
        $user_status=$this->input->post('user_status');
        foreach($user_status as $key){
        $this->db->where('api_id',$key);
        $query = $this->db->delete('api_integration');
        }
        }
        }
        
        public function delete_template(){
         if (user_role('57') == true) {
         }
        if(!empty($_POST)){
        $user_status=$this->input->post('sel_temp');
        foreach($user_status as $key){
        $this->db->where('temp_id',$key);
        $query = $this->db->delete('api_templates');
        }
        }
        }
	   
	
}