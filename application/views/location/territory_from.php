<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                <?php if (user_access(113)==true) {  ?>
                    <a class="btn btn-primary" href="<?php echo base_url("location/territory") ?>"> <i class="fa fa-list"></i>  <?php echo display('territory_list') ?> </a>  
              <?php } ?>
                    </div>
            </div> 

            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php 
                        
                        echo form_open_multipart('location/add_territory','class="form-inner" id="territory"') ?> 

                            <?php echo form_hidden('user_id',$doctor->territory_id) ?>
                            
                            <div class="form-group row">
                                <label  class="col-md-3 col-xs-12 col-form-label"><?php echo display('country_name')?> <i class="text-danger">*</i></label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control" name="country_id" onchange="find_region()" id="country_id">
                                         <option value="" selected>Select Country</option>
                                   <?php foreach($country as $c){ ?>
                                   <option value="<?php echo $c->id_c; ?>" <?php if($doctor->country_id==$c->id_c){echo 'selected';}?>><?php echo $c->country_name; ?></option>
                                   <?php } ?>
                                   </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label  class="col-md-3 col-xs-12 col-form-label"><?php echo display('region_name')?> <i class="text-danger">*</i></label>
                                <div class="col-md-9 col-xs-12">
                                    <select class="form-control" name="region_id" id="region_id">
                                  <?php foreach($region_list as $rl){ ?>
                                   
                                   <option value="<?php echo $rl->region_id; ?>" <?php if($doctor->region_id==$rl->region_id){echo 'selected';}?>><?php echo $rl->region_name; ?></option>
                                   <?php } ?>
                                   </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label  class="col-md-3 col-xs-12 col-form-label"><?php echo display('state_name')?> <i class="text-danger">*</i></label>
                                <div class="col-md-9 col-xs-12">
                                    
                                    <select class="form-control" name="state_id" id="state_id">
                                        <option value="" style="display:none">---Select---</option>
                                        <?php 
                                        foreach($state as $row){ ?>
                                            <option value="<?php echo $row->id ?>" <?php if ($row->state_id==$row->id) {  echo'selected';
                                            } ?>><?php echo $row->state; ?></option>
                                            
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="territory_name" class="col-md-3 col-xs-12 col-form-label"><?php echo display('territory_name')?> <i class="text-danger">*</i></label>
                                <div class="col-md-9 col-xs-12">
                                    <input name="territory_name" type="text" class="form-control" id="firstname" placeholder="<?php echo display('territory_name')?>" value="<?php echo $doctor->territory_name ?>" >
                                </div>
                            </div>
                               <div class="form-group row">
                                <label class="col-md-3 col-xs-12"><?php echo display('status') ?></label>
                                <div class="col-md-9 col-xs-12">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="1" <?php if ($doctor->status==1) {  echo'checked'; } echo  set_radio('status', '1', TRUE); ?> ><?php echo display('active') ?>
                                        </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="0" <?php  if ($doctor->status==0) {
                                          echo'checked';  } echo  set_radio('status', '0'); ?> ><?php echo display('inactive') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
            function find_region() {
       
                       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>location/get_region_byid',
            data: $('#territory').serialize()
            })
            .done(function(data){
            if(data!=''){
              document.getElementById('region_id').innerHTML=data;
            }else{
              document.getElementById('region_id').innerHTML='';   
            }
            })
            .fail(function() {
            
            });
            }
        </script>
        
        <script>
            
            $(function(){
                
                $("#region_id").change(function(){
                    
                    var region_id = $(this).val();
                    
                    var html='';
                    
                    $.ajax({
                        
                        url : '<?php echo base_url('location/select_state_by_region') ?>',
                        type: 'POST',
                        data: {region_id:region_id},
                        success:function(data){
                            
                            var obj = JSON.parse(data);
                            
                            html +='<option value="" style="display:none">---Select---</option>';
                            for(var i=0; i<(obj.length);i++){
                                
                                html +='<option value="'+(obj[i].id)+'">'+(obj[i].state)+'</option>';
                            }
                            
                            $("#state_id").html(html);
                            
                            
                        }
                        
                    });
                    
                });
                
                
            });
        
        </script>
