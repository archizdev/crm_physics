    <div class="tab-pane" id="qalification">
 <hr>
 

 
 <form class="" action="<?php echo base_url()?>client/create_qualification/<?php echo $this->uri->segment(3); ?>" id="" method="post" enctype="multipart/form-data">
<?php
if(!empty($qualification_data))
{
 foreach($qualification_data as $quali){ ?>
            <div class="col-md-12 col-sm-12">        
                  <div class="row">
<input type="hidden" class="form-control"  name="enquiryid" value="<?php if(!empty($quali->enq_id)){echo $quali->enq_id; }?>">
<div class="col-md-12">
<label style="color:#283593;">Class XII (H.S.C)<i class="text-danger"></i></label>
 <hr>
</div>
<div class="col-md-4">
            <label>From<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="xiipassfrom" value="<?php echo $quali->xiipassfrom; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>To<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="xiipassto" value="<?php echo $quali->xiipassto; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>Percentage<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="xiiper" value="<?php echo $quali->xiiper; ?>">
</div>
<div class="col-md-4">
            <label>Math/Bio<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="xiimb" value="<?php echo $quali->xiimb; ?>">
</div>
<div class="col-md-4">
            <label>English Marks<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="xiieng" value="<?php echo $quali->xiieng; ?>">
</div>
<div class="col-md-4">
            <label>Stream<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="xiistrm" value="<?php echo $quali->xiistrm; ?>">
</div>
<div class="col-md-4">
            <label>Spacialization<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="xiispec" value="<?php echo $quali->xiispec; ?>">
</div>


<div class="col-md-12" style="padding-top:20px;">
<label style="color:#283593;">Diploma<i class="text-danger"></i></label>
 <hr>
</div>

<div class="col-md-4">
            <label>From<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="dpassfrom" value="<?php echo $quali->dpassfrom; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>To<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="dpassto" value="<?php echo $quali->dpassto; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>Percentage<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="dper" value="<?php echo $quali->dper; ?>">
</div>
<div class="col-md-4">
            <label>Backlogs<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="dback" value="<?php echo $quali->dback; ?>">
</div>
<div class="col-md-4">
            <label>Diploma Types<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="dtype" value="<?php echo $quali->dtype; ?>">
</div>



<div class="col-md-12" style="padding-top:20px;">
<label style="color:#283593;">Bachelor Degree<i class="text-danger"></i></label>
 <hr>
</div>

<div class="col-md-4">
            <label>From<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="bpassfrom" value="<?php echo $quali->bpassfrom; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>To<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="bpassto" value="<?php echo $quali->bpassto; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>Percentage<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="bper" value="<?php echo $quali->bper; ?>">
</div>
<div class="col-md-4">
            <label>Backlogs<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="bback" value="<?php echo $quali->bback; ?>">
</div>
<div class="col-md-4">
            <label>Bachelor Types<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="btype" value="<?php echo $quali->btype; ?>">
</div>
<div class="col-md-4">
            <label>Spacialization<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="bspec" value="<?php echo $quali->bspec; ?>">
</div>


<div class="col-md-12" style="padding-top:20px;">
<label style="color:#283593;">Post Garduation/Master Degree<i class="text-danger"></i></label>
 <hr>
</div>

<div class="col-md-4">
            <label>From<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="pgpassfrom" value="<?php echo $quali->pgpassfrom; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>To<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="pgpassto" value="<?php echo $quali->pgpassto; ?>" style="line-height: 20px;">
</div>
<div class="col-md-4">
            <label>Percentage<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="pgper" value="<?php echo $quali->pgper; ?>">
</div>
<div class="col-md-4">
            <label>Backlogs<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="pgback" value="<?php echo $quali->pgback; ?>">
</div>
<div class="col-md-4">
            <label>Master Types<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="pgmtype" value="<?php echo $quali->pgmtype; ?>">
</div>
<div class="col-md-4">
            <label>Experience<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="pgexp" value="<?php echo $quali->pgexp; ?>">
</div>
<div class="col-md-4">
            <label>Job Profile<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="pgjob" value="<?php echo $quali->pgjob; ?>">
</div>


<div class="col-md-12" style="padding:20px;">                                                
            <input class="btn btn-success" type="submit" value="Submit" name="submit" >           
</div>

</div>

</div>
<?php }}
 ?>
</form>

            </div>