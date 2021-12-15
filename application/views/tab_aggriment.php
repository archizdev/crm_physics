    <div class="tab-pane" id="aggrement">
 <hr>
 
<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th-sm">S.No</th>
      <th class="th-sm">Name</th>
      <th class="th-sm">Mobile</th>
      <th class="th-sm">Email</th>
      <th class="th-sm">Address</th>
    <th class="th-sm">Aggrement Date</th>
      <th class="th-sm">Before sign</th>
    <th class="th-sm">After sign</th>
    </tr>
  </thead>
  <tbody>
      <?php $i=1; foreach($aggrement_list as $val){ ?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $val->agg_name;  ?></td>
      <td><?php echo $val->agg_phone;  ?></td>
      <td><?php echo $val->agg_email;  ?></td>
      <td><?php echo $val->agg_adrs; ?></td>
    <td><?php echo $val->agg_date; ?></td>
      <td>
 <!-- <a href="#modal7<?= $i?>" class="btn btn-success" data-toggle="modal" data-animation="effect-scale"><i class="fa fa-eye" aria-hidden="true"></i></a> -->
<?php if(!empty($val->file)){ ?>
<a href="<?php   echo base_url($val->file); ?>"  target="_blank"><i class="fa fa-file" aria-hidden="true" style="font-size:20px;margin-top:-30px;color:#10A3FF;"></i></a>
<?php } ?>
      </td>
    <td>
 <!-- <a href="#modal7<?= $i?>" class="btn btn-success" data-toggle="modal" data-animation="effect-scale"><i class="fa fa-eye" aria-hidden="true"></i></a> -->
<?php if(!empty($val->sign_file)){ ?>
<a href="<?php   echo base_url($val->sign_file); ?>"  target="_blank"><i class="fa fa-file" aria-hidden="true" style="font-size:20px;margin-top:-30px;color:#10A3FF;"></i></a>
<?php } ?>
      </td>
    </tr>

     <!--------------------------------Modal Popup for Amount----------------------------------------------------------------------------->
                      
      <div class="modal fade" id="modal7<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel6">Aggriment</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              Aggrement Here!
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          </div>
        </div>
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

<form class="" action="<?php echo base_url()?>client/generate_aggrement" method="post" enctype="multipart/form-data">
<div class="col-md-6" style="padding:20px;">
            <select class="form-control"  name="agg_frmt"  id="agg_frmt"> 
              <option>Select Format</option>
              <option value = "BAA">Bangalore-Australia-Agreement</option>
            </select>
</div>
<div class="col-md-6" style="padding:20px;">                                                
            <input class="btn btn-primary" type="submit" value="Genereate pdf" name="submit" >           
</div>
</form>
 
 <form class="" action="<?php echo base_url()?>client/create_aggrement/<?php echo $this->uri->segment(3); ?>" id="" method="post" enctype="multipart/form-data">
            <div class="col-md-12 col-sm-12">        
                  <div class="row">                      
                    <div class="form-group col-sm-10">
                          <label>If Details Are Same As Privious Data (Click Checkbox) <i class="text-danger"></i></label>
                        <input type="checkbox" name="agg_same" id="agg_same" value="<?php echo $this->uri->segment(3); ?>" onclick="myaggrement()" class="form-control">
                    </div>  
                      <div class="form-group col-sm-2"><a href="#modalagg" data-toggle="modal" class="btn" data-animation="effect-scale"><i class="fa fa-upload" aria-hidden="true"></i></a></div>
                    <div class="form-group col-sm-6">
                          <label>Name <i class="text-danger"></i></label>
                        <input type="text" id="agg_user" name="agg_user" value="" class="form-control">
                     </div>
                     
                     <div class="form-group col-sm-6">
                        <label>Mobile <i class="text-danger"></i></label>
                        <input type="text" id="agg_mobile" name="agg_mobile" value="" class="form-control"> 
                     </div>
                                                  
                     <div class="form-group col-sm-6">
                        <label>Email <i class="text-danger"></i></label>
                        <input type="text" id="agg_email" name="agg_email" value="" class="form-control"> 
                     </div>
                     
                     <div class="form-group col-sm-6">
                        <label>Address <i class="text-danger"></i></label>
                        <input type="text" id="agg_adrs" name="agg_adrs" value="" class="form-control"> 
                     </div>
           
           <div class="form-group col-sm-6">
                        <label>Agreement Date <i class="text-danger"></i></label>
                        <input type="date" id="agg_date" name="agg_date" value="" class="form-control"> 
                     </div>

<div class="col-md-12" style="padding:20px;">                                                
                              <input class="btn btn-success" type="submit" value="Submit" name="submit" >           
                           </div>

</div>

</div>
</form>

<!--------------------------------Modal Popup for Aggrement----------------------------------------------------------------------------->
                      
      <div class="modal fade" id="modalagg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
     
<form method="post" action="<?php echo base_url(); ?>client/upload_aggrement_team" enctype="multipart/form-data">
        <div class="modal-content tx-14">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel6">Upload Aggrement Here</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body col-sm-12">
              <input type="hidden" name="ide" value="<?php echo $this->uri->segment(3); ?>" class="form-control" placeholder="" required>
            <div class="form-group col-sm-6">
                <input type="file" name="file" class="form-control" placeholder="" required>
            </div>
            <div class="form-group col-sm-6">
            <div class="sgnbtn">
                <input id="signupbtn" type="submit" value="Submit" class="btn btn-primary"  name="Submit">
            </div>   
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
          </div>
        </div>
       </form>
      </div>
    </div>

<!-----------------------------------------------END------------------------------------>

<script>
function myaggrement() {
if (document.getElementById('agg_same').checked) 
  {
    var cdata=$("#agg_same").val();
     $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>client/find_same',
            data: {cdata:cdata},
         success:function(data){
            res = JSON.parse(data);
              if(res){              
                $("input[name='agg_user']").val(res.name_prefix + res.name  +' '+ res.lastname);
                $("input[name='agg_mobile']").val(res.phone);                
                $("input[name='agg_email']").val(res.email);
                $("input[name='agg_adrs']").val(res.address);              
              }
         }               
     });        
    }else{
                $("input[name='agg_user']").val('');
                $("input[name='agg_mobile']").val('');                
                $("input[name='agg_email']").val('');
                $("input[name='agg_adrs']").val('');  
    }      
}
</script>



</div>