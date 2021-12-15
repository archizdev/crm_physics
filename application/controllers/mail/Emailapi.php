<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// https://sendgrid.com/docs/API_Reference/Web_API_v3/index.html
class Emailapi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('mail/setting_model'));
        $this->load->library(array('email'));
        if ($this->session->userdata('isLogIn') == false   || $this->session->userdata('user_role') != 1) 
        redirect('login'); 
	}
    public function contructApi()
    {
        $api_url='';
        $content='';
        /* API URL */
        $url = $api_url;
            $type=1;
            if ($type==1) {
                //curl type
                /* Init cURL resource */
                $ch = curl_init($url);
                /* Array Parameter Data */
                $data = ['name'=>'Hardik', 'email'=>'itsolutionstuff@gmail.com'];
                /* pass encoded JSON string to the POST fields */
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                /* set the content type json */
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type:application/json',
                            'App-Key: 123456',
                            'App-Secret: 1233'
                        ));
                /* set return type json */
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                /* execute request */
                $result = curl_exec($ch);
                /* close cURL resource */
                curl_close($ch);
            } 
      
    }
}