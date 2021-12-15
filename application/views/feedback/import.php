<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-primary" href=""> <i class="fa fa-list"></i>  <?php echo display('import') ?> </a>  
                </div>
            </div> 
             <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('dashboard/import_feedback','class="form-inner"') ?> 
                             <div class="form-group row">
                                <label for="city_name" class="col-xs-3 col-form-label"><?php echo display('import')?><i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="file" type="file" >
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
                    <div class="col-md-3"><span><a href="<?php echo base_url(); ?>assets/csv/location.csv">Download sample(.csv only)</a></span></div>
                </div>
            </div>
        </div>
    </div>
</div>

