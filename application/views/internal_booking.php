<!DOCTYPE html>
<html lang="en" class=" sizes customelements history pointerevents postmessage webgl websockets cssanimations csscolumns csscolumns-width csscolumns-span csscolumns-fill csscolumns-gap csscolumns-rule csscolumns-rulecolor csscolumns-rulestyle csscolumns-rulewidth csscolumns-breakbefore csscolumns-breakafter csscolumns-breakinside flexbox picture srcset webworkers"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include('ktagmanagercodeHeader.php');?>
    <link rel="stylesheet" href="<?= base_url('assets_web1/css/')?>bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets_web1/css/')?>main.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>assets_web1/images/ukuni.png">

<!--For Calander Start-->
<script src="<?= base_url('assets/js/')?>jquery.min.js?v=1.0" type="text/javascript"></script> 
<link href="<?= base_url('assets/css/')?>fullcalendar.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/')?>fullcalendar.print.min.css" media="print">

<!--For Calander End-->

    <title>Uroadshow Meetings</title>
</head>
<body>
    <?php include('ktagmanagerbodycode.php');?>
    <!-- ==========Preloader========== -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ==========Preloader========== -->
         <header class="header-section">
            <div class="header-wrapper" style="margin-left:40px;margin-right:40px;">
                <div class="logo">
                    <a href="">
                      <img src="<?= base_url('assets_web1/images/')?>ukuni.png" style="width: 60px;height: 45px;">
                    </a>
                </div>

                <ul class="menu">
                    <li id="nav"><a href="<?= base_url()?>" class="active">Home</a></li>
                    <li><a href="<?= base_url()?>#aboutus">About US</a></li>
                    <li><a href="<?= base_url()?>#services">Exhibitors</a></li>            
                    <li><a href="<?= base_url()?>#howwork">How does it work</a></li> 
                    <li><a href="<?= base_url()?>#uevent">Upcoming Event</a></li>
                    <li><a href="<?= base_url()?>#contact">Get In Touch</a></li>
                </ul>
                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
    </header>
    
    
    <!-- ==========Four-Not-Four-Section========== -->
 <style type="text/css">
.contact-container .bg-thumb {
    top: 0;
    right: 0;
    width: calc(42% - 15px) !important;
    height: 100%;
}
.fc-corner-left{
    width:50px !important;
    float: left !important;
}
.fc-corner-right{
    width:50px !important;
    float: left !important;
}
.fc-today-button{
  width:100px !important;  
}
.fc-month-button{
  width:100px !important;
  float: left !important;  
}
.fc-agendaWeek-button{
  width:100px !important;
  float: left !important;  
}
.fc-agendaDay-button{
  width:100px !important;
  float: left !important;  
}
.fc-center h2{
    font-size: 30px !important;
}
 </style>   
   <section class="contact-section padding-bottom" id="contact">
        <div class="contact-container">
            <div class="bg-thumb bg_img" data-background="<?=base_url('assets_web1/images/')?>contact.jpg"></div>
            <div class="container-fluid">
                <div class="row justify-content-between">

                <div class="col-md-7 padding-top">
                    <div id="calendar" style="width:100%"></div>
                </div>

                <div class="col-md-5 padding-bottom">
                    <div class="contact-info">                    
                    <div class="account-area" style="margin: 165px auto !important;">
<div id="loading" style="display: none;">
        <p><img src="<?=base_url()?>assets_web1/images/loader.gif" /> Please Wait</p>
</div>
                    <div class="section-header-3">
                        <span class="cate">Book Schedule </span>
                        <h2 class="title"></h2>
                    </div>

                    <form class="account-form tmslt_form" method="post" autocomplete="off">

                        <input type="hidden" name="staff_id" id="user_type" value="<?php echo $staff_id; ?>">
                        <input type="hidden" name="student_id" id="user_type" value="<?php echo $student_id; ?>">

                        <div class="form-group">

                          <label for="crs">Select Date <span>*</span></label>
                          <input class="form-control" type="date" name="meet_date" id="meet_date" onchange="find_slot('<?php echo $staff_id; ?>')">  

                        </div>

                        <div class="form-group">
                                
                                <label for="tmslt">Choose Timeslot <span>*</span></label>
                                <select name="tmslt" id="tmslt" class="tmslt form-control" style="color:black;">
                                       
                                </select>

                        </div>

                        <div class="form-group text-center" id="bookbt">
                            <input type="submit" value="Book Now">
                        </div>

                    </form>

                </div>        

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>   
    <!-- ==========Four-Not-Four-Section End========== -->
 <footer class="footer-section" style="background: #02003b;">
       
        <div class="container">
           
            <div class="footer-bottom">
                <div class="left">
                    <center><p style="color:#fff;">Copyright © 2020.All Rights Reserved By <a href="#0" style="color:#eb1e25;">U ROAD SHOW</a></p></center>
                </div>
                <div class="footer-bottom-area">
                    
                   
                </div>
            </div>
        </div>
    </footer>

<!-- ==========Calander-Section Start========== -->


<script type='text/javascript'>

function find_slot(id) { 
            var cdate = $("#meet_date").val();
var cdatee = btoa(cdate);
            // alert(id);
            $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>website/home/read_slot/'+cdatee+'/'+id,
            
            success:function(data){
                var obj = JSON.parse(data);
                var html='';
                    
                    
                html +='<option value="">------Select Timeslot---------</option>';
                    for(var i=0; i <(obj.length); i++){
                        html +='<option value="'+(obj[i].id)+'">'+(obj[i].stm)+'</option>';
                    }
                    
                    $("#tmslt").html(html);               
            }           
            });
            }

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
            url: "<?= base_url('website/home/get_calandar_feed')?>",
            type: 'POST',
            dataType: 'json',
            data: {
                start: start.format(),
                end: end.format(),
                user_id: '<?php echo $staff_id; ?>'
            },
            success: function(doc) {
                var events = doc;                
                callback(events);
            }
        });
    }
   
     })
     });
  
</script>
<script type="text/javascript">

    function showLoader()
    {
        $("#loading").css("display","block");
    }

    function hideLoader()
    {
        $("#loading").css("display","none");
    }

    $(document).on("submit", ".tmslt_form", function (e) {
        if($("#tmslt").val() != "")
        {   
            showLoader();
            e.preventDefault();
            $.ajax({
                url: "<?=base_url('website/home/book_an_apnt');?>",
                type: 'POST',
                dataType: 'json',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data)
                {   
                    hideLoader();
                    if(data.status != "fail")
                    {   
                        swal({
                            title: "success",
                            text: data.msg,
                            icon: "success",
                                    
                        });
                    }
                    else
                    {
                        swal({
                            title: "error",
                            text: data.error,
                            icon: "error",
                                    
                        });
                    }
                    
                }
            });
        }
        else
        {
            swal("error","Please Choose One Meeting Timeslot!");
            return false;
        }
    
    });
</script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
<script src="<?= base_url('assets/js/')?>fullcalendar.min.js"></script>
<script src="<?= base_url('assets/js/')?>moment.js"></script> 
<!-- ==========Calander-Section End========== --> 

    <script src="<?= base_url('assets_web1/js/')?>bootstrap.min.js"></script>
    <script src="<?= base_url('assets_web1/js/')?>main.js"></script>

</body></html>