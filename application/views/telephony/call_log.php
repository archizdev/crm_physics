<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <div class="panel-heading no-print">                
                <div class="btn-group"> 
                    <a class="btn btn-success" href="javascript:void(0)" onclick="window.history.back();"> <i class="fa fa-arrow-left"></i> Back </a>  
                </div>                
            </div>       
            <div class="panel-body">    
                <div class="col-lg-12 ">
                    <?php
                    if($suc = $this->session->flashdata('SUCCESSMSG'))
                        echo '<div class="alert alert-success">'.$suc.'</div>';
                    ?>
                </div>
                <div class="col-lg-12">
                    <table class='table table-bordered' id='call_log'>
                        <thead> 
                            <tr>
                                <th>
                                    Call ID
                                </th>
                                <th>
                                    Agent No
                                </th>
                                <th>
                                    Recording
                                </th>
                                <th>
                                    Called No
                                </th>
                                <th>
                                    Call Duration
                                </th>
                                <th>
                                    Call Status
                                </th>
                                <th>
                                    Call Direction
                                </th>
                                <th>
                                    Call Time
                                </th>
                                <th>
                                    Created Date
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
 $(document).ready(function() {       
        var table  = $('#call_log').DataTable({         
            "processing": true,
            "scrollX": true,
            "scrollY": 520,
            "serverSide": true,          
            "lengthMenu": [ [10,30, 50,100,500,1000, -1], [10,30, 50,100,500,1000, "All"] ],
            "ajax": {
                "url": "<?=base_url().'Call_report/call_log_datatable'?>",
                "type": "POST"
            },
            dom: 'Bfrtip',
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]        
        
    });
});    
</script>