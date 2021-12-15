<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Buy extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array( 
            'Product_model'
        ));
		$this->load->model("sell_model");
		$this->load->library('cart');
		if (user_role('480') == true) {}
    }
	public function thankyou(){
		$res = $_GET;
		$ins_arr = array(
					'uid'   => $this->session->user_id,
					'status'=> $res['payment_status'],
					'txnid' => $res['payment_id'],					
					'comp_id' => $this->session->companey_id,					
					'method' => 'instamojo',					
					'response'   => json_encode($_GET)
				  ); 
		if($res['payment_status'] != 'Failed'){
			$amt	=	$this->cart->total();
			$this->placeorder();		
			
			$ins_arr['ins_id']	= $ordno = $_SESSION['orderno'];
			$this->db->insert('payment_history',$ins_arr);			
			$pay = !empty($this->session->part_payment_amount)?$this->session->part_payment_amount:$amt;
			$arr = array(
					"pay" 			 => $pay,
					"balance" 		 => $amt-$pay,
					"pay_mode" 		 => 2, // Online
					"transaction_no" => $res['payment_id'],
					"status" 		 => 1,
					"pay_date" 		 => date('Y-m-d'), 
					"next_pay"		 => '',
					"remark" 		 => '',
					);	
			$arr["prev_balance"] = 0;							
			$arr["ord_id"] 		 = $ordno;
			$arr["tot_pay"]		 = $amt;
			$arr["company"]      = $this->session->companey_id;		
			$arr["cust_id"] 	 = $this->session->user_id;
			$arr["added_by"]	 = $this->session->user_id;
			$arr["created_date"] = date("Y-m-d h:i:s");
			$arr["approve"] = 1;
			$this->load->model('payment_model');
			$this->payment_model->save_payment($arr);
			redirect(base_url("order/invoice/".$ordno), "refresh");			
		}else{
			$this->db->insert('payment_history',$ins_arr);
			redirect('buy/checkout');
		}
	}
	public function index(){
		
		$data['title'] = 'Product List';
		$data['limit'] = 8;
		$data['product_list'] = $this->Product_model->productdetlist(1,1);
		$data["totalprod"]        = $this->Product_model->productdetlist(2,1);
		//$data['category'] = $this->sell_model->subCategory();
		$carts = $this->cart->contents();
		
		$prodcart = array();
		if(!empty($carts)){
			foreach($carts as $ind =>$crd) {
				
				$prodid = $crd['id'];
				$prodcart[$prodid]	= $crd['qty'];
			}
			
		}
		$this->load->model('sell_model');
  		$data['prod_category'] = $this->sell_model->subCategory();
		$data['incart']  = $prodcart;
		$data['content'] = $this->load->view('sell/product-list', $data, true);
        $this->load->view('layout/main_wrapper', $data);
		
	}
	public function checkAlreadyExist()
    {
        $user      = $this->input->post('user');
        $parameter  = $this->input->post('parameter');
        if($parameter == 'userid')
        {
            $check  = $this->db->select('pk_i_admin_id')->from('tbl_admin')->where('employee_id',"$user")->get()->result();
        }
        
        if(empty($check))
        {
            echo json_encode(array('status'=>"notexist"));
        }else{
        	echo json_encode(array('status'=>"exist"));
        }
    }
	public function checkout(){		
		$data = array();
		$prodcart = array();
		$carts = $this->cart->contents();
		if(!empty($carts)){
			foreach($carts as $ind =>$crd) {
				// echo'=> min'. $crd['minalert'];
				// echo'<br>';
				// echo $crd['qty'];
				if($crd['qty']<$crd['minalert']){
		      	$this->session->set_flashdata('exception', 'Please order minimum '.$crd['minalert'].' '.$crd['name'].' Product');
					redirect('buy');
					// echo'yes';
					// exit();
				}
				$prodid = $crd['id'];
				$prodcart[$prodid]	= $crd['qty'];
			}
			
		} 
		// die();
		$this->load->model('user_model');
		$this->load->model('location_model');
		$uid = $this->session->user_id;
		$data['uid'] = $uid;
		$data['user_row']	=	$this->user_model->read_by_id($uid);
		//$data['user_city']	=	$this->location_model->ecity_list();
		$data['user_state']	=	$this->location_model->estate_list_api();
		$data['user_meta'] = $this->user_model->get_user_meta($uid,array('postal_code','gstin'));
		if (empty($prodcart)) {
			$data['content'] = '<br><div class="alert alert-danger text-center"><h2>Your Cart in empty.</h2></div>';
		}else{
			$data['content']	=	$this->load->view('sell/checkout_form',$data,true);
		}
        $this->load->view('layout/main_wrapper', $data);	
	}
	
	public function __checkout(){
		
		if(isset($_POST)){
			$this->placeorder();
		}
		
		$data['carts'] = $this->cart->contents();
		$data['category'] = $this->sell_model->subCategory();
	
		$prdarr = array();
		if(!empty($data['carts'])){
			foreach($data['carts'] as $ind => $crt){
				
				$prdarr[] = $crt['id'];	
			}
			
		}	
		if(!empty($prdarr)) {
			$products  = $this->Product_model->productdetin($prdarr);
		}
		$newprdarr = array(); 
		if(!empty($products)){
			foreach($products as $ind => $prd){
				
				$newprdarr[$prd->id] = $prd;	
			}
		}
		
		
		
		$data['products'] = $newprdarr;
		
		if(isset($_SESSION['page']) and $_SESSION['page'] == 'invoice'){
			
				$ordno = $_SESSION['orderno'];
			unset($_SESSION['orderno']);
			unset($_SESSION['page']);
			redirect(base_url("order/invoice/".$ordno), "refresh");
		
		}else{
			$data['content'] = $this->load->view('sell/checkout', $data, true);
        	
		}
		
		$this->load->view('layout/main_wrapper', $data);
		
	}
	
	public function placeorder(){		
		$ordno = "ORD".strtotime(date("Y-m-d h:i:s"));		
		$carts = $this->cart->contents();
		$ret   = false; 
		if(!empty($carts)){
			foreach($carts as $ind => $crt){				
				$arr[] = array(
							 "ord_no"  		=> $ordno,
							 "cus_id"  		=> $this->session->user_id,
							 "enq_no"  		=> "",
							 "payment_mode" => $this->session->payment_mode,
							 "warehouse"    => "",
							 "product"		=> $crt['id'],
							 "conf_delv"    => 0,
							 "pend_delv"	=> $crt['qty'],
							 "delvr_date"	=> NULL,
							 "next_date"    => NULL,
							 "scheme"		=> 0,
							 "quantity"		=> $crt['qty'],
							 "price"		=> $crt['price'],		
							 "offer"        => $crt['discount'],
							 "tax"        	=> $crt['gst'],
							 "details"      => "",
							 "disc_meth"    => "",
							 "disc_price"   => $crt['discount'],
							 "disc_type"    => "",
							 "other_price"  => 0,
							 "total_price"  => $crt['price']*$crt['qty'],
							 "addedby"      => $this->session->user_id,
							 "order_date"   => date("Y-m-d h:i:s"),
							 "status"       => 1,
							 "company"      => $this->session->companey_id,
							 "ip"			=> ""
							 );		
			}
			$ret = $this->db->insert_batch("tbl_order", $arr);
		}
		if($ret){
			$this->cart->destroy();
			$this->session->set_flashdata('message', "Successfully saved");
			$_SESSION['page'] = "invoice";
			$_SESSION['orderno'] = $ordno;
		}else{
			$this->session->set_flashdata('exception', "Failed to create order");
		}		
	}	
	
	public function view($prodno){	
		$data['product'] = $this->Product_model->productdet($prodno) ;
		//print_r($data['product']); exit();
		//print_r($data['product']);die;
		$data['category'] = $this->sell_model->subCategory();
		$carts = $this->cart->contents();		
		$prodcart = array();
		if(!empty($carts)){
			foreach($carts as $ind =>$crd) {				
				$prodid = $crd['id'];
				$prodcart[$prodid]	= $crd['qty'];
			}			
		}
		$this->load->model('enquiry_model');
        $data['dynamic_field']  = $this->Product_model->get_product_dynamic_fields_data($prodno);        
		$data['title'] = 'Product List';
		$data['incart']  = $prodcart;
		$data['content'] = $this->load->view('sell/view-product', $data, true);
        $this->load->view('layout/main_wrapper', $data);		
	}
	
	public function loadsubcateg($categ = ""){
		
		if(!empty($categ)){
			
			$sbcateg = $this->db->select("*")->where("cat_id", $categ)->get("tbl_subcategory")->result();
			
			if(!empty($sbcateg)){
				?><option value=""></option><?php
				foreach($sbcateg as $ind => $sbctg){
					
					?><option value="<?php echo $sbctg->id ?>"><?php echo $sbctg->subcat_name; ?></option><?php
				}
				
			}
			
			
		}
		
	}
	
		public function addtocart(){
		$this->cart->product_name_rules = '[:print:]';
		$this->form_validation->set_rules("product", "Product", "trim|required");
		
		if($this->form_validation->run()){
			
			$cardcontent = $this->cart->contents();
			
			$prodno  = $this->input->post("product", true); 
			$pqty    = $this->input->post("qty", true);   
			$product = $this->Product_model->productdet($prodno) ;
				$prdarr = array();
			if(!empty($cardcontent)){
				foreach($cardcontent as $ind => $crt){
					
					$prdarr[] = $crt['id'];	
				}
				
			}
			if(!empty($prdarr))	{		
						$products  = $this->Product_model->productdetin($prdarr);
			}	
			$newprdarr = array(); 
			if(!empty($products)){
				foreach($products as $ind => $prd){
					
					$newprdarr[$prd->id] = $prd;	
				}
			}
			
			$gst_price = 0;
			if ($product->gst>0) {
				$gst_price = round((float)$product->price*((float)$product->gst/100),1);				
			}
			$data = array('id'      => $prodno,
							'qty'       => 1,
							'price'     => round($product->price+$gst_price,1),
							'name'		=> $product->country_name,
							'discount'  => (isset($_POST['disc'])) ? $this->input->post("disc", true) : 0,
							'minalert' => !empty($product->minimum_order_quantity)?$product->minimum_order_quantity:0,
							'gst'		=> $product->gst
							);
			$newcart = array();	
			$tqty = $qty  = 1;
			if(!empty($cardcontent)){
				
				$isupdate = false;
				foreach($cardcontent as $ind => $crt){
					
					if($crt['id'] == $prodno){
						
							$currdate = date("Y-m-d");
						if(!empty($newprdarr[$prodno]) and  $prd->from_date <= $currdate and $currdate <=  $prd->to_date){
							$prd = $newprdarr[$prodno];
							if($prd->calc_mth == 1){
								
								 $disc =  round(($prd->price *$prd->discount/100),1);
							}else{
								 $disc =  $prd->discount;
								
							}	
							$data['discount'] = $disc;
			
							if (!empty($product->gst)) {
								$gst_price =	round($product->price*($product->gst/100),1);		
							}
							$data['price'] = $product->price - $disc+$gst_price;		
						}
						
						$qty 		=   $crt['qty'];
						$tqty       = $qty;
						$rowid      = $crt['rowid'];
						$isupdate   = true;
						
					}
					
				}
				
				if($isupdate == true) {
					
					if($pqty >= 1){
						
						$tqty = $pqty;
					}else if($pqty == 0 ){
						
						$tqty = 0;
					}else{
						$tqty = $qty + $pqty;
					}
					
					$data = array('rowid' => $rowid,
								  'qty'   => $tqty 
								);
					
					$status = 2;	
				
					$this->cart->update($data);			
				}else{
					$status = 1;	
					//$prdarr["total"] = count($cardcontent) + 1;
					$this->cart->insert($data);
				}
				$cardcontent = $this->cart->contents();
				$gst_price = 0;
				if ($product->gst>0) {
					$gst_price = round((float)$product->price*((float)$product->gst/100),1);				
				}
				
				$prdarr = array("status" => $status,"prodid" => $prodno, "product" => $product->country_name, "price" => (float)$product->price+(float)$gst_price , "qty" => (int)$qty + (int)$pqty,"total" => count($cardcontent),'minalert'=>!empty($_POST['minimum']) ? $_POST['minimum'] : 0);
				
			}else{
				$gst_price = 0;
				if ($product->gst>0) {
					$gst_price = round((float)$product->price*((float)$product->gst/100),1);				
				}
				$prdarr = array("status" => 1,"prodid" => $prodno, "product" => $product->country_name, "price" => (float)$product->price+(float)$gst_price, "qty" => (int)$data['qty'],"total" => count($cardcontent) + 1,'minalert'=>$data['minalert']);
				$this->cart->insert($data);	
			}				
			$alltotal = 0;
			if(!empty($cardcontent)){
				$isavl = false;
				foreach($cardcontent as $ind => $crt){
				
					$alltotal = $alltotal + $crt['subtotal'];
					
					if($crt['id'] == $prodno){
						
						$prdarr['qty'] 	 = $crt['qty'];
						$prdarr['price'] = $crt['price'];
						
						$isavl =  true;
					}
					
				}
				if($isavl == false){
					
					$prdarr['qty'] 	 = 0;
				}
			}
			
			$prdarr['subtotal'] = $alltotal;
		
		}else{
			
				$prdarr = array("status" => 0,"message" => "Failed to add cart");
			
		}
		
	
		die(json_encode($prdarr));	
	}
	public function cart()
	{
		$cols=[];
		if(!empty($this->cart->contents())) {
			$cartarr = $this->cart->contents();
			foreach($cartarr as $ind => $cart) {
			$productData = $this->Product_model->productdet($cart['id']);
			
		echo ' <li id = "cart-li-'.$cart['id'].'" >  
			  <div class = "cart-items"><h4><a class="prodname" href = "">'.$cart['name'].'</a></h4>
				  <p> Price : <i class = "fa fa-price"></i> '.$cart['price'].' X <input type="hidden" name="minimum" class="minimum" value="'.$productData->minimum_order_quantity.'"> <input type="number" onchange="manageCartQty()" class="cart-qty" value="'.$cart['qty'].'" min="1" data-prodid="'.$cart['id'].'" > = <i class = "fa fa-rupee"></i><span class="item-price-'.$cart['id'].'">'.round($cart['price']*$cart['qty'],2).'</span> 
					<a href="javascript:void(0)" onclick="remove_cart_item('.$cart['id'].')" class="fa fa-trash btn btn-danger btn-sm pull-right remove-item-cart"></a>
				  </p>
				  <hr />
				  </div>
			  </li>';
	}
}
	}
}