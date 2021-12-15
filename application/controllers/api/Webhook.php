<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Webhook extends REST_Controller {
    function __construct()
    {
        parent::__construct();
           $this->load->database();
           $this->load->library('form_validation');
            
        $this->load->model(array(
            'enquiry_model','Leads_Model','location_model','Task_Model','User_model','Message_models','Client_Model'
        ));
        
        $this->load->library('email'); 
   // $this->lang->load('notifications_lang', 'english');   
        
           $this->load->helper('url');
           $this->methods['users_get']['limit'] = 500; 
           $this->methods['users_post']['limit'] = 100; 
           $this->methods['users_delete']['limit'] = 50; 
        /*   header('Content-type: application/json');
        header('Access-Control-Allow-Origin', '*');
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header('Access-Control-Allow-Headers', 'Content-Type');*/
    }
    public function call_post()
    {
        $users='';
        $call_data = $_POST['myoperator'];
        $call_data_array = json_decode($call_data);
        $FIREBASE = "https://new-crm-f6355.firebaseio.com/";
        $uid=str_replace('.','_',$call_data_array->uid);
        $call_state=$call_data_array->call_state;
        if(!empty($call_data_array->users)){
        $users=$call_data_array->users;
        $this->db->set('users',$users);
        }
        
        $phone=$call_data_array->clid;
        $uid1=str_replace('.','_',$uid);
        $this->db->set('json_data',$call_data);
        $this->db->set('uid',$call_data_array->uid);
        $this->db->set('cll_state',$call_state);
        $this->db->set('phone_number',$phone);
        $this->db->insert('tbl_col_log');
        $insert_id = $this->db->insert_id();
        //  if($call_state=3 || $call_state=5){
            $NODE_PUT ="users/".$insert_id.".json";
        $data = array(
        'user_phone'=>$phone,
        'uid'=>$uid,
        'users'=>$users
        );
        $json = json_encode($data );
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, $FIREBASE . $NODE_PUT );
        curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PATCH" );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $json );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $response = curl_exec($curl);
        curl_close( $curl );
          ///
    }
  public function click_to_dial_post()
  {
    if($this->input->post('integration_type') == 'knowlarity'){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://kpi.knowlarity.com/Basic/v1/account/call/makecall',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "k_number": "+918792740105",
            "agent_number": "+919582346831",
            "customer_number": "+919582346831",
            "caller_id": "+918035391158"
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: a191fd41-29e3-4a00-b101-5a0c1b042221',
            'x-api-key: lF4vZUSwA8Jab0ABWsITtxwM1ZwL6h2jZDdCTX30',
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }else{
      $mob  = $this->input->post("phone_no");
      $mob  = substr($mob,-10);
      $phone           = '+91'.$mob;
      $token           = $this->input->post("token");
      $support_user_id = $this->input->post("support_user_id");
          $this->db->where('telephony_agent_id',$support_user_id);
      $res=$this->db->get('tbl_admin')->row();
      if(!empty($res)){
      $curl = curl_init();
      curl_setopt_array($curl, array(  CURLOPT_URL => "https://obd-api.myoperator.co/obd-api-v1",
      CURLOPT_RETURNTRANSFER => true,  CURLOPT_CUSTOMREQUEST => "POST", 
      CURLOPT_POSTFIELDS =>'{  "company_id": "'.$res->telephony_compid.'",
      "secret_token": "'.$res->telephony_comp_token.'", 
      "type": "1", 
      "user_id": "'.$support_user_id.'",
      "number": "'.$phone.'",   
      "public_ivr_id":"'.$res->public_ivr_id.'", 
      "reference_id": "",  
      "region": "",
      "caller_id": "",  
      "group": "" }', 
      CURLOPT_HTTPHEADER => array(    "x-api-key:oomfKA3I2K6TCJYistHyb7sDf0l0F6c8AZro5DJh", 
      "Content-Type: application/json"  ),));
      echo $response = curl_exec($curl);
    }
  }
}
    
  public function mark_abilibality_post(){
        
        $atID   =   !empty($_POST['callbreakstatus'])?$_POST['callbreakstatus']:'';
        
        $user_id    =   $this->input->post('user_id');        
        
            $url = "https://developers.myoperator.co/user";
            $data = array(
            'token'=>$this->input->post('telephony_token'),
            'receive_calls '=>$atID,
            'uuid'=>$this->input->post('telephony_agent_id'),
            );
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));   
            $response = curl_exec($ch);
            //$user_id    =   $this->session->user_id;
            $this->db->set('availability',$atID);
            $this->db->where('pk_i_admin_id',$user_id);
            $this->db->update('tbl_admin');         
        
            //unset($this->session->availability);
            
            if($atID == 0){     
            echo json_encode(array('id'=>0,'status'=>$atID));
            }else{
            echo json_encode(array('id'=>0,'status'=>$atID));           
            }
    }
  public function enquiryListByPhone_post()
  {
    $phone   = $this->input->post("phone_no");
    $comp_id = $this->input->post("companey_id");
    $this->form_validation->set_rules('phone_no', 'Phone No', 'required');
    $this->form_validation->set_rules('companey_id', 'Company id', 'required');
    
    if ($this->form_validation->run() == true){
        
        $this->db->select("enquiry_id,Enquery_id,name_prefix,name,lastname,address,email,product_id");        
        $this->db->from("enquiry");
        $this->db->where("phone",$phone);
        $this->db->where('comp_id',$comp_id);
        $enquiryLst = $this->db->get()->row_array();
        
        if(!empty($enquiryLst))
        {
          $this->set_response([
          'status' => true,
          'message' => $enquiryLst, 
          ], REST_Controller::HTTP_OK);
        }
        else
        {
          $this->set_response([
            'status' => false,
            'message' => array('error'=>'not found!') 
            ], REST_Controller::HTTP_OK);
        }
    }else{
        $this->set_response([
            'status' => false,
            'message' => array('error'=>'fields required!') 
            ], REST_Controller::HTTP_OK);
    }
  }
    public function updateEnquiryStatus_post(){
      $phone   = '91'.$this->input->post("phone_no");
      $Enquery_id = $this->input->post("Enquery_id");
      $uid = $this->input->post("user_id");
      $this->db->set('status',1);
      $this->db->set('enq_id',$Enquery_id);
      $this->db->where('phone_number',$phone);
      $this->db->where('uid',$uid);
      $update = $this->db->update('tbl_col_log');
      if($update)
      {
        $this->set_response([
          'status' => true,
          'message' => 'updated', 
          ], REST_Controller::HTTP_OK);
      }
      else
      {
        $this->set_response([
          'status' => false,
          'message' => 'something went wrong', 
          ], REST_Controller::HTTP_OK);
      }
    }
    
    public function in_call_post($comp_id=0){ // incoming call pop up api

        $users='';
        $call_data = $_POST['myoperator'];
        $call_data_array = json_decode($call_data);
        $FIREBASE = "https://new-crm-f6355.firebaseio.com/";
        $uid=str_replace('.','_',$call_data_array->uid);
        $call_state=$call_data_array->call_state;
        if(!empty($call_data_array->users)){
          $users=$call_data_array->users;
          $this->db->set('users',$users);
          
          $phone_s =preg_replace('/[^0-9]/', '', $users);
          if(strlen($phone_s) >= 11){$phone_n = substr($phone_s,2,12);}else{$phone_n = $phone_s;}
          $this->db->set('agent_phn',$phone_n);
        }else{
          $phone_n = '';
        }
        
        $phone=$call_data_array->clid;
        $uid1=str_replace('.','_',$uid);
        $this->db->set('json_data',$call_data);
        $this->db->set('uid',$call_data_array->uid);
        $this->db->set('cll_state',$call_state);
        $this->db->set('comp_id',$comp_id);
        $this->db->set('phone_number',$phone);
        $this->db->insert('tbl_col_log');
        $insert_id = $this->db->insert_id();
      //  if($call_state=3 || $call_state=5 || $call_state=2 || $call_state=6){
	      


		 if(!empty($phone_n)){
		 $user_comp=$this->db->select("companey_id")
                        ->from('tbl_admin')
                        ->where('s_phoneno', $phone_n)
                        ->get()
                        ->row();
		if(!empty($user_comp->companey_id)){				
        $NODE_PUT =$user_comp->companey_id."/".$insert_id.".json";
        $data = array(
        'user_phone'=>$phone,
        'uid'=>$uid,
        'users'=>$users
        );
        $json = json_encode($data );
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, $FIREBASE . $NODE_PUT );
        curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PATCH" );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, $json );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $response = curl_exec($curl);
        curl_close( $curl );
        $this->db->insert('call_test',array('res'=>$response));
        }else{
          $this->db->insert('call_test',array('res'=>'comp empty'));
        }
		}else{
      $this->db->insert('call_test',array('res'=>'phone empty'));
    }
     //   }
    }
    
     public function after_call_post($type='',$comp_id=0){
       if($type == 'knowlarity'){
        $req_data = file_get_contents("php://input");
        $req_data = json_decode($req_data,true);
        $this->db->insert('after_call_log',
          array(
            'call_id'     =>  $req_data['call_uuid']??'',
            'res'         =>  json_encode($req_data),
            'called_no'   =>  $req_data['called_number']??'',
            'call_status' =>  $req_data['call_status']??'',
            'duration'    =>  $req_data['call_duration']??'',
            'call_time'   =>  $req_data['call_time']??'',
            'customer_no' =>  $req_data['customer_number']??'',
            'agent_no'    =>  $req_data['agent_number']??'',
            'recording'   =>  $req_data['recording_url']??'',
            'call_direction' => $req_data['call_direction']??''
          )
        );

        $this->set_response([
          'status' => true,
          'message' => 'succees' 
          ], REST_Controller::HTTP_OK);
       }else{
        $agent_id='';
        $call_data = $_POST['myoperator'];
        $call_data_array = json_decode($call_data, true);
		        $agentname=$agenphone=$_dn=$_dn1='';$feedback=0;
          if(!empty($call_data_array['_ld']['_rr']['_na'])){ $agentname=$call_data_array['_ld']['_rr']['_na'];}
          if(!empty($call_data_array['_ld']['_rr']['_ct'])){ $agenphone=$call_data_array['_ld']['_rr']['_na'];}
          if(!empty($call_data_array['_cri'])){ $_dn1 = $call_data_array['_cri'];}
          if(!empty($call_data_array['_dn'])){ $_dn = $call_data_array['_dn'];}
   

            $update_data = array();
            if(!empty($call_data_array['_ts'])){
                $update_data = array('ts'=>$call_data_array['_ts']);                
                if(!empty($call_data_array['_pm'][0]['vl'])){
                    $update_data['call_id'] = $call_data_array['_pm'][0]['vl'];
                }
                if(!empty($call_data_array['_pm'][0]['vl'])){
                    $update_data['call_id'] = $call_data_array['_pm'][0]['vl'];
                    //$update_data['handling_dur'] = $this->get_handling_time($update_data['call_id'],$value['created_date']);
                }
                
                if(!empty($call_data_array['_dr'])){
                    $update_data['dur'] = $call_data_array['_dr'];
                }

                
                if(!empty($call_data_array['_ld'][0]['_rr'][0])){
                    $k = $call_data_array['_ld'][0]['_rr'][0];
                    if(!empty($k)){
                        if(!empty($k['_ct'])){
                            $update_data['agent_phn'] = $k['_ct'];                            
                        }
                        if(!empty($k['_em'])){
                            $update_data['email'] = $k['_em'];
                        
                        }
                        if(!empty($k['_ex'])){
                            $update_data['ex'] = $k['_ex'];
                        
                        }
                        if(!empty($k['_id'])){
                            $update_data['agent_id'] = $k['_id'];
                        
                        }
                        if(!empty($k['_na'])){
                            $update_data['name'] = $k['_na'];
                        }
                    }                    
                }  
              }   




          if(!empty($update_data)){
            $this->db->set($update_data);
          }
          $this->db->set('recived_by',$agenphone);
          $this->db->set('recived_name',$agentname);
          $this->db->set('comp_id',$comp_id);
          $this->db->set('customer_phone',$call_data_array['_cr']);
          $this->db->set('call_status',$call_data_array['_su']);
          $this->db->set('event_type',$call_data_array['_ev']); 
          $this->db->set('_feedback',$feedback);
          $this->db->set('json_data',$call_data); 
          $this->db->set('res',json_encode($_POST)); 
          $this->db->insert('tbl_col_log2'); 
      
       }        
    }
}
 