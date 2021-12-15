<div class="row">
  
				 <div class="panel panel-default pt-2"> 
				<div class="panel-heading no-print" style="background-color: #fff;padding:7px;border-bottom: 1px solid #C8CED3;">
							<div class="row">
					<div class="col-md-12">
						<a href="<?= base_url('feedback/') ?>" class="btn btn-success"> <i class="fa fa-list"></i> Feedback List 
						</a>
					</div>
				</div>
				</div>
				<div class="panel-body">
				<div class="col-md-2"></div>

				<div class="col-md-8 panel-default panel-body" style="border:1px solid #f7f7f7">
				
				<form action="<?= base_url('feedback/insert/') ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" autocomplete="off">
			<div class="row">

				<div id="process_basic_fields"><div class="trackingDetails"></div>                    
                                                                                                      
                      
                      
                                                                               
                   <script type="text/javascript">
                    function loadTracking(that)
                      { //alert(key);
                        if(that.value=='')
                        {

                        }else{
                          $.ajax({
                            url:'<?= base_url('ticket/gc_vtrans_api/') ?>'+that.value,
                            type:'post',
                            data:{trackingno:that.value},
                            beforeSend:function(){

                              $(that).parents('form').find('input,select,button').attr('disabled','disabled');
                            },
                            success:function(q)
                            { 
                              $(that).parents('form').find('input,select,button').removeAttr('disabled');
                              if(q!='0')
                                // $(".trackingDetails").html(q);
                              var resultK = JSON.parse(q);
                                // console.log(q);
                                //  alert(resultK);
                              var gcdate=  resultK.Table.GC_Date;
                              var currentTime = new Date(gcdate)
var month = currentTime.getMonth() + 1
var day = currentTime.getDate()
var year = currentTime.getFullYear()
var date = day + "/" + month + "/" + year
                              $("#gcdate").val(gcdate);
                              $("#BookingBranch").val(resultK.extra.gcDdata.BookingBranch);
                              $("#DeliveryBranch").val(resultK.extra.gcDdata.DeliveryBranch);
                              $("#BookingType").val(resultK.extra.gcDdata.BookingType);
                              $("#DeliveryType").val(resultK.extra.gcDdata.DeliveryType);
                              $("#PaymentType").val(resultK.extra.gcDdata.PaymentType);
                              $("#Articles").val(resultK.extra.gcDdata.Articles);
                              $("#ActualWeight").val(resultK.extra.gcDdata.ActualWeight);
                              $("#ChargedWeight").val(resultK.extra.gcDdata.ChargedWeight);
                              $("#Consignor").val(resultK.extra.gcDdata.Consignor);
                              $("#Consignee").val(resultK.extra.gcDdata.Consignee);
                              $("#ConsignorContactNo").val(resultK.extra.gcDdata.ConsignorContactNo);
                              $("#ConsigneeContactNo").val(resultK.extra.gcDdata.ConsigneeContactNo);
                              $("#CurrentStatus").val(resultK.Table.status);
                              
// alert(date);
                              // else
                              // {
                              //   Swal.fire({
                              //               title: 'GC. No. Not Found!',
                              //               cancelButtonText: 'Ok!'
                              //               });
                              // }
                            },
                            error:function(u,v,w)
                            {
                              console.info(w);
                            }
                          });
                          // tracking_no_check(that.value);
                        }
                      }
                  </script>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>GC No. <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="gc_no" id="" class="form-control" required="" onblur="loadTracking(this)">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>GC Date <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="gc_date" id="gcdate" class="form-control" required="" >
                      </div>
                    </div>
                    <hr>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Delivery Branch <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="DeliveryBranch" id="DeliveryBranch" class="form-control" required="" >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Booking Branch <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="BookingBranch" id="BookingBranch" class="form-control" required="" >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Delivery Type <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="DeliveryType" id="DeliveryType" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Pay Mode <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="PaymentType" id="PaymentType" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Charged Weight <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ChargedWeight" id="ChargedWeight" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Actual Weight <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ActualWeight" id="ActualWeight" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>No Of Articles <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="Articles" id="Articles" class="form-control" required="" >
                      </div>
                    </div>
<hr>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignor Name <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="Consignor" id="Consignor" class="form-control" required="" >
                      </div>
                    </div>

                    <!-- <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignor Tel No <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ConsignorTel" id="ConsignorTel" class="form-control" required="" >
                      </div>
                    </div> -->

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignor Mobile No <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ConsignorContactNo" id="ConsignorContactNo" class="form-control" required="" >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignee Name <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="Consignee" id="Consignee" class="form-control" required="" >
                      </div>
                    </div>
                    
                    <!-- <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignee Tel No<i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ConsigneeTel" id="ConsigneeTel" class="form-control" required="" >
                      </div>
                    </div> -->
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignee Mobile No <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ConsigneeContactNo" id="ConsigneeContactNo" class="form-control" required="" >
                      </div>
                    </div>
<hr>
<div class="col-md-6">
                      <div class="form-group">
                        <label>Status <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="CurrentStatus" id="CurrentStatus" class="form-control" required="" >
                      </div>
                    </div>

                    <!-- onblur="loadTracking(this),match_previous(this.value)"  -->
                     <div class="col-md-6">
                      <div class="form-group">
                        <label>Vehicle No.<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="vehicle_no" required="">
                      </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <label>CSO <i class="text-danger">*</i></label>
                          <input type="text" class="form-control" name="cso" required="" value="" > 
                        </div>
                    </div>                   
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignee/Consignor</label>
                        <div>             
                          <input type="radio" name="user_type" value="1" checked=""> <label>Is Consignor</label>
                          <input type="radio" name="user_type" value="2"> <label>Is Consignee</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Person Name</label>
                        <input type="text" class="form-control" name="person" required="" value="" > 
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Person Contact No</label>
                        <input type="text" class="form-control" name="contact" required="" value="" > 
                      </div>
                    </div>
                   <div class="col-md-6">
                    <div class="form-group">
                      <label>How are the services</label>
                      <select name="How are the services" class="form-control" >
                        <option>Avarage</option>
                        <option>Good</option>
                        <option>Bad</option>
                        <option>Very Bad</option>
                        <option>Excellent</option>
                        <option>Satisfactory</option>
                        <option>Unsatisfactory</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Is this first FTL or No</label>
                        <div>             
                          <input type="radio" name="Is this first FTL or No" value="yes" checked=""> <label>Yes</label>
                          <input type="radio" name="Is this first FTL or No" value="no"> <label>No</label>
                        </div>
                      </div>
                    </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Other locations where FTL service is required</label>
                      <input type="text" class="form-control" name="Other locations where FTL service is required" > 
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>If using any other transporter</label>
                      <input type="text" class="form-control" name="If using any other transporter" > 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Remarks on improvement required</label>
                      <input type="text" class="form-control" name="Remarks on improvement required" > 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Next FTL Booking expected</label>
                      <input type="text" class="form-control" name="Next FTL Booking expected" > 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Customer Feedback</label>
                      <input type="text" class="form-control" name="Customer Feedback" > 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Response Remark</label>
                      <input type="text" class="form-control" name="Response Remark" > 
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Action Taken</label>
                      <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" name="Action Taken" > 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Response By</label>
                      <input type="text" class="form-control" name="Response By"  > 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Assigned To</label>
            <select class="form-control"  name="assign_employee">                    
            <?php foreach ($user_list as $user) {                              ?>
                            <option value="<?php echo $user->pk_i_admin_id; ?>">
                              <?=$user->s_display_name ?>&nbsp;<?=$user->last_name.' - '.$user->s_user_email; ?>                                
                            </option>
                            <?php 
                          //}
                        } ?>                                                      
            </select> 
                    </div>
                  </div> 
        </div>
				<div class="col-md-12 text-center">
					<button class="btn btn-success" type="submit" >Save</button>
				</div>
			</div>
        </form>			
        	<div class="row">
					<div class="col-md-12" id="oldticket">
					</div>
				</div>
			</div>
			</div>
			</div>
        </div>