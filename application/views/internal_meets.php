<script src="http://demo.phpgang.com/lazy-loading-images-jquery/jquery.devrama.lazyload.min-0.9.3.js"></script> 

 <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" ></script>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

<link href="<?php echo base_url();?>assets/css/fullcalendar.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/fullcalendar.print.min.css" media="print">

<style type="text/css">
  .btnStatus{
    padding: 0px 4px !important;
    color: #fff !important;
    width: 79px!important; 
  }
  .Pending{
    background-color: #337ab7 !important;
    border-color: #337ab7 !important;
  }

  .Processing{
    background-color: #f2711c !important;
    border-color: #f2711c !important;
  }
  .Completed{
    background-color: #37a000 !important;
    border-color: #318d01 !important;
  }

  .Closed{
    background-color: #db2828 !important;
    border-color: #db2828 !important;
  }
  .Cancelled{
    background-color: #db2828 !important;
    border-color: #db2828 !important;
  }

</style>
<br>
<div class="col-md-12 text-center">     
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
      Add Meeting Schedules
    </button>
   </div>
<div class="col-md-12">
   <br>
   <div class="col-md-4"></div>   
     <div class="col-md-4">
        <select class="form-control" name="org_name" id="user_id_fortask" onchange="changes_menu(this.value)">
           <option value="" style="display:none;">--Select---</option>
           <?php foreach($user_list as $user){?>
           <option value="<?=$user->pk_i_admin_id ?>" <?php if($this->session->user_id==$user->pk_i_admin_id){echo 'selected';} ?>><?=$user->s_display_name ?>&nbsp;<?=$user->last_name; ?></option>
           <?php } ?>
        </select>
        <br>
     </div>   
</div>
<br>
<br>
<br>
<br>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document"> 
  <form action="<?php echo base_url('Appointment_new/staff_meet_add');?>" enctype="multipart/form-data" method="post">               
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Set Schedules</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">

          <div class="col-md-12">
            <label class="col-xs-4"></label>
            <div class="col-xs-6">
              <div class="form-check">
                <label class="radio-inline">
                <input type="radio" name="dayrange" value="1" checked> &nbsp;<?php echo display('single') ?>
                </label>
                <label class="radio-inline">
                <input type="radio" name="dayrange" value="0"> &nbsp;<?php echo display('multiple') ?>
                </label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-6 single">
              <label for="doctor_id" class="col-form-label"><?php echo display('date') ?></label>
              <input type="date" class="form-control" name='date[]' id="date" value="" style="padding-top: 0px;">
            </div>

<div class="multiple">                           
            <div class="form-group col-md-6" id="daterange1">
                  <label for="date">From</label>
                  <input type="date" class="form-control datepicker" name="fromdate[]" id="fromdate" style="padding-top: 0px;">
            </div>
            <div class="form-group col-md-6" id="daterange2">
                  <label for="date">To</label>
                  <input type="date" class="form-control datepicker" name="todate[]" id="todate" style="padding-top: 0px;">
            </div>
</div>

            <div class="form-group col-md-6" id="datetimepicker1">
                  <label for="stm">Start Time</label>
                  <input type="time" class="form-control" name="stm[]" id="stm" value="" placeholder="Start Time" required style="padding-top: 0px;">
            </div>
            <div class="form-group col-md-6">
                  <label for="etm">End Time</label>
                  <input type="time" class="form-control" name="etm[]" id="etm" value="" placeholder="End Time" required style="padding-top: 0px;">
            </div>
          </div>
          <br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create Schedules</button>
      </div>
    </div>
      </form>
  </div>
</div>


<div class="card-body">
      <div class="col-md-12">
         <div id="calendar" style="width:100%"></div>
         <br><br>
      </div>
         
   </div>
<div class="col-md-12"  style="background-color:#fff;" id="task_div1">
  <table class="table table-striped table-bordered" id="content_tabss">
     <thead>
        <tr>
           <th>Meeting Date</th>
           <th>Timing</th>
           <th>Student Name</th>
           <th>Student Mobile</th>
           <th>Student Email</th>
           <th>Booking Status</th>           
           <th>Zoin Status</th>
        </tr>
     </thead>
     <tbody>
     </tbody>
   </table>  
</div>
<br>
</div> 
</div>


<script>
$(document).ready(function(){
    $("div.single").show();
    $("div.multiple").hide();
    $("input[name$='dayrange']").click(function(){
        var test = $(this).val();
            if(test=='1'){
                $("div.multiple").hide();
                $("div.single").show();
            }else{
               $("div.multiple").show();
               $("div.single").hide();  
            }
    });
});
</script>

<script>

    var table  = $('#content_tabss').DataTable( {         
        "processing": true,
        //"scrollX": true,
        //"scrollY": 800,
        "serverSide": true,
        "lengthMenu": [ [10,20,30,40, 50, -1], [10,20,30,40,50, "All"] ],
        "ajax": {
            "url": "<?=base_url().'Appointment_new/meetings_load'?>",
            "type": "POST",
            "data": {
              //"filter_user_id": $("#user_id_fortask").val()
            }
        },
        
    } );

   function changes_menu(id){ 
      var events = {
        url: "<?php echo base_url().'Appointment_new/get_calandar_feed'?>",
        type: 'POST',
        data: {
            start: $('#calendar').fullCalendar('getView').start,
            end: $('#calendar').fullCalendar('getView').end,
            user_id: id
        }
      }
      //remove old data
      $('#calendar').fullCalendar('removeEvents');       
      //Getting new event json data
      $("#calendar").fullCalendar('addEventSource', events);
      //Updating new events
      $('#calendar').fullCalendar('rerenderEvents');      
      table.ajax.reload();
   }

</script>

<script type='text/javascript'>   
   $(function () {
    $('#calendar').fullCalendar({
       header    : {
         left  : 'prev,next today',
         center: 'title',
         right : 'month,agendaWeek,agendaDay'
       },
       buttonText: {
         today: 'today',
         month: 'month',
         week : 'week',
         day  : 'day'
       },
       //Random default events
       
       events    : function(start, end, timezone, callback) {
        jQuery.ajax({
            url: "<?php echo base_url().'Appointment_new/get_calandar_feed'?>",
            type: 'POST',
            dataType: 'json',
            data: {
                start: start.format(),
                end: end.format()
            },
            success: function(doc) {
                var events = doc;                
                callback(events);
            }
        });
    }
       ,
       dayClick:function(date,isEvent,view,resourseobj){
         $('td').dblclick(function(){           
        }); 
         
         ser_date = date.format();

                     $.ajax({
                      type: 'POST',
                      url: '<?php echo base_url();?>Appointment_new/search_meetings/'+ser_date,
                     })
                     .done(function(data){
                       
                         $("#task_div1").html(data);
                     })
   
        
       },
   
     })
     });

   
</script>



<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>

<script src="<?php echo base_url();?>assets/js/fullcalendar.min.js"></script>

<script src="<?php echo base_url();?>assets/js/moment.js"></script>