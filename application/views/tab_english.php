    <div class="tab-pane" id="english">
 <hr>
 

 
 <form class="" action="<?php echo base_url()?>client/create_english/<?php echo $this->uri->segment(3); ?>" id="" method="post" enctype="multipart/form-data">
 <?php
if(!empty($english_data))
{
  foreach($english_data as $eng){ ?>
            <div class="col-md-12 col-sm-12">        
                  <div class="row">

<input type="hidden" class="form-control"  name="enquiryid" value="<?php if(!empty($eng->enq_id)){echo $eng->enq_id; }?>">
<div class="col-md-12">
<label style="color:#283593;">International Exams<i class="text-danger"></i></label>
 <hr>
</div>
<div class="col-md-3">
            
            <input type="checkbox" class="form-control" id="yourCheckbox" placeholder="" name="ielts" value="IELTS"> <label>IELTS<i class="text-danger"></i></label>
</div>
<div class="col-md-3">
            <input type="checkbox" class="form-control pte" id="yourCheckbox1" placeholder="" name="pte" value="PTE"> <label>PTE<i class="text-danger"></i></label>
</div>



<div class="col-md-12" style="padding-top:20px;">
 <hr>
</div>
<div  class="ielts" style="display:none;">
<div class="col-md-12">
<label>IELTS<i class="text-danger"></i></label>
 <hr>
</div>
<div class="col-md-4">
            <input type="radio" class="form-control" placeholder="" name="ieltsappeard" value="1" checked> <label>Appeared<i class="text-danger"></i></label>
</div>
<div class="col-md-4">
            <input type="radio" class="form-control" placeholder="" name="ieltsappeard" value="2"> <label>Not Appeared<i class="text-danger"></i></label>
</div>

<div  class="hidden_div">

<div class="col-md-6">
            <label>Date<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="ieltsdt" style="line-height: 20px;" value="<?php if(!empty($eng->ieltsdate)){echo $eng->ieltsdate; }?>">
</div>
<div class="col-md-3">
            <label>Listening<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ieltslisten" value="<?php if(!empty($eng->ieltslisten)){echo $eng->ieltslisten; }?>">
</div>
<div class="col-md-3">
            <label>Reading<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ieltsread" value="<?php if(!empty($eng->ieltsread)){echo $eng->ieltsread; }?>">
</div>
<div class="col-md-3">
            <label>Writing<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ieltswrite" value="<?php if(!empty($eng->ieltswrite)){echo $eng->ieltswrite; }?>">
</div>
<div class="col-md-3">
            <label>Speaking<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ieltsspeak" value="<?php if(!empty($eng->ieltsspeak)){echo $eng->ieltsspeak; }?>">
</div>
<div class="col-md-6">
            <label>Final Band Score<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ieltsfinal" value="<?php if(!empty($eng->ieltsfinal)){echo $eng->ieltsfinal; }?>">
</div>
</div>
</div>



<div class="col-md-12" style="padding-top:20px;">
 <hr>
</div>
<div  class="pte" style="display:none;">
<div class="col-md-12">
<label>PTE<i class="text-danger"></i></label>
 <hr>
</div>
<div class="col-md-4">
            <input type="radio" class="form-control" placeholder="" name="pteappeard" value="1" checked> <label>Appeared<i class="text-danger"></i></label>
</div>
<div class="col-md-4">
            <input type="radio" class="form-control" placeholder="" name="pteappeard" value="2"> <label>Not Appeared<i class="text-danger"></i></label>
</div>

<div  class="hidden_div1">

<div class="col-md-6">
            <label>Date<i class="text-danger"></i></label>
            <input type="date" class="form-control" placeholder="" name="ptedt" style="line-height: 20px;"  value="<?php if(!empty($eng->ptedt)){echo $eng->ptedt; }?>">
</div>
<div class="col-md-3">
            <label>Listening<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ptelisten" value="<?php if(!empty($eng->ptelisten)){echo $eng->ptelisten; }?>">
</div>
<div class="col-md-3">
            <label>Reading<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="pteread" value="<?php if(!empty($eng->pteread)){echo $eng->pteread; }?>">
</div>
<div class="col-md-3">
            <label>Writing<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ptewrite" value="<?php if(!empty($eng->ptewrite)){echo $eng->ptewrite; }?>">
</div>
<div class="col-md-3">
            <label>Speaking<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ptespeak" value="<?php if(!empty($eng->ptespeak)){echo $eng->ptespeak; }?>">
</div>
<div class="col-md-6">
            <label>Final Band Score<i class="text-danger"></i></label>
            <input type="text" class="form-control" placeholder="" name="ptefinal" value="<?php if(!empty($eng->ptefinal)){echo $eng->ptefinal; }?>">
</div>
</div>
</div>
<div class="col-md-12" style="padding:20px;">                                                
            <input class="btn btn-success" type="submit" value="Submit" name="submit">           
</div>

</div>
</div>
 <?php } 
}
?>
</form>

            </div>
<script type="text/javascript">
$(document).ready(function() {
    $("input[name$='ieltsappeard']").click(function() {
        var test = $(this).val();
if(test=='2'){
        $("div.hidden_div").hide();
}else if(test=='1'){
	   $("div.hidden_div").show();
}
    });
}); 
</script>
<script type="text/javascript">
$('#yourCheckbox').change(function(){
  if($(this).prop("checked")) {
    $('div.ielts').show();
  } else {
    $('div.ielts').hide();
  }
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("input[name$='pteappeard']").click(function() {
        var test = $(this).val();
if(test=='2'){
        $("div.hidden_div1").hide();
}else if(test=='1'){
	   $("div.hidden_div1").show();
}
    });
}); 
</script>
<script type="text/javascript">
$('#yourCheckbox1').change(function(){
  if($(this).prop("checked")) {
    $('div.pte').show();
  } else {
    $('div.pte').hide();
  }
});
</script>