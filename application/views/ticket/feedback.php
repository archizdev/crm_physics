<div class="row">
    <?= 
    $this->session->flashdata('form-data');
    ?>
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
 
            <div class="panel-heading no-print">
                <div class="btn-group"> 
                    <a class="btn btn-success" href="<?php echo base_url("feedback/create") ?>"> <i class="fa fa-plus"></i>  <?php echo display('feedback/create') ?> </a>                      
                </div>
            </div> 

            <div class="panel-body">
         
                <table id="enq_table2" class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>GC Number</th>
                            <th>GC Date</th>
                            <th>Booking Branch</th>
                            <th>Delivery Branch</th>
                            <th>Delivery Type</th>
                            <th>Payment Type</th>
                            <th>Articles</th>
                            <th>Actual Weight</th>
                            <th>ChargedWeight</th> 
                            <th>Consignor</th> 
                            <th>Consignee</th> 
                            <th>Consignor Contact No.</th> 
                            <th>Consignee Contact No.</th> 
                            <th>Current Status</th> 
                            <th>Vehicle No.</th> 
                            <th>CSO</th> 
                            <th>User Type</th>
                            <th>Person</th> 
                            <th>Contact</th> 
                            <th>Lead Pass To</th> 
                            <th>lead pass on</th> 
                            <th>Customer Feedback</th> 
                            <th>How are the services</th> 
                            <th>Is this first FTL or No</th> 
                            <th>Other locations where FTL service is required</th> 
                            <th>If using any other transporter</th> 
                            <th>Remarks on improvement required</th> 
                            <th>Response By</th> 
                            <th>Person Name</th> 
                            <th>Customer Feedback</th> 
                            <th>Feedback  on</th> 
                            <th><?php echo display('action') ?></th> 
                              </tr>
                    </thead>
                    <tbody>
                
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>
<script>
      $(document).ready(function() {
    
    $('#enq_table2').DataTable( {
        "ajax": "<?=base_url().'dashboard/loadFeedback'?>",
        "scrollX": true,
        // "columns": [
        //     { "data": "gc" },
        //     { "data": "gc_date" },
        //     { "data": "BookingBranch" },
        //     { "data": "DeliveryBranch" },
        //     { "data": "DeliveryType" },
        //     { "data": "PaymentType" },
        //     { "data": "Articles" },
        //     { "data": "ActualWeight" },
        //     { "data": "ChargedWeight" },
        //     { "data": "Consignor" },
        //     { "data": "Consignee" },
        //     { "data": "ConsignorContactNo" },
        //     { "data": "ConsigneeContactNo" },
        //     { "data": "CurrentStatus" },
        //     { "data": "vc" },
        //     { "data": "cso" },
        //     { "data": "type" },
        //     { "data": "name" },
        //     { "data": "contact" },
        //     { "data": "lead_pass_on" },
        //     { "data": "customer_feedback" },
        //     { "data": "How_are_the_services" },
        //     { "data": "Is_this_first_FTL_or_No" },
        //     { "data": "Other_locations_where_FTL_service_is_required" },
        //     { "data": "If_using_any_other_transporter" },
        //     { "data": "Remarks_on_improvement_required" },
        //     { "data": "Response_By" },
        //     { "data": "Action_Taken" },
        //     { "data": "contact" },
        //     { "data": "username" },
        //     { "data": "feedback" },
        //     { "data": "feedback_on" },
        //     { "data": "actions" }, 
        // ],
        dom: "<'row text-center'<'col-sm-12 col-xs-12 col-md-4'l><'col-sm-12 col-xs-12 col-md-4 text-center'B><'col-sm-12 col-xs-12 col-md-4'f>>tp", 
        // "lengthMenu": [[30, 60, 90, -1], [30, 60, 90, "All"]], 
        buttons: [  
            {extend: 'copy', className: 'btn-xs btn',exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }}, 
            {extend: 'csv', title: 'list<?=date("Y-m-d H:i:s")?>', className: 'btn-xs btn',exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }}, 
            {extend: 'excel', title: 'list<?=date("Y-m-d H:i:s")?>', className: 'btn-xs btn', title: 'exportTitle',exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }}, 
            {extend: 'pdf', title: 'list<?=date("Y-m-d H:i:s")?>', className: 'btn-xs btn',exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }}, 
            {extend: 'print', className: 'btn-xs btn',exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }} 
        ] ,
    } );
    } );
  
// $('#enq_table2').DataTable(
//         {         
//           "processing": true,
//           "scrollX": true,
//           "scrollY": 520,
//           "serverSide": true,          
//           "lengthMenu": [ [10,30, 50,100,500,1000, -1], [10,30, 50,100,500,1000, "All"] ],
//           "ajax": {
//               "url": "<?=base_url('dashboard/loadFeedback')?>",
//               "type": "POST",
//               "data":function(d){
//                 return d;
//               }
//           },
//           dom: "<'row text-center'<'col-sm-12 col-xs-12 col-md-4'l><'col-sm-12 col-xs-12 col-md-4 text-center'B><'col-sm-12 col-xs-12 col-md-4'f>>tp", 
//         // "lengthMenu": [[30, 60, 90, -1], [30, 60, 90, "All"]], 
//         buttons: [  
//             {extend: 'copy', className: 'btn-xs btn',exportOptions: {
//                         columns: "thead th:not(.noExport)"
//                     }}, 
//             {extend: 'csv', title: 'list<?=date("Y-m-d H:i:s")?>', className: 'btn-xs btn',exportOptions: {
//                         columns: "thead th:not(.noExport)"
//                     }}, 
//             {extend: 'excel', title: 'list<?=date("Y-m-d H:i:s")?>', className: 'btn-xs btn', title: 'exportTitle',exportOptions: {
//                         columns: "thead th:not(.noExport)"
//                     }}, 
//             {extend: 'pdf', title: 'list<?=date("Y-m-d H:i:s")?>', className: 'btn-xs btn',exportOptions: {
//                         columns: "thead th:not(.noExport)"
//                     }}, 
//             {extend: 'print', className: 'btn-xs btn',exportOptions: {
//                         columns: "thead th:not(.noExport)"
//                     }} 
//         ] ,
      
//           "columnDefs": [{ "orderable": false, "targets":0 }],
//            "order": [[ 1, "desc" ]],
//           createdRow: function( row, data, dataIndex ) {            
//             var th = $("table>th");            
//             l = $("table").find('th').length;
//             for(j=1;j<=l;j++){
//               h = $("table").find('th:eq('+j+')').html();
//               $(row).find('td:eq('+j+')').attr('data-th',h);
//             }                       
//         }
//       });
    //   });
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});
</script>