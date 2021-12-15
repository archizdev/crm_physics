<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reminder extends CI_Controller {
	public function __construct()
	{
		parent::__construct();		
		$this->load->model(array(
			'User_model'			
		));
		if(empty($this->session->user_id)){
		 redirect('login');   
		}
	}
 	
 	public function task_reminder(){		
 		$this->load->view('sse_reminder');
 	}
 	public function abc(){ 	
		
		$user_id  = $this->session->user_id;
 		
 		$query  = $this->db->query("select NOW(),query_response.task_time,query_response.task_date,query_response.task_remark,query_response.query_id,enquiry.status,enquiry.enquiry_id as enqid,CONCAT_WS(' ',enquiry.name_prefix,enquiry.name,enquiry.lastname) as enq_name from query_response INNER JOIN enquiry ON query_response.query_id = enquiry.Enquery_id where query_response.create_by=$user_id AND STR_TO_DATE(query_response.task_date,'%d-%m-%Y') = CURDATE() AND query_response.task_time >= TIME_FORMAT(NOW(), '%H:%i:%s')");
	    $result = $query->result_array();
	    echo $this->db->last_query(); 	
    	echo "<pre>";
    	print_r($result);
    	echo "</pre>"; 		
 		$this->load->view('reminder_test');
	 }
	 public function birthday_reminder()
	 {
		$todaydate=date('m-d');
		$data=$this->db->where(array('companey_id'=>$this->session->companey_id))->where_not_in('date_of_birth','')->where_not_in('joining_date','')->get('tbl_admin')->result();
		foreach ($data as $key => $value) {
			// where('date_of_birth',$date)->or_where('date_of_birth',$date)
			$bdate=date('m-d',strtotime($value->date_of_birth));
			$jdate=date('m-d',strtotime($value->joining_date));
			$task_date=date('m-d-Y');
			$task_time='01:30:00';
		if($bdate==$todaydate){
			$rid= random_string('alnum', 16);
			$task="Do not forget today's your colleague ".ucfirst($value->s_display_name)."'s Birthday";
			$data=['create_by'=>$value->pk_i_admin_id,'task_remark'=>$task,'task_date'=>$task_date,'task_time'=>$task_time,'notification_id'=>$rid,'comp_id'=>$this->session->companey_id,'task_type'=>50];
			print_r($data);
			$insert=$this->db->insert('query_response',$data);
		}
		if($jdate==$todaydate){
				$rid= random_string('alnum', 16);
				$task=ucfirst($value->s_display_name)."'s work anniversary";
			    $data=['create_by'=>$value->pk_i_admin_id,'task_remark'=>$task,'task_date'=>$task_date,'task_time'=>$task_time,'notification_id'=>$rid,'comp_id'=>$this->session->companey_id,'task_type'=>50];
				$insert=$this->db->insert('query_response',$data);
			}
		}
	 }
}