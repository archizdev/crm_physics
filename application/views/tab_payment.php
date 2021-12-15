    <div class="tab-pane" id="payment">
 <hr>
 
<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th-sm">S.No</th>
      <th class="th-sm">Payment Mode</th>
      <th class="th-sm">Stage</th>
      <th class="th-sm">Disposition</th>
    <th class="th-sm">Date</th>
<?php if($this->session->companey_id=='83'){ ?>   
    <th class="th-sm">Registration fees</th>
    <th class="th-sm">Stamp Paper Charge</th>
    <th class="th-sm">Received amount</th>
    <th class="th-sm">Received date</th>
<?php }else{ ?>
      <th class="th-sm">Amount</th>
<?php } ?>
      <th class="th-sm">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php $i=1; foreach($ins_list as $val){ ?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php if($val->pay_mode==1){ echo 'One Time';}else{ echo 'Installment';}  ?></td>
      <td><?php if($val->stage_id!='---Select Stage---'){foreach($all_stage_lists as $stage){ if($stage->stg_id==$val->stage_id){echo $stage->lead_stage_name;}}}else{ echo 'NA';} ?></td>
      <td><?php if($val->desc_id!='---Select Description---'){ foreach($all_description_lists as $discription){ if($discription->id==$val->desc_id){echo $discription->description;}}}else{ echo 'NA';} ?></td>
      <td><?php if($val->ins_dt!=''){echo $val->ins_dt;}else{ echo 'NA'; } ?></td>
<?php if($this->session->companey_id=='83'){ ?>   
    <td><?php echo $val->reg_amt; ?></td>
    <td><?php echo $val->stamp_amt; ?></td>
    <td><?php echo $val->recieved_amt; ?></td>
    <td><?php echo $val->recieved_date; ?></td>
<?php }else{ ?>
    <td><?php echo $val->ins_amt; ?></td>
<?php } ?>
      <td>
<?php if($this->session->companey_id=='83'){ ?>
<a href="#modal7<?= $i?>" class="btn btn-info" data-toggle="modal" data-animation="effect-scale">Close</a>
 <?php } ?>
 <?php if($val->pay_status=='0'){ ?>
 <a href="#modal6<?= $i?>" class="btn btn-danger" data-toggle="modal" data-animation="effect-scale">Send Link</a>
<?php }else{ ?>
    <span class="btn btn-success">Paid</span>
<?php } ?> 
      </td>
    </tr>
  
       <!--------------------------------Modal Popup for Update Payment----------------------------------------------------------------------------->
                      
      <div class="modal fade" id="modal7<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <?php
              echo form_open('client/update_setlled',array('class'=>"",'name'=>'paymentform'));
            ?>
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel6">Update Payment</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
      <input type="hidden" class="form-control" name="pay_id" value="<?= $val->id; ?>">
                  <label for="date">Received amount</label>
                  <input type="text" class="form-control" name="recieved_amt" placeholder="Received amount">
          
          <label for="date">Received date</label>
                  <input type="date" class="form-control" name="recieved_date" placeholder="Received date">
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary tx-13">Send</button>
          </div>
        </div>
        <?php echo form_close()?>
      </div>
    </div>

<!-----------------------------------------------END------------------------------------>
  
     <!--------------------------------Modal Popup for Amount----------------------------------------------------------------------------->
                      
      <div class="modal fade" id="modal6<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <?php
              echo form_open('payment/send_payment_link_mail',array('class'=>"",'name'=>'scheduleform'));
            ?>
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel6">Enter Amount</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
      
                  <label for="date">Amount</label>
                  <input type="text" class="form-control" name="amount" value="<?= $val->ins_amt; ?>">
          
          <label for="date">Remark</label>
                  <textarea type="text" class="form-control" name="remark"></textarea>
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary tx-13">Send</button>
          </div>
        </div>
        <?php echo form_close()?>
      </div>
    </div>

<!-----------------------------------------------END------------------------------------>
    <?php $i++;} ?>
  </tbody>
</table> 
 
 
 <script>
     $(document).ready(function () {
  $('#dtBasicExample').DataTable();
  $('.dataTables_length').addClass('bs-select');
});
 </script>
 
 <form class="" action="<?php echo base_url()?>client/create_payment/<?php echo $this->uri->segment(3); ?>" id="" method="post" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12">        
                  <div class="row">
                <div class="col-md-6">
            <label>Payment Mode<i class="text-danger"></i></label>
            <select class="form-control"  name="modepay"  id="modepay"> 
                        <option>Select Payment</option>
              <option value = "1">Onetime</option>
              <option value = "2">Installment</option>
            </select>
        </div>


<div class="col-md-6">
            <label>Payment Mode<i class="text-danger"></i></label>
            <select class="form-control"  name="typpay"  id="typpay" onchange="showDivs(this)"> 
                        <option>Select Type</option>
              <option value = "1">From Stage</option>
              <option value = "2">From Date</option>
            </select>
        </div>    

<div id="hidden_div1" class="container1" style="display:none;">
        
        <div class="form-group col-sm-6">
                          <label>Stage Name <i class="text-danger"></i></label>
                        <select class="form-control" id="lead_stage_change_pay" name="lead_stage_pay" onchange="find_descriptionss()">
                              <option>---Select Stage---</option>
                              <?php 
                              $id = '';
                              foreach($all_estage_lists as $single){                 
                                 //$id=$single->lead_stage;                              
                              }
                              ?>
                              <?php foreach ($all_stage_lists as $stage) {  ?>
                              <option value="<?= $stage->stg_id?>" <?php if ($stage->stg_id == $details->lead_stage) {echo 'selected';}?>><?php echo $stage->lead_stage_name; ?></option>
                              <?php } ?>
                           </select>
                     </div>
                                                  
                     <div class="form-group col-sm-6">
                        <label>Description <i class="text-danger"></i></label>
                        <select class="form-control" id="lead_descriptionss" name="lead_description_pay">
                               <option>---Select Description---</option>
                              
                         </select> 
                     </div>
</div>
<div class="col-md-6" id="hidden_div" style="display:none;">
            <label>Date<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="Enter Date" name="dt">
        </div>
    
<?php if($this->session->companey_id=='83'){ ?>
<div class="col-md-6">
            <label>Registration fees<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="Enter Fee" name="reg_amt">
        </div>

<div class="col-md-6">
            <label>Stamp Paper Charge<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="Enter Charge" name="stamp_amt">
        </div>    
<?php }else{ ?>   
<div class="col-md-6">
            <label>Amount<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="Enter Ammount" name="amt">
        </div>
<?php } ?>
<div class="col-md-6" style="padding:20px;">                                                
                              <input class="btn btn-success" type="submit" value="Submit" name="submit" >           
                           </div>

</div>

</div>

</form>
<script type="text/javascript">
function showDivs(select){
   if(select.value==1){
    document.getElementById('hidden_div1').style.display = "block";
    document.getElementById('hidden_div').style.display = "none";
   }else if(select.value==2){
    document.getElementById('hidden_div1').style.display = "none";
    document.getElementById('hidden_div').style.display = "block";
   }
} 
</script>
 <script type="text/javascript">
  function find_descriptionss(f=0) { 

           if(f==0){
            var l_stage = $("#lead_stage_change_pay").val();
            $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>lead/select_des_by_stage',
            data: {lead_stage:l_stage},
            
            success:function(data){
               // alert(data);
                var html='';
                var obj = JSON.parse(data);
                
                html +='<option value="" style="display:none">---Select---</option>';
        html +='<option value="new" style="">New</option>';
        html +='<option value="updt" style="">Update</option>';
                for(var i=0; i <(obj.length); i++){
                    
                    html +='<option value="'+(obj[i].id)+'">'+(obj[i].description)+'</option>';
                }
                
                $("#lead_descriptionss").html(html);
                
            }
            
            
            });
           }

            }
</script>
            </div>