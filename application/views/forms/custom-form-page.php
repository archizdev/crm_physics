<script src="https://cdn.jsdelivr.net/jquery.query-builder/2.3.3/js/query-builder.standalone.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.query-builder/2.3.3/css/query-builder.default.min.css">
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <h3>Custom Enquiry Form</h3>  
                </div>
            </div> 

            <div class="">
                <div class="row">             
                    <div class="">                   
                        <?php echo form_open_multipart('customer/create','class="form-inner"') ?> 

                            
                            <div class="row">
                                <div class="">
                    
                                    <div class="tab-content">
                                        <br />
                 
                                      <div id="cmp-custom_form" class="tab-pane active">
                                            <div class="row">
                                                
                                            </div>
                                      </div>
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
    $(function(){
        url = "<?=base_url().'form/form/enquiry_extra_field/'?>"+"<?= $comp_id?>";     
        $.ajax({
          type: "POST",
          url: url,      
          success: function(data){                
            $("#cmp-custom_form").html(data);
          }
        });
    }); 

</script>