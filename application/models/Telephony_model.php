<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Telephony_model extends CI_Model{
    function __construct() {
    }
    public function click_to_dial($phone){        
        $token           = $this->input->post("token");
        $support_user_id = $this->session->telephony_agent_id;
        $this->db->where('telephony_agent_id',$support_user_id);
        $res=$this->db->get('tbl_admin')->row();
        if(!empty($res)){
        if(!empty($res->public_ivr_id)){    
            $curl = curl_init();
            curl_setopt_array($curl, array(  CURLOPT_URL => "https://obd-api.myoperator.co/obd-api-v1",
            CURLOPT_RETURNTRANSFER => true,  CURLOPT_CUSTOMREQUEST => "POST", 
            CURLOPT_POSTFIELDS =>'{"company_id": "'.$res->telephony_compid.'",
            "secret_token": "'.$res->telephony_comp_token.'", 
            "type": "1", 
            "user_id": "'.$support_user_id.'",
            "number": "'.$phone.'",   
            "public_ivr_id":"'.$res->public_ivr_id.'", 
            "reference_id": "",  
            "region": "",
            "caller_id": "",  
            "group": ""   }', 
            CURLOPT_HTTPHEADER => array("x-api-key:oomfKA3I2K6TCJYistHyb7sDf0l0F6c8AZro5DJh", 
            "Content-Type: application/json"  ),));
            $response = curl_exec($curl);
            print_r($response);
            // echo '{"company_id": "'.$res->telephony_compid.'",
            //     "secret_token": "'.$res->telephony_comp_token.'", 
            //     "type": "1", 
            //     "user_id": "'.$support_user_id.'",
            //     "number": "'.$phone.'",   
            //     "public_ivr_id":"'.$res->public_ivr_id.'", 
            //     "reference_id": "",  
            //     "region": "",
            //     "caller_id": "",  
            //     "group": ""   }';
        }else{
         $url = "https://developers.myoperator.co/clickOcall";
            $data = array(
            'token'=>$this->session->telephony_token,
            'customer_number'=>$phone,
            'customer_cc'=>91,
            'support_user_id'=>$this->session->telephony_agent_id
            );
            $curl = curl_init();
            curl_setopt( $curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('application/x-www-form-urlencoded'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec( $curl );
            curl_close( $curl );
            print_r($response);
                //echo "hel
            }
        }
    }

    function create_session(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crm4.cloud-connect.in/CCC_api/v1.4/createSession',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "agent_username" : "ag01",
        "agent_password" : "e6de9dbf014692dc6f19d43a78f1f743",
        "loginType" : "AUTO",
        "campaign_name" : "1199",
        "token" : "jRDNMnEm9clrENIL",
        "tenant_id" : "1055" 
        }
        ',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $this->db->insert('cloud_connect_log',array('res'=>$response));
        if($response){
           $response  = json_decode($response,true);
           //print_r($response);
           if(!empty($response['session'])){
            $session = $response['session'];
            $this->session->set_userdata('cloud_connect_session_id',$session);
           }
        }

    }

    public function click_to_dial_cloud_connect($phn){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://crm4.cloud-connect.in/CCC_api/v1.4/clickToCallManual',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "action": "Call",
            "agent_id": "584",
            "agent_session_id": "'.$this->session->cloud_connect_session_id.'",
            "customer_phone": "'.$phn.'",
            "camp_id": "771",
            "tenant_id": "1055"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $this->db->insert('cloud_connect_log',array('res'=>$response));
        curl_close($curl);
    }

    function end_session(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crm4.cloud-connect.in/CCC_api/v1.4/endSession',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "session":"'.$this->session->cloud_connect_session_id.'",
        "token": "jRDNMnEm9clrENIL",
        "tenant_id": "1055",
        "force_logout": "true"
        }
        ',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        $this->db->insert('cloud_connect_log',array('res'=>$response));
        curl_close($curl);
        echo $response;
    }

}