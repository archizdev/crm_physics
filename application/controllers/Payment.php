<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller {
	
    public function __construct() {
		
		 parent::__construct();
		$this->load->model("common_model");
		$this->load->model('Payment_model');
			$this->load->model('user_model');
		if (empty($this->session->user_id)) {
			redirect('login');
		}
	}
	public function make_payment_mojo(){
		$this->session->unset_userdata('part_payment_amount');
		$this->form_validation->set_rules('fname','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('phone','Mobile No','trim|required|numeric|min_length[10]|max_length[10]');		
		$this->form_validation->set_rules('pincode','Pincode','trim|required|numeric');		
		$this->form_validation->set_rules('address','Address','trim|required');		
		$this->form_validation->set_rules('dbt','Mode of Payment','trim|required');		
		/*$this->form_validation->set_rules('amount','Amount','trim|required|numeric');*/		
		if ($this->form_validation->run() == true) {
			$name		=	$this->input->post('fname');
			$email		=	$this->input->post('email');
			$phone		=	$this->input->post('phone');
			$address    =	$this->input->post('address');
			
			$ship_address	=	$this->input->post('ship_address');
			$state			=	$this->input->post('state');
			$city			=	$this->input->post('city');
			$pincode 		=	$this->input->post('pincode');
			$gstin  		=	$this->input->post('gstin');
			$this->session->set_userdata('payment_mode',$this->input->post('dbt'));
			$this->user_model->set_user_meta($this->session->user_id,array(
				'postal_code'=>$this->input->post('pincode'),
				'gstin' => $this->input->post('gstin')
				)
			);
			$comp_id	=	$this->session->companey_id;
			$user_id	=	$this->session->user_id;
			$this->db->where('companey_id',$comp_id);
			$this->db->where('pk_i_admin_id',$user_id);
			$this->db->set('add_ress',$address);
			$this->db->update('tbl_admin');
			
			if ($this->input->post('part_payment') == 1) {
				$amount = $this->input->post('part_payment_amount');				
				$this->session->set_userdata('part_payment_amount',$amount);
			}else{
				$this->load->library('cart');
				$amount	=	$this->cart->total();							
			}
			if ($this->input->post('dbt') == 2) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_HTTPHEADER,
				             array("X-Api-Key:ca7a223092cfaf2317db5fc00fc83502",
				                  "X-Auth-Token:b6224670c580b470d7951eaf697e2e9f"));
				$payload = Array(
				    'purpose' => 'Product Purchage',
				    'amount' => $amount,
				    'phone' => $phone,
				    'buyer_name' => $name,
				    'redirect_url' => base_url().'buy/thankyou',
				    'send_email' => true,
				    'webhook' => 'http://www.example.com/webhook/',
				    'send_sms' => true,
				    'email' => $email,
				    'allow_repeated_payments' => false
				);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
				$response = curl_exec($ch);
				curl_close($ch); 
				//echo $response.'test';
				$decodedText = html_entity_decode($response);
				$myArray = array(json_decode($response, true));
				if (!empty($myArray[0]["payment_request"]["longurl"])) {
					$longu = $myArray[0]["payment_request"]["longurl"];				
					header('Location:' .$longu);
				}else{
					//echo $response;
					echo "Something went wrong!";
				}	
			}else{
				$this->load->model('order_model');
				
				$emp_id    =	$this->input->post('preferd');
				$pk_i_admin_id	=	$this->order_model->get_pk_admin_id($emp_id);
				$ord_no	=	!empty($pk_i_admin_id->pk_i_admin_id)?$this->order_model->placeorder($pk_i_admin_id->pk_i_admin_id):$this->order_model->placeorder();
		//$ord_no	=	$this->order_model->placeorder($pk_i_admin_id->pk_i_admin_id);
				if($ord_no){ 
					$this->order_model->set_order_meta($ord_no,$comp_id,$user_id,array(
							'fname' =>	$this->input->post('fname'),
							'email' =>	$this->input->post('email'),
							'phone' =>	$this->input->post('phone'),
							'address' =>	$this->input->post('address'),			
							'state' =>	$this->input->post('state'),
							'city' =>	$this->input->post('city'),
							'pincode' =>	$this->input->post('pincode'),
							'gstin' =>	$this->input->post('gstin')
						),'BILLING_DETAILS'
					);
					$this->order_model->set_order_meta($ord_no,$comp_id,$user_id,array(
							'fname' =>	$this->input->post('shipping_fname'),
							'email' =>	$this->input->post('shipping_email'),
							'phone' =>	$this->input->post('shipping_phone'),
							'address' =>	$this->input->post('shipping_address'),			
							'state' =>	$this->input->post('shipping_state'),
							'city' =>	$this->input->post('shipping_city'),
							'pincode' =>	$this->input->post('shipping_pincode'),
						),'SHIPPING_DETAILS'
					);
					$this->session->set_flashdata('message','Your order is successfully placed');
					redirect(base_url("order/invoice/".$ord_no), "refresh");			
				}
			}		
		}else{
			$this->session->set_flashdata('message', validation_errors());
			redirect('buy/checkout');
		}
	}

	
	public function index(){
		$data = array();
		$this->load->view('payment/payment-pending',$data);        
	  }
	  public function payment_success(){	       
		$data['res'] = $res = $_POST;
		$ins_arr = array(
					'uid'   => $this->session->user_id,
					'status'=> $res['status'],
					'txnid' => $res['txnid'],
					'amount'=> $res['amount'],
					'response'   => json_encode($res)
				  );    
		if ($res['status'] == 'success') {
		  $this->user_model->set_user_meta($this->session->user_id,array('payment_status'=>1));
		}
		if(!$this->db->where('txnid',$ins_arr['txnid'])->from('payment_history')->count_all_results()){      
		  $this->Payment_model->save_payment_response($ins_arr);          
		}    
			$this->load->view('payment/order-success',$data);    
	  }
	  public function payment_failed(){	   
		$data['res'] = $res = $_POST;
		$ins_arr = array(
					'uid'   => $this->session->user_id,
					'status'=> $res['status'],
					'txnid' => $res['txnid'],
					'amount'=> $res['amount'],
					'response'   => json_encode($res)
				  );
		if(!$this->db->where('txnid',$ins_arr['txnid'])->from('payment_history')->count_all_results()){      
		  $this->Payment_model->save_payment_response($ins_arr);          
		}
			$this->load->view('payment/order-fail',$data);    
	  }  
	  public function pay_method($keyword) {
		  if($keyword=='payumoney'){
		$data['title'] = 'Payment';
		$data['content'] = $this->load->view('payment/payment-form', $data);
		$this->load->view('layout/main_wrapper', $data);
		  }else if($keyword=='razorpay'){
		$data['title'] = 'Razor Pay';
		$data['content'] = $this->load->view('razorpay/index', $data, true);
		$this->load->view('layout/main_wrapper', $data);	  
		  }
	  }
	  
	 public function razorpay_success($id) {
		$this->db->set('pay_status', '1');//if 2 columns
        $this->db->where('id', $id);
        $this->db->update('tbl_payment');
		$data['title'] = 'Razor Pay Success';
		$data['content'] = $this->load->view('razorpay/success', $data, true);
		$this->load->view('layout/main_wrapper', $data);	  
	  }
    
	public function razorpay_failed($id) {
		$this->db->set('pay_status', '0');//if 2 columns
        $this->db->where('id', $id);
        $this->db->update('tbl_payment');
		$data['title'] = 'Razor Pay Success';
		$data['content'] = $this->load->view('razorpay/failed', $data, true);
		$this->load->view('layout/main_wrapper', $data);	  
	  }
	  
	  
	  public function razorpay_payment_final() {
		if (!empty($_POST['razorpay_payment_id']) && !empty($_POST['merchant_order_id'])) {
			$json = array();
			$razorpay_payment_id = $_POST['razorpay_payment_id'];
			$merchant_order_id = $_POST['merchant_order_id'];
			$currency_code = $_POST['currency_code_id'];
			// store temprary data
			$dataFlesh = array(
			    'card_holder_name' => $_POST['card_holder_name_id'],
			    'merchant_amount' => $_POST['merchant_amount'],
			    'merchant_total' => $_POST['merchant_total'],
			    'surl' => $_POST['merchant_surl_id'],
			    'furl' => $_POST['merchant_furl_id'],
			    'currency_code' => $currency_code,
			    'order_id' => $_POST['merchant_order_id'],
			    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
			);
			$paymentInfo = $dataFlesh;
			$order_info = array('order_status_id' => $_POST['merchant_order_id']);
			$amount = $_POST['merchant_total'];
			$currency_code = $_POST['currency_code_id'];
			// bind amount and currecy code
			$data = array(
			    'amount' => $amount,
			    'currency' => $currency_code,
			);
			$success = false;
			$error = '';
			try {
			    $ch = $this->get_curl_handle($razorpay_payment_id, $data);
			    //execute post
			    $result = curl_exec($ch);
			    $data = json_decode($result);
			  
			    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			    if ($result === false) {
			        $success = false;
			        $error = 'Curl error: ' . curl_error($ch);
			    } else {
			        $response_array = json_decode($result, true);
			        //Check success response
			        if ($http_status === 200 and isset($response_array['error']) === false) {
			            $success = true;
			        } else {
			            $success = false;
			            if (!empty($response_array['error']['code'])) {
			                $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
			            } else {
			                $error = 'Invalid Response <br/>' . $result;
			            }
			        }
			    }
			    //close connection
			    curl_close($ch);
			} catch (Exception $e) {
			    $success = false;
			    $error = 'Request to Razorpay Failed';
			}
			if ($success === true) {
			    if (!$order_info['order_status_id']) {
			       $json['redirectURL'] = $_POST['merchant_surl_id'];
			    } else {
			        $json['redirectURL'] = $_POST['merchant_surl_id'];
			    }
			$data = array(
			        'uid'=>$this->session->user_id,
			        'method'=>'Rozar Pay',
					'ins_id'=>$_POST['merchant_insid'],
			        'status'=>'Success',
					'txnid'=>$_POST['razorpay_payment_id'],
			        'amount'=>$_POST['merchant_amount'],
					'response'=>$result
			    );
			$this->db->insert('payment_history',$data);
			} else {
				$data = array(
			        'uid'=>$this->session->user_id,
			        'method'=>'Rozar Pay',
					'ins_id'=>$_POST['merchant_insid'],
			        'status'=>'Success',
					'txnid'=>$_POST['razorpay_payment_id'],
			        'amount'=>$_POST['merchant_amount'],
					'response'=>$result
			    );
			    $this->db->insert('payment_history',$data);
			    $json['redirectURL'] = $_POST['merchant_furl_id'];
			}
			  $json['msg'] = '';
			} else {
			 $json['msg'] = 'An error occured. Contact site administrator, please!';
			}
			echo json_encode($json);	  
	  }
	  
	  
	function get_curl_handle($payment_id, $data) {
	    $url = 'https://api.razorpay.com/v1/payments/' . $payment_id . '/capture';
	    $key_id = 'rzp_live_vGbrA7OABnyJne';
	    $key_secret = 'AlgmDoiif0nK9PK0m70wgdLZ';
	    $params = http_build_query($data);
	    //cURL Request
	    $ch = curl_init();
	    //set the url, number of POST vars, POST data
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	    return $ch;
	}
	  
	
	public function paylist()
	{
		if (user_role('440') == true) {}
		if(isset($_POST["downloadexel"])){
            $sdate = $this->common_model->cleandate('startdate');
            $edate = $this->common_model->cleandate('enddate');
			$this->downloadexel($sdate,$edate);			
			echo "<script> window.location='".base_url('payment')."';</script>";
		}
		$this->load->model("payment_model");
		$data["payments"] = $this->payment_model->payments(1);		
		$data['product'] = $this->payment_model->getProduct();
		if(isset($_POST['type']))
		{
			//$this->load->template("datatable/payment", $data);
		}
		$data['content'] = $this->load->view('payment/payment-list', $data, true);
        $this->load->view('layout/main_wrapper', $data);
	}
	public function downloadexel($sdate,$edate)
    {
		
		$this->load->model("datatable_model");
		$this->load->model("payment_model");
		
		$this->load->library("excel");
        $payment = $this->datatable_model->payments(1);
        //print_r($payment);die;
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()
					->setCreator("Cona")
					->setLastModifiedBy($this->session->fname)
					->setTitle("Payment Information")
					->setSubject("Payment excel")
					->setDescription("Payment")
					->setKeywords("Payment");
					
	    /*	$objPHPExcel->getActiveSheet()
            ->getStyle("A1:P1")
            ->getFont()
            ->setSize(18); */
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
		
		$rowarr = array("Sr No", "Order", "Product", "Total Pay","Pay","Balance","Mode", "Transaction No","Status","Payment Date");
		
		$objPHPExcel->setActiveSheetIndex(0);
		
		$ltr = 'A';
		foreach($rowarr as $ind => $val){
			
			$objPHPExcel->getActiveSheet()->setCellValue($ltr."1", $val);
			
			$ltr++;
		}
		$pending   = $totprice = $totqty = 0;
		$count     = 1;
		
		if(!empty($payment)){
			foreach($payment as $ind => $ord) {
			 	$ltr = 'A';
				$count  =  $count + 1;
				
				$objPHPExcel->getActiveSheet()->SetCellValue( ($ltr++).$count, $count - 1)
											  ->SetCellValue( ($ltr++).$count, $ord->ord_no)
											  ->SetCellValue( ($ltr++).$count, $ord->product)
											  ->SetCellValue( ($ltr++).$count, $ord->tot_pay)
											  ->SetCellValue( ($ltr++).$count, $ord->pay)
											  ->SetCellValue( ($ltr++).$count, $ord->balance)
											  ->SetCellValue( ($ltr++).$count, $ord->pay_mode)
											  ->SetCellValue( ($ltr++).$count, $ord->transaction_no)
                                              ->SetCellValue( ($ltr++).$count, $ord->status)
                                              ->SetCellValue( ($ltr++).$count, date("d-M-Y",strtotime($ord->pay_date)));
			
			}
		}
            $objPHPExcel->getActiveSheet()->setTitle('Payment('.count($payment).')');
            $objPHPExcel->setActiveSheetIndex(0);
            
            $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
            
            $fname = "payments_".date("y_m_d").".xls";
            
            header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$fname.'"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
		
		
		
	}
	
	public function add($ordno = ""){
		
		if(isset($_POST["orderid"])){ 
			
			$this->savepayment();
			redirect(base_url("payment/add/".$ordno), "refresh");
		}
		
		$this->load->model("order_model");
		$this->load->model("payment_model");
		$data["title"] = "Add Payment";
		
		$data["ord"]      = $this->order_model->getOrder($ordno);
		$data["orders"]   = $this->order_model->getOrdersProduct($ordno);
		
		//$data["masters"]  = $this->payment_model->getmaster();	
		
		if(!empty($data["ord"]->ord_no)){
			
			$data["payments"] = $this->payment_model->getpayment($data["ord"]->ord_no);
			
		}
		
		$data['content'] = $this->load->view('payment/add-payment', $data, true);
        $this->load->view('layout/main_wrapper', $data);
	}
	
	public function update($payno = ""){
		
		if(isset($_POST["paymentid"])){
			
			$this->savepayment();
			redirect(base_url("payment/add/".$_POST["orderid"]), "refresh");
		}
		
		$this->load->model("order_model");
		$this->load->model("payment_model");
		$payno = base64_decode($payno);
		//echo $payno;
		$data['paydata'] = $this->db->select('*')->from('payment')->where('id',$payno)->get()->row();
	//	$data["masters"]  = $this->payment_model->getmaster();	
		$data["title"] = "Update Payment";
		$data['content'] = $this->load->view("payment/update-payment", $data,true);
		$this->load->view('layout/main_wrapper', $data);
	}
	
	public function savepayment(){
		
		
		$arr = array(
					"pay" 			 => $this->input->post("payment", true),
					"balance" 		 => $this->input->post("balance", true),
					"pay_mode" 		 => $this->input->post("paymode", true),
					"transaction_no" => $this->input->post("transactiono", true),
					"status" 		=> $this->input->post("status", true),
					"pay_date" 		=> date("Y-m-d",strtotime($this->input->post("paydate", true))), 
					"next_pay"		=> date("Y-m-d",strtotime($this->input->post("nextpay", true))),
					"remark" 		=> $this->input->post("remarks", true),
				//	"advance_pay"	 => (!empty($_POST["advbalance"])) ? $this->input->post("advbalance", true) : 0,
						
					);
		//print_r($arr);die;
	
		if(isset($_POST["paymentid"])){
			
			$this->db->where("id", $this->input->post("paymentid", true));
			$this->db->where("company", $this->session->companey_id);
			$this->db->update("payment", $arr);
			$ret  = $this->db->affected_rows();
		}else{
			$arr["prev_balance"] = (!empty($_POST["prevbalance"])) ? $this->input->post("prevbalance", true) : 0;
				
			$arr["ord_id"] 		 = $this->input->post("orderid", true);
			$arr["tot_pay"]		 = $this->input->post("totalpay", true);
			$arr["company"]      = $this->session->companey_id;		
			$arr["cust_id"] 	 = $this->input->post("customer", true);
			$arr["added_by"]	 = $this->session->user_id;
			$arr["created_date"] = date("Y-m-d h:i:s");
			$arr["approve"] = 1;
			
			
			$ret  = $this->db->insert("payment", $arr);  
		
		}
		
		if($ret){
			
		
			$this->session->set_flashdata("message", "Successfully saved");
		}else{
			$this->session->set_flashdata("message", "Failed to saved");
			
		}
	
	}
	
	public function cleandate($post){
		
		$pdate = $this->input->post($post, true);
		
		if(!empty($pdate)) {
			$pdate = str_replace("/", "-", $pdate);
			
			$darr  = explode("-", $pdate); 
			
			return date("Y-m-d", strtotime($darr[2]."-".$darr[0]."-".$darr[1]));
		}
		
	}
	
	
}	
?>
