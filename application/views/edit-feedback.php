<?php 

foreach ($feedbacks as $key => $values) {
    $data=json_decode($values->feedback);
  
        ?>
         <?= 
    $this->session->flashdata('form-data');
    ?>
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
				
				<form action="<?= base_url('dashboard/editinsert_feedback') ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8" autocomplete="off">
                <div class="row">
                                     <div class="col-md-6">
                      <div class="form-group">
                        <label>GC No. <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="feedback_id" class="form-control" value="<?=$values->id ?>" required="" hidden >
                        <input type="text" name="gc_no" id="" class="form-control" value="<?=$data->gc_no ?>" required="" >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>GC Date <i class="text-danger opt">*</i>
                         </label>
                        <input  name="gc_date" id="gcdate" class="form-control" value="<?=$data->gc_date ?>" >
                      </div>
                    </div>
                    <hr>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Delivery Branch <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="DeliveryBranch" value="<?=$data->DeliveryBranch ?>" id="DeliveryBranch" class="form-control" required="" >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Booking Branch <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="BookingBranch" value="<?=$data->BookingBranch ?>" id="BookingBranch" class="form-control" required="" >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Delivery Type <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="DeliveryType" value="<?=$data->DeliveryType ?>" id="DeliveryType" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Pay Mode <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="PaymentType" id="PaymentType" value="<?=$data->PaymentType ?>" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Charged Weight <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ChargedWeight" value="<?=$data->ChargedWeight ?>" id="ChargedWeight" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Actual Weight <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="ActualWeight" value="<?=$data->ActualWeight ?>" id="ActualWeight" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>No Of Articles <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="Articles" value="<?=$data->Articles ?>" id="Articles" class="form-control" required="" >
                      </div>
                    </div>
<hr>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignor Name <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="Consignor" value="<?=$data->Consignor ?>" id="Consignor" class="form-control" required="" >
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
                        <input type="text" name="ConsignorContactNo" id="ConsignorContactNo" class="form-control" required="" value="<?=$data->ConsignorContactNo ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignee Name <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="Consignee" id="Consignee" class="form-control" required="" value="<?=$data->Consignee ?>">
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
                        <input type="text" name="ConsigneeContactNo" id="ConsigneeContactNo" class="form-control" required="" value="<?=$data->ConsigneeContactNo ?>">
                      </div>
                    </div>
<hr>
<div class="col-md-6">
                      <div class="form-group">
                        <label>Status <i class="text-danger opt">*</i>
                         </label>
                        <input type="text" name="CurrentStatus" id="CurrentStatus" class="form-control" required="" value="<?=$data->CurrentStatus ?>">
                      </div>
                    </div>

                     <div class="col-md-6">
                      <div class="form-group">
                        <label>Vehicle No.<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="vehicle_no" required="" value="<?=$data->vehicle_no ?>">
                      </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <label>CSO <i class="text-danger">*</i></label>
                          <input type="text" class="form-control" name="cso" required=""  value="<?=$data->cso ?>" > 
                        </div>
                    </div>                   
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Consignee/Consignor</label>
                        <div>             
                          <input type="radio" name="user_type" value="1" <?php if ($data->user_type==1) {
                            echo'checked=""';
                          } ?> > <label>Is Consignor</label>
                          <input type="radio" name="user_type" value="2" <?php if ($data->user_type==2) {
                            echo'checked=""';
                          } ?>> <label>Is Consignee</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Person Name</label>
                        <input type="text" class="form-control" name="person" required="" value="<?=$data->person ?>" > 
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Person Contact No</label>
                        <input type="text" class="form-control" name="contact" required="" value="<?=$data->contact ?>" > 
                      </div>
                    </div>
                   <div class="col-md-6">
                    <div class="form-group">
                      <label>How are the services</label>
                      <select name="How are the services" class="form-control" >
                        <option <?php if($data->How_are_the_services=='Avarage'){echo'selected';} ?>>Avarage</option>
                        <option <?php if($data->How_are_the_services=='Good'){echo'selected';} ?>>Good</option>
                        <option <?php if($data->How_are_the_services=='Bad'){echo'selected';} ?>>Bad</option>
                        <option <?php if($data->How_are_the_services=='Very Bad'){echo'selected';} ?>>Very Bad</option>
                        <option <?php if($data->How_are_the_services=='Excellent'){echo'selected';} ?>>Excellent</option>
                        <option <?php if($data->How_are_the_services=='Satisfactory'){echo'selected';} ?>>Satisfactory</option>
                        <option <?php if($data->How_are_the_services=='Unsatisfactory'){echo'selected';} ?>>Unsatisfactory</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Is this first FTL or No</label>
                        <div>             
                          <input type="radio" name="Is this first FTL or No" value="yes" <?php if($data->Is_this_first_FTL_or_No=='yes'){echo'checked=""';} ?>> <label>Yes</label>
                          <input type="radio" name="Is this first FTL or No" value="no" <?php if($data->Is_this_first_FTL_or_No=='no'){echo'checked=""';} ?>> <label>No</label>
                        </div>
                      </div>
                    </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Other locations where FTL service is required</label>
                      <input type="text" class="form-control" name="Other locations where FTL service is required" value="<?php if(!empty($data->Other_locations_where_FTL_service_is_required)){echo$data->Other_locations_where_FTL_service_is_required; } ?>"> 
                    </div>
                  </div>  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>If using any other transporter</label>
                      <input type="text" class="form-control" name="If using any other transporter" value="<?php if(!empty($data->If_using_any_other_transporter)){echo$data->If_using_any_other_transporter; } ?>"> 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Remarks on improvement required</label>
                      <input type="text" class="form-control" name="Remarks on improvement required" value="<?php if(!empty($data->Remarks_on_improvement_required)){echo$data->Remarks_on_improvement_required; } ?>"> 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Next FTL Booking expected</label>
                      <input type="text" class="form-control" name="Next FTL Booking expected" value="<?php if(!empty($data->Next_FTL_Booking_expected)){echo$data->Next_FTL_Booking_expected; } ?><?=$data->gc_no ?>"> 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Customer Feedback</label>
                      <input type="text" class="form-control" name="Customer Feedback" value="<?php if(!empty($data->customer_feedback)){echo$data->customer_feedback; } ?>"> 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Response Remark</label>
                      <input type="text" class="form-control" name="Response_Remark" value="<?php if(!empty($data->Response_Remark)){echo$data->Response_Remark; } ?>"> 
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Action Taken</label>
                      <input  class="form-control form-date" name="Action_Taken" value="<?php if(!empty($data->Action_Taken)){echo$data->Action_Taken; } ?>"> 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Response By</label>
                      <input type="text" class="form-control" name="Response_By"  value="<?php if(!empty($data->Response_By)){echo$data->Response_By; } ?>"> 
                    </div>
                  </div> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Assigned To</label>
                      <input name="lead_pass_on" value="<?= $data->lead_pass_on ?>" hidden>
            <select class="form-control"  name="assign_employee">                    
            <?php foreach ($user_list as $user) {                              ?>
                            <option value="<?php echo $user->pk_i_admin_id; ?>"  <?php if ($data->lead_pass_to==$user->pk_i_admin_id) {
                             echo'selected';
                            } ?>>
                              <?=$user->s_display_name ?>&nbsp;<?=$user->last_name.' - '.$user->s_user_email; ?>                                
                            </option>
                            <?php 
                          
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
        <?php } ?>