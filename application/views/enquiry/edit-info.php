<?php  foreach ($info as $key => $value) {
 $displaybranch='';
   ?>

                  <input type="hidden" name="infoid" value="<?= $value->id ?>">
                  <input type="hidden" name="enquiry_id" value="<?= $value->enquiry_id ?>">
                    <!--------------------------------------------------start----------------------------->
                    <div class="row">
                    <div class="row">
                    <div class=" col-sm-3">
                    </div>
                        <div class="col-sm-6">
                    <div class="form-group "> 
                       
                       <center> <label>Info Type</label></center>
                        <select class="form-control" name="type_update" id="infotype_update">
                            <option value="1" <?php if($value->branch_type==1){echo'selected'; $displaybranch='Branch';} ?>>Branch</option>
                            <option value="2" <?php if($value->branch_type==2){echo'selected'; $displaybranch='Zone';} ?>>Zone</option>
                            <option value="3" <?php if($value->branch_type==3){echo'selected'; $displaybranch='Areawise';} ?>>Areawise</option>
                        </select>
                     </div>
                     </div>
                     </div>
                     <center><h3>DISPTACH LOCATION</h3></center>
                     <br>
                     <div class="form-group col-sm-6"> 
                        <label>Booking Type</label>
                        <select class="form-control" name="booking_type" id="booking_type_update">
                            <option value="0" <?php if($value->booking_type==0){echo'selected';} ?>>Sundry</option>
                            <option value="1" <?php if($value->booking_type==1){echo'selected';} ?>>FTL</option>
                        </select>
                     </div>
                     <div class="form-group col-sm-6"> 
                        <label>Business Type</label>
                        <select class="form-control" name="business_type" id="business_type">
                            <option value="">-Select-</option>
                            <option value="0" <?php if($value->business_type==0){echo'selected';} ?>>Inward</option>
                            <option value="1" <?php if($value->business_type==1){echo'selected';} ?>>outward</option>
                        </select>
                     </div>
                        <div class="form-group col-sm-6"> 
                           <label id="textdisplay_old">Booking <?= $displaybranch ?></label>
                           <select class="form-control" name="booking_branch_update" id="booking_branch_update">
                              <option value="">-Select-</option>
                            <?php 
                            foreach($branch as $dbranch){ ?>
                                  <option value="<?= $dbranch->branch_id ?>" <?php if($value->booking_branch==$dbranch->branch_id){echo'selected';} ?>><?= $dbranch->branch_name ?></option>
                                 <?php }  ?>
                           </select>
                        </div>
                        <div class="form-group col-sm-6"> 
                           <label id="textdisplay_new">Delivery <?= $displaybranch ?></label>
                           <select class="form-control" name="delivery_branch_update" id="delivery_branch_update"  onchange="delivery_branch_data();">
                              <?php  
                              foreach($branch as $dbranch){ ?>
                                  <option value="<?= $dbranch->branch_id ?>" <?php if($value->delivery_branch==$dbranch->branch_id){echo'selected';} ?>><?= $dbranch->branch_name ?></option>
                                 <?php }  ?>
                           </select>
                        </div>
                              <div class="form-group col-sm-6"> 
                                 <label>Insurance</label>
                                 <select class="form-control" name="insurance" id="insurance">
                                    <option value="0" <?php if($value->insurance==0){echo'selected';}?>>Carrier</option>
                                    <option value="1" <?php if($value->insurance==1){echo'selected';}?>>Owner risk</option>
                                 </select>
                              </div>
                              <div class="sundry" id="sundry_update"   <?php if($value->booking_type==1){ echo'style="display:none"'; }?>>
                              <div class="form-group col-sm-6"> 
                                 <label>Rate</label>
                                 <input class="form-control rate" name="rate" id="rate_update" type="text" value="<?= $value->rate ?>"  >  
                              </div>
                              <div class="form-group col-sm-6"> 
                                 <label>Discount</label>
                                 <input class="form-control" name="discount" id="discount_update" type="text" value="<?= $value->discount ?>" >  
                              </div>
                              <div class="form-group col-sm-6"> 
                              <label>Pay Mode</label>
                              <select class="form-control" name="paymode" id="paymode">
                                 <option value="1" <?php if($value->paymode==1){echo'selected';}?>>paid</option>
                                 <option value="2" <?php if($value->paymode==2){echo'selected';}?>>To-Pay</option>
                                 <option value="3" <?php if($value->paymode==3){echo'selected';}?>>Tbb</option>
                              </select>
                           </div>
                           <div class="form-group col-sm-6"> 
                                 <label>Potential Tonnage</label>
                                 <input class="form-control" name="potential_tonnage" id="potential_tonnage_update" type="text"   value="<?= $value->potential_tonnage ?>">  
                              </div>
                              <div class="form-group col-sm-6"> 
                                 <label>Potential Amount</label>
                                 <input class="form-control" name="potential_amount" id="potential_amount_update" type="text"  value="<?= $value->potential_amount ?>">  
                              </div>
                              <div class="form-group col-sm-6"> 
                                 <label>Expected Tonnage</label>
                                 <input class="form-control" name="expected_tonnage" id="expected_tonnage_update" type="text" value="<?= $value->expected_tonnage ?>" >  
                              </div>
                              <div class="form-group col-sm-6"> 
                                 <label>Expected Amount</label>
                                 <input class="form-control" name="expected_amount" id="expected_amount_update" type="text" value="<?= $value->expected_amount ?>" >  
                              </div>


                              </div>
                              
                              <div class="ftl" id="ftl_update" <?php if($value->booking_type==0){ echo'style="display:none"'; } ?>>
                                 <div class="form-group col-sm-6"> 
                                    <label>Vehicle type</label>
                                    <input class="form-control" name="vehicle_type" id="Vehicle_type" type="text" value="<?= $value->rate ?>" >  
                                 </div>
                                 <div class="form-group col-sm-6"> 
                                    <label>Vehicle Carrying Capacity</label>
                                    <input class="form-control" name="capacity" id="capacity" type="text" value="<?= $value->rate ?>" >  
                                 </div>
                              
                                 <div class="form-group col-sm-6"> 
                                    <label>Invoice Value</label>
                                    <input class="form-control" name="invoice_value" id="invoice_value" type="text" value="<?= $value->rate ?>" >  
                                 </div>
                                 <div class="form-group col-sm-6"> 
                                    <label>Pay Mode</label>
                                    <select class="form-control" name="ftlpaymode" id="ftlpaymode">
                                       <option value="1" <?php if($value->paymode==1){echo'selected';}?>>paid</option>
                                       <option value="2" <?php if($value->paymode==1){echo'selected';}?>>To-Pay</option>
                                       <option value="3" <?php if($value->paymode==1){echo'selected';}?>>Tbb</option>
                                    </select>
                                </div>
                                 <div class="form-group col-sm-6"> 
                                    <label>Potential Amount</label>
                                    <input class="form-control" name="ftlpotential_amount" id="ftlpotential_amount_update" type="text" value="<?= $value->expected_tonnage ?>" >  
                                 </div>
                                 <div class="form-group col-sm-6"> 
                                    <label>Expected Amount</label>
                                    <input class="form-control" name="ftlexpected_amount" id="ftlexpected_amount_update" type="text" value="<?= $value->expected_amount ?>" >  
                                 </div>

                              </div>
                              </div>
              <?php } ?>         
       <script>
   function delivery_branch_data()
{
var delivery_branch = $("select[name='delivery_branch_update']").val()??[];
var booking_branch = $("select[name='booking_branch_update']").val();
     $.ajax({
      type: 'POST',
      url: '<?php echo base_url();?>enquiry/get_rate',
      data: {delivery_branch:delivery_branch,booking_branch:booking_branch},
      success:function(data){
          var obj = JSON.parse(data);

          $("#rate_update").val(obj.rate);
      }
      });
}

$('#potential_tonnage_update').on('change', function() {
                var discount = $("#discount_update").val();
                var rate = $("#rate_update").val();

                var potential_tonnage = document.getElementById('potential_tonnage_update').value;    
                var weightinKg= potential_tonnage*1000;       
               var total_ptAmount=weightinKg*rate;
               // alert(total_ptAmount);
                total_ptAmount =  (total_ptAmount - ((total_ptAmount * discount)/100));
                total_ptAmount = total_ptAmount.toFixed(2);

                        $("#potential_amount_update").val(total_ptAmount);
                    });

  $('#expected_tonnage_update').on('change', function() {
               var discount = $("#discount_update").val();
                var rate = document.getElementById('rate_update').value;           
                var expected_tonnage = document.getElementById('expected_tonnage_update').value;    
                var weightinKg= expected_tonnage*1000;       
               var total_extAmount=weightinKg*rate;
               // alert(total_ptAmount);

                total_extAmount =  (total_extAmount - ((total_extAmount * discount)/100));
                total_extAmount = total_extAmount.toFixed(2);
                        $("#expected_amount_update").val(total_extAmount);
                    });

                    $('#infotype_update').on('change', function() {
            var infotype = $("select[name='type_update']").val();
            if(infotype==1){
               $("#textdisplay_old").html('Booking Branch');
               $("#textdisplay_new").html('Delivery Branch');
            }else if(infotype==2){
               $("#textdisplay_old").html('Booking Zone');
               $("#textdisplay_new").html('Delivery Zone');

            }else if(infotype==3){
               $("#textdisplay_old").html('Booking Area');
               $("#textdisplay_new").html('Delivery Area');

            }else{
               $("#textdisplay_old").html('Booking Branch');
               $("#textdisplay_new").html('Delivery Branch');

            }
});

                    $(document).ready(function(){
    var dl = document.getElementById('delivery_branch_update');
    var event = new Event('change'); 
    dl.dispatchEvent(event);
    $('#booking_type_update').on('change', function() {
      if ( this.value == '1')
      {
        $("#ftl_update").show();
        $("#sundry_update").hide();
      }  else {
        $("#sundry_update").show();
        $("#ftl_update").hide();
      }
    });
});

       </script>     