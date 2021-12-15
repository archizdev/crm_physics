<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Appointment_new extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array(
      'Appointment_new_model',
      'User_model',
      'representative_model',
      'user_model',
      'Leads_Model',
      'dash_model',
      'location_model',
	  'ticket_report_datatable_model'
    ));
    $this->load->library('pagination');
    $this->crumb_user = array();
  }

  public function uroadshow_meet() {

    $data['title'] = 'Uroadshow Meetings';         
    $data['user_list'] = $this->User_model->read();
    $data['content'] = $this->load->view('internal_meets', $data, true);
    $this->load->view('layout/main_wrapper', $data);
}

public function staff_meet_add()
{   
 

  if($_POST)
  {
    $this->form_validation->set_rules('stm[]', 'Strat Time', 'trim|required');
    $this->form_validation->set_rules('etm[]', 'End Time', 'trim|required');

    if ($this->form_validation->run() == FALSE)
    {
      redirect('Appointment_new/uroadshow_meet');
      $this->session->set_flashdata('error',validation_errors());
    }
    else
    {
        $doctmslt ='';
        $repname = '';


          // $doctmslt     =  $this->session->userdata('tmslt');
          $doctmslt     =  "15";

          $repname      =  $this->session->user_id;

 
          $date        = $this->input->post("date");
          $fromdate    = $this->input->post("fromdate");
          $todate      = $this->input->post("todate");
          $starttime   =  $this->input->post('stm');
          $endtime     = $this->input->post('etm');
          

foreach($starttime as $st){
     $start=$st;
 }
 foreach($endtime as $et){
     $end=$et;
 }    
$time1 = strtotime($start);
$time2 = strtotime($end);
$drtn = ($time2-$time1)/60;

if(strlen($fromdate[0]) > 0){

          $i=0;
        foreach($fromdate as $fromdt){
          $frmdt = $fromdate[$i];
          $todt = $todate[$i];
          $diff = strtotime($frmdt) - strtotime($todt) ;
          $totaldays= abs(round($diff/ 86400)); 
          $time1 = $starttime[$i];
          $time2 = $endtime[$i];

          $total      = strtotime($time2) - strtotime($time1);
          $hours      = floor($total / 60 / 60);
          $timemins = $hours*60/$doctmslt; 
        if($timemins=='0'){
             $total      = strtotime($time2) - strtotime($time1);
             $minut      = floor($total / 60);
             $val = (!empty($doctmslt)) ?  $minut/$doctmslt : 1;
             $timemins = (int)$val;
           }else{
            $timemins=$timemins;   
           }
          $tempdate = $fromdate[$i];
    for($j=0;$j<=$totaldays;$j++){ 
      $stm1 = $starttime[$i];

$newdt = date('Y-m-d',strtotime($tempdate));

  $response='';
          $datas = array(
                'comp_id' => $this->session->userdata('companey_id'),
                'staff_id' => $repname,
                'schdl_date' => $newdt,
                'start_tm' => $start,
                'end_tm' => $end,
                'a_duration' => $drtn
            );

            $zoominsert_id = $this->Appointment_new_model->staff_meet_insert('tbl_internal_zoom_link',$datas);





    for($k=1;$k<=$timemins;$k++){
     
          $endTime = strtotime("+$doctmslt minutes", strtotime($stm1));
          $temptime = date('H:i', $endTime);


          
          $newdt = date('Y-m-d',strtotime($tempdate));
          $tmslt[$i] = $stm1.' - '.$temptime;
         
         $selectedTime = "$temptime";
$endTime = strtotime("+5 minutes", strtotime($selectedTime));
$stm1 = date("H:i",$endTime);
if($stm1<=$end){
           $data = array(

           'comp_id'         => $this->session->userdata('companey_id'),
           'staff_id'        => $repname,
           'schdl_dt'        => $newdt,
           'stm'             => $tmslt[$i],
           'schl_sts'        => 2,
           'main_schdl_id'   => $zoominsert_id
     );

         $data = $this->security->xss_clean($data);
         $result = $this->Appointment_new_model->staff_meet_insert('tbl_internal_schdl',$data);
        
}     
    } 

  $tempdate= date('Y-m-d', strtotime($tempdate. ' + 1 days')); 
    }
   $i++;     
  }

          $this->session->set_flashdata('msg',"Schedule has been added successfuly");
          redirect('Appointment_new/uroadshow_meet');

    }   

    if(strlen($date[0]) > 0){
        $i=0;
        $result1='';
        foreach($date as $fromdt){
          $time1 = $starttime[$i];
          $time2 = $endtime[$i];

          $total      = strtotime($time2) - strtotime($time1);
          $hours      = floor($total / 60 / 60);
           $timemins = (!empty($doctmslt)) ?  $hours*60/$doctmslt : 1;
          
           if($timemins=='0'){
             $total      = strtotime($time2) - strtotime($time1);
             $minut      = floor($total / 60);
             $val = (!empty($doctmslt)) ?  $minut/$doctmslt : 1;
             $timemins = (int)$val;
           }else{
            $timemins=$timemins;   
           }
      $stm1 = $starttime[$i];
      
      
      $newdt = date('Y-m-d',strtotime($fromdt));
        $response='';
                                $datas = array(
                                      'comp_id' => $this->session->userdata('companey_id'),
                                      'staff_id' => $repname,
                                      'schdl_date' => $newdt,
                                      'start_tm' => $start,
                                      'end_tm' => $end,
                                      'a_duration' => $drtn
                                  );
                              $zoominsert_id = $this->Appointment_new_model->staff_meet_insert('tbl_internal_zoom_link',$datas);
    
    for($k=1;$k<=$timemins;$k++){ 
     
          $endTime = strtotime("+$doctmslt minutes", strtotime($stm1));
          $temptime = date('H:i', $endTime);
          
          $newdt = date('Y-m-d',strtotime($fromdt));
          $tmslt[$i] = $stm1.' - '.$temptime;
          
$selectedTime = "$temptime";
$endTime = strtotime("+5 minutes", strtotime($selectedTime));
$stm1 = date("H:i",$endTime);
if($stm1<=$end){
          $data = array(

          'comp_id'         => $this->session->userdata('companey_id'),
          'staff_id'        => $repname,
          'schdl_dt'        => $newdt,
          'stm'             => $tmslt[$i],
          'schl_sts'        => 2,
          'main_schdl_id'   => $zoominsert_id
    );

        $data = $this->security->xss_clean($data);
        $result1 = $this->Appointment_new_model->staff_meet_insert('tbl_internal_schdl',$data);
}         
  
    }

   $i++;     
  }
          $this->session->set_flashdata('msg',"Schedule has been added successfuly");
          redirect('Appointment_new/uroadshow_meet');
    }


         }
       }

if($action==null && empty($_POST)){
    redirect('Appointment_new/uroadshow_meet');
  }
}


public function meetings_load(){

    $list = $this->Appointment_new_model->get_meettables();
      
    $data = array();
    $no = $_POST['start'];        
    $i = 1;        
    foreach ($list as $each) {        
        $no++;        
        $row = array();        


        if(!empty($each->schdl_dt) && $each->schdl_dt!='01-01-1970'){

          $d = strtotime($each->schdl_dt);               
          $nd = date("Y/m/d",$d);               
          $nd = $each->schdl_dt?$nd:'NA';                                 
          //$nt = date("H:i:s",$d);
        }else{
          $nd = 'NA';
          $nt = 'NA';
        }
        $row[] = $nd;
        $row[] = $each->stm;
        $row[] = $each->student;
        $row[] = $each->s_phoneno;
        $row[] = $each->s_user_email;
                    
if($each->schl_sts=='2'){
    $meetStatus = 'Available';
    $row[] =  "<a class='btn btn-danger btnStatus'>".$meetStatus." </a>";
}else{
    $meetStatus = 'Booked';
    $row[] =  "<a class='btn btn-success btnStatus'>".$meetStatus." </a>";
}

if($each->zoin_status=='0'){
    $zoinStatus = 'Not attempt';
    $row[] =  "<a class='btn btn-danger btnStatus'>".$zoinStatus." </a>";
}else{
    $zoinStatus = 'Attempted';
    $row[] =  "<a class='btn btn-success btnStatus'>".$zoinStatus." </a>";
}
                 
        ?>
        <?php
            $data[] = $row;
            $i++;
        }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->Appointment_new_model->count_all(),
        "recordsFiltered" => $this->Appointment_new_model->count_filtered(),
        "data" => $data,
    );

    echo json_encode($output);
}


public function get_calandar_feed(){

    $user_id = $this->input->post('user_id');
    $this->session->set_userdata('filter_user_id',$user_id);

    $start = $this->input->post('start');
    $end = $this->input->post('end');
    $cal_feed    =  $this->Appointment_new_model->get_meet_calandar_feed($start,$end,$user_id); 

    $feed = array();
    
    foreach ($cal_feed as $meets){
        $task_date1   =  date_create($meets->schdl_dt);            
        if(!empty($task_date1)){
          /*if($meets->student==''){
            $slot = 'Available';
          }else{
            $slot = $meets->student;
          }*/
             //$name = $meets->stm. ' ('.$slot.')';
          $name = $meets->stm;
          if($meets->student==''){   
           $dt = date_format($task_date1,'Y-m-d'); 
           $feed[] = array(
               'title' =>   $name,
               'start' =>   $dt,
               'backgroundColor' =>'#C0392B',
               'url'    =>  '',
               'borderColor'    =>  '#C0392B'
           );

           }else{
            $dt = date_format($task_date1,'Y-m-d'); 
            $feed[] = array(
               'title' =>   $name,
               'start' =>   $dt,
               'backgroundColor' =>'#16A085',
               'url'    =>  '',
               'borderColor'    =>  '#16A085'
           );

           }               
        }
    }
    echo json_encode($feed);
}

public function search_meetings($date = '') {
    $details = '';

    $date = date_create($date);

    $date = date_format($date,'d-m-Y'); 

    $recent_meets = $this->Appointment_new_model->search_meetby_id($date); 

    $details .= '
                <table class="datatable table table-striped table-bordered dataTable"  cellspacing="0" width="100%">
                   <thead>
                      <tr>
                       <th>Meeting Date</th>
                       <th>Timing</th>
                       <th>Student Name</th>
                       <th>Student Mobile</th>
                       <th>Student Email</th>
                       <th>Booking Status</th>           
                       <th>Zoin Status</th>                           
                      </tr>
                   </thead>
                   <tbody>
                      ';

    foreach ($recent_meets as $meets) {

if($meets->schl_sts=='2'){
    $meetStatus = 'Available';
    $row =  "<a class='btn btn-danger btnStatus'>".$meetStatus." </a>";
}else{
    $meetStatus = 'Booked';
    $row =  "<a class='btn btn-success btnStatus'>".$meetStatus." </a>";
}

if($meets->zoin_status=='0'){
    $zoinStatus = 'Not attempt';
    $row1 =  "<a class='btn btn-danger btnStatus'>".$zoinStatus." </a>";
}else{
    $zoinStatus = 'Attempted';
    $row1 =  "<a class='btn btn-success btnStatus'>".$zoinStatus." </a>";
}
       
// <td>'.$task->mobile.'</td>
          $details .= '
        <tr>
            <td>'.$meets->schdl_dt.'</td>
            <td>'.$meets->stm.'</td>
            <td>'.$meets->student.'</td>
            <td>'.$meets->s_phoneno.'</td>
            <td>'.$meets->s_user_email.'</td>
            
            <td>'.$row.'</td>
            <td>'.$row1.'</td>';

    }

    $details .= '</tbody></table>';
    echo $details;
}


public function uRoadshow_meetings($staff='',$student=''){

    if(!empty($student)){
        $data['title'] = "Book meetings";
        $data['staff_id'] = base64_decode($staff);
        $data['student_id'] = base64_decode($student);
        $this->load->view('website/uroadshow/internal_booking',$data);
    }else{
        redirect(base_url('website/home/nf_page'));
    }
    
     }

     public function read_slot($dt,$id){

        $slot=base64_decode($dt);
        
                if(!empty($slot)){
                    
                        $tmslt =  $this->db->select('stm,id')
                                           ->from('tbl_internal_schdl')
                                           ->where('schdl_dt',$slot)
                                           ->where('staff_id',$id)
                                           ->where('schl_sts','2')
                                           ->group_by('id')
                                           ->get()->result();
        
                           echo json_encode($tmslt);
                        
            }
        }
        
        
            
        public function book_an_apnt(){
            
            $this->form_validation->set_rules('meet_date', 'Meeting Date', 'trim|required');
            $this->form_validation->set_rules('tmslt', 'Time Slot', 'trim|required');
            if($this->form_validation->run()==true){
                
                $meet_date = $this->input->post('meet_date');
                $tmslt = $this->input->post('tmslt');
                $staff_id = $this->input->post('staff_id');
                $student_id = $this->input->post('student_id');
        
        $this->db->select('stm');
        $this->db->where('id', $tmslt);
        $slot  =   $this->db->get('tbl_internal_schdl')->row_array();
        $ntm = explode('-', $slot['stm']);
        
        $newDate = date("d/m/Y", strtotime($meet_date));
        $stm = trim($ntm[0]).':00';
        $etm = trim($ntm[1]).':00';
        $start = $newDate.' '.$stm;
        $end = $newDate.' '.$etm;
        
                if($_POST){
        
                $this->db->set('stu_id', $student_id);
                $this->db->set('schl_sts', '1');
                $this->db->where('id', $tmslt);
                $this->db->update('tbl_internal_schdl');
        
                if($this->db->affected_rows() > 0){ 
                    $this->create_an_event($staff_id,$student_id,$start,$end);          
                    echo json_encode(array('status'=>'success','msg'=>'Meeting Booked Successfully'));            
                }else{
                        echo json_encode(array('status'=>'fail','error'=>'Meeting Not Book!'));
                }
        
                }
                
            }
            else
            {
                echo json_encode(array('status'=>'fail','error'=>validation_errors()));
        
            }
        }
        
        public function create_an_event($staff_id,$student_id,$start,$end){
        $this->db->select('s_display_name,event_mail');
        $this->db->where('pk_i_admin_id',$staff_id);
        $staff  =   $this->db->get('tbl_admin')->row_array();
        
        $this->db->select('s_display_name,s_user_email');
        $this->db->where('pk_i_admin_id',$student_id);
        $student  =   $this->db->get('tbl_admin')->row_array();
        
        $from_name = $staff['s_display_name'];        
        $from_address = $staff['event_mail'];        
        $to_name = $student['s_display_name'];        
        $to_address = $student['s_user_email'];        
        $startTime = $start;        
        $endTime = $end;        
        $subject = "Uroadshow Meetings";        
        $description = "One To One Meeting";        
        $location = $staff['s_display_name'].'-Meeting Room';
        $this->sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);
        return;
        }
  
  
}